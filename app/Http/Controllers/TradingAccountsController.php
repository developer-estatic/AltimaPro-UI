<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClientUser;

class TradingAccountsController extends Controller
{
    public function __construct() {}

    public function index()
    {
        $params = [
            // Basic selections
            'select' => ['*'],
            // 'select' => ['id', 'name', 'email', 'created_at'],
            // 'select_raw' => ["CONCAT(first_name, ' ', last_name) as full_name"],

            // Relations
            'with' => [
                'crm_user' => [
                    'columns' => ['*'],
                    // 'columns' => ['id', 'name', 'email'],
                    // 'foreign_key' => 'account_id',
                    // 'local_key' => 'account_id',
                ],
                // Nested Relationship
                // 'crmUser.orders' => [
                    // 'columns' => ['id', 'order_number', 'amount'],
                // ],
            ],

            // Simple where conditions
            'where' => [
                // ['column' => 'status', 'operator' => '=', 'value' => 'active'],
                // ['column' => 'created_at', 'operator' => '>=', 'value' => '2023-01-01'],
            ],

            // Like conditions
            'where_like' => [
                ['column' => 'unique_id'],
                ['column' => 'crm_user.email'],
                // ['column' => 'name', 'value' => 'John%'],
            ],

            // OR conditions
            // 'where_or' => [
            //     ['column' => 'account_type', 'operator' => '=', 'value' => 'PREMIUM'],
            //     ['column' => 'account_type', 'operator' => '=', 'value' => 'VIP'],
            // ],

            // Between conditions
            // 'where_between' => [
                // ['column' => 'created_at'],
                // ['column' => 'amount', 'values' => [100, 500]],
            // ],

            // Raw where conditions
            // 'where_raw' => [
            //     "YEAR(created_at) = 2023",
            //     "DATEDIFF(NOW(), last_login) <= 30"
            // ],

            // Relationship conditions
            // 'where_has' => [
            //     'crmUser' => [
            //         ['column' => 'is_active', 'operator' => '=', 'value' => 1],
            //     ]
            // ],

            // Complex nested relationship conditions
            // 'nested_where_has' => [
            //     [
            //         'relation' => 'crmUser',
            //         'where' => [
            //             ['column' => 'is_active', 'operator' => '=', 'value' => 1]
            //         ],
            //         'nested' => [
            //             'relation' => 'orders',
            //             'where' => [
            //                 ['column' => 'status', 'operator' => '=', 'value' => 'completed']
            //             ]
            //         ]
            //     ]
            // ],

            // Subquery conditions
            // 'where_exists' => [
            //     [
            //         'query' => function ($query) {
            //             $query->select(\DB::raw(1))
            //                   ->from('orders')
            //                   ->whereRaw('orders.client_id = client_users.id')
            //                   ->where('orders.status', 'completed');
            //         }
            //     ]
            // ],

            // Joins
            // 'joins' => [
            //     [
            //         'type' => 'left',
            //         'table' => 'orders',
            //         'first' => 'orders.client_id',
            //         'operator' => '=',
            //         'second' => 'client_users.id',
            //         'where' => [
            //             ['column' => 'orders.created_at', 'operator' => '>=', 'value' => '2023-01-01']
            //         ]
            //     ],
            // ],

            // Grouping and aggregates
            // 'group_by' => ['user_id', 'status'],
            // 'aggregate' => [
            //     'count' => ['column' => '*', 'as' => 'total_records'],
            //     'sum' => ['column' => 'amount', 'as' => 'total_amount'],
            // ],
            // 'having' => [
            //     ['column' => 'COUNT(*)', 'operator' => '>', 'value' => 5],
            // ],

            // Sorting
            'sort_by' => ['column' => 'unique_id', 'sort_order' => 'asc'],
            // ['column' => 'name', 'direction' => 'asc'],

            //
            // 'multiple_sort' => [
            //     ['column' => 'status', 'direction' => 'asc'],
            //     ['column' => 'created_at', 'direction' => 'desc'],
            // ],
            // 'order_by_raw' => "FIELD(status, 'active', 'pending', 'inactive')",

            // Pagination
            'page' => 1,
            'per_page' => 10
        ];

        $class = app(ClientUser::class);

        return view('trading-accounts')->with([
            'tableHeadColumnsAndDataKeys' => $this->tableHeadColumnsAndDataKeys(),
            'table' => $class,
            // 'data' => json_encode($data->toArray())
            'conditions' => $params
        ]);
    }

    protected function tableHeadColumnsAndDataKeys()
    {
        return [
            // Define table columns for the view
            'checkbox' => [
                'data_key' => 'id',
            ],
            'TP Account Number' => [
                'sortable' => true,
                'initial_sort' => true,
                'sort_dir' => 'asc',
                'table_head_filter' => false,
                'data_key' => 'unique_id',
                'is_link' => true
            ],
            'Email' => [
                'sortable' => true,
                'initial_sort' => false,
                'sort_dir' => 'asc',
                'table_head_filter' => false,
                'data_key' => 'crm_user.email',
                'extra' => [
                    'icons' => [
                        // array key should be icon name or icon class like fa fa or like
                        // icon-[oui--email] from iconify
                        'icon-[oui--email]' => [
                            // for color, bg color, margin, padding, border radius etc
                            // fully qualified tailwind classes
                            'classes' => 'text-endeavour-400 w-4 h-4'
                        ],
                        'icon-[line-md--phone]' => [
                            'classes' => 'text-endeavour-400 w-4 h-4'
                        ],
                    ]
                ],
            ],
            'Client Name' => [
                'sortable' => true,
                'initial_sort' => false,
                'sort_dir' => 'asc',
                'table_head_filter' => false,
                'data_key' => 'crm_user.full_name',
                'left_filter' => [
                    'view_name' => 'checkbox',
                    // in what order it show in sidebar filters
                    'order' => 1,
                    'has_select_all' => true,
                    'heading'=> 'Clients',
                    // because of user can check multiple checkboxes
                    // that's why in database the whereIn condition will search
                    // for data
                    // for other components, you can modify this
                    'operator' => 'whereIn'
                ],
                'extra' => [
                    'has_initials' => [
                        // for color, bg color, margin, padding, border radius etc
                        // fully qualified tailwind classes
                        'classes' => 'bg-endeavour-950 rounded-full w-8 h-8 text-center px-2 py-1 text-white'
                    ]
                ]
            ],
            'Created On' => [
                'sortable' => true,
                'initial_sort' => false,
                'sort_dir' => 'asc',
                'table_head_filter' => false,
                'left_filter' => [
                    'view_name' => 'created_on',
                    'order' => 3,
                    'has_select_all' => false,
                    'heading'=> 'Created On',
                    'operator' => 'whereBetween'
                ],
                'data_key' => 'created_at',
            ],
            'Currency' => [
                'sortable' => true,
                'initial_sort' => false,
                'sort_dir' => 'asc',
                'table_head_filter' => false,
                'data_key' => 'currency',
            ],
            'Leverage' => [
                'sortable' => true,
                'initial_sort' => false,
                'sort_dir' => 'asc',
                'table_head_filter' => false,
                'data_key' => 'leverage',
            ],
            'Platform Name' => [
                'sortable' => true,
                'initial_sort' => false,
                'sort_dir' => 'asc',
                'table_head_filter' => false,
                'data_key' => 'crm_user.website_name',
            ],
            'Total Withdrawl' => [
                'sortable' => true,
                'initial_sort' => false,
                'sort_dir' => 'asc',
                'table_head_filter' => false,
                'data_key' => 'crm_user.sumofwithdrawal',
            ],
            'Total Deposit' => [
                'sortable' => true,
                'initial_sort' => false,
                'sort_dir' => 'asc',
                'table_head_filter' => false,
                'data_key' => 'crm_user.sumofdeposit',
            ],
            'Owner' => [
                'sortable' => true,
                'initial_sort' => false,
                'sort_dir' => 'asc',
                'table_head_filter' => false,
                'data_key' => 'crm_user.ownername',
                'left_filter' => [
                    'view_name' => 'selectbox',
                    'order' => 2,
                    'has_select_all' => true,
                    'heading'=> 'Owner',
                    // because of user can select multiple options
                    // that's why in database the whereIn condition will search
                    // for data
                    // for other components, you can modify this
                    'operator' => 'whereIn',
                ],
            ],
            'Type' => [
                'sortable' => true,
                'initial_sort' => false,
                'sort_dir' => 'asc',
                'table_head_filter' => false,
                'data_key' => 'account_type',
            ],
        ];
    }
}
