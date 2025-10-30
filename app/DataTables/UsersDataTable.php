<?php

namespace App\DataTables;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Auth;

class UsersDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))

            ->addColumn('checkbox', function ($query) {
                $editPermission = auth()->user()->can('users.edit') ? 'dt-user' : '';
                return '<input type="checkbox" name="checkUser" value="'.$query->id.'" class="'.$editPermission.'">';
            })
            ->editColumn('first_name', function ($query) {
                // Get first letters of first and last name for avatar
                $nameParts = explode(' ', trim($query->name));
                $initials = '';
                if (count($nameParts) >= 2) {
                    $initials = strtoupper(substr($nameParts[0], 0, 1) . substr($nameParts[1], 0, 1));
                } else {
                    $initials = strtoupper(substr($query->name, 0, 2));
                }
                
                $avatar = '<span class="user-avatar">'.$initials.'</span>';
                
                if(auth()->user()->can('users.edit'))
                    return $avatar.'<a class="text-blue crm-show-right-side-bar" data-type="user-edit" data-id="'.encrypt($query->id).'" href="javascript:void(0)">'.$query->name.'</a>';
                else
                    return $avatar.$query->name;
            })
            ->editColumn('email', function ($query) {
                return '<i class="fa fa-envelope email-icon"></i>'.$query->email;
            })
            ->addColumn('role', function ($query) {
                return $query->getRoleNames()->first();
            })
            ->orderColumn('role', function($query, $order){
                $query->select('users.*', 'business_units.id as buid', 'business_units.name as buname', 'roles.name as role_name')
                ->orderBy('role_name', $order);
            })
            ->addColumn('business_unit', function ($query) {
                return $query->buname;
            })
            ->orderColumn('business_unit', function($query, $order){
                return $query->select('users.*', 'business_units.id as buid', 'business_units.name as buname')
                ->orderBy('buname', $order);
            })
            ->editColumn('status', function ($query) {
                if(auth()->user()->can('users.edit'))
                    return '<a class="crm-show-right-side-bar" data-type="user-edit" data-id="'.encrypt($query->id).'" href="javascript:void(0)">'.ucfirst(strtolower($query->status)).'</a>';
                else
                    return ucfirst(strtolower($query->status));
            })
            ->editColumn('login_time', function ($query) {
                return ($query->userLog) ? date('Y-m-d h:i A', strtotime($query->userLog->created_at)) : '';
            })
            ->editColumn('logout_time', function ($query) {
                return ($query->userLog) ? date('Y-m-d h:i A', strtotime($query->userLog->updated_at)) : '';
            })
            ->editColumn('login_ip', function ($query) {
                return ($query->userLog) ? $query->userLog->user_ip : '';
            })
            ->editColumn('created_at', function ($query) {
                return date('Y-m-d h:i A', strtotime($query->created_at->inUserTimezone()));
            })
            ->rawColumns(['checkbox', 'first_name', 'email', 'status'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(User $model): QueryBuilder
    {
        return $model->newQuery()
            ->select('users.*', 'business_units.id as buid', 'business_units.name as buname', 'roles.name as role_name')
            ->leftjoin('business_units', 'users.business_unit_id', '=', 'business_units.id')
            ->leftjoin('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->leftjoin('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->whereNot('users.id', Auth::id())
            ->whereHas("roles", function($q) {
                $userRole = Auth::user()->roles[0];
                $q->where('users.id', '>', $userRole->parent_id);
            })
        ;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        $query = $this->builder()
            ->setTableId('users-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(9, 'desc')
            ->pageLength(20)
            ->lengthMenu([[20, 50, 100, -1], [20, 50, 100, 'All']])
            ->dom('<"top"lf>rt<"bottom"ip><"clear">')
            ->buttons([])
            ->languageSearch("")
            ->parameters([
                'pagingType' => 'full_numbers',
                'orderMulti' => false, // Single column sorting only
                'scrollY' => '500px', // Fixed height for vertical scrolling
                'scrollCollapse' => true, // Allow table to reduce in height
                'lengthChange' => true, // Show entries dropdown
                'searching' => true, // Enable search
                'ordering' => true, // Enable sorting
                'info' => true, // Show table info
                'language' => [
                    'lengthMenu' => 'Show _MENU_ entries',
                    'info' => 'Showing _START_ to _END_ of _TOTAL_ entries',
                    'infoEmpty' => 'Showing 0 to 0 of 0 entries',
                    'infoFiltered' => '(filtered from _MAX_ total entries)',
                    'search' => '',
                    'searchPlaceholder' => 'Search',
                    'paginate' => [
                        'first' => '«',
                        'last' => '»',
                        'next' => '›',
                        'previous' => '‹'
                    ]
                ]
            ]);
            if(auth()->user()->can('users.create')) {
                $query->initComplete('function() {
                    var addUserBtn = `<a class="crm-show-right-side-bar add-user-btn" href="javascript:void(0)" data-type="user-add"><i class="fa-solid fa-user-plus fa-lg text-neutral-color"></i></a>`;
                    $(addUserBtn).appendTo("#users-table_filter");
                }');
            }
            return $query;
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('checkbox')
                ->title('<input type="checkbox" id="select-all-users" name="" value="">')
                ->addClass('text-center')
                ->orderable(false)
                ->searchable(false),
            Column::make('first_name')->title(__('Name')),
            Column::make('email')->title(__('Email')),
            Column::make('role')->title(__('Role')),
            Column::make('business_unit')->title(__('Business Unit')),
            Column::make('login_time')->title(__('Login Time'))->orderable(false)->searchable(false),
            Column::make('logout_time')->title(__('Logout Time'))->orderable(false)->searchable(false),
            Column::make('login_ip')->title(__('Login IP'))->orderable(false)->searchable(false),
            Column::make('status')->title(__('Status')),
            Column::make(data: 'created_at')->title(__('Created On')),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Users_' . date('YmdHis');
    }
}
