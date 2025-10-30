<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\BusinessUnit;
use App\Models\Country;
use App\Models\ModelHasRole;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\DataTables\UsersDataTable;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function index(UsersDataTable $dataTable)
    {
        return $dataTable->render('user_management.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $roles = Role::pluck('name', 'name')->all();
        $businessUnits = BusinessUnit::all();
        $countries = Country::all();
        return view('user_management.create', compact('roles', 'businessUnits', 'countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserCreateRequest $request): \Illuminate\Http\JsonResponse
    {
        $request->validated();
        Log::debug('Form validation has been passed on store.');

        $input = $request->all();

        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);
        Log::info('New User has been created: ' . json_encode($user));

        $user->assignRole($request->input('roles'));
        Log::warning($request->input('roles') . ' role has been assigned to user: ' . $user->name);

        return response()->json(['success' => true, 'message' => 'User created successfully.', 'type' => 'Success!'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): View
    {
        $user = User::find($id);
        return view('user_management.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id): View
    {
        $user = User::find($id);
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();
        $businessUnits = BusinessUnit::all();
        $countries = Country::all();

        return view('user_management.edit', compact('user', 'roles', 'userRole', 'businessUnits', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, $id): \Illuminate\Http\JsonResponse
    {
        $request->validated();
        Log::debug('Form validation has been passed on update.');

        $input = $request->all();

        $user = User::find($id);
        if ($input['password'] && Hash::make($input['password']) != $user->password) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, ['password', 'confirm_password']);
        }

        $user->update($input);
        Log::info('User has been updated: ' . json_encode($user));

        ModelHasRole::where('model_id', $id)->delete();
        $user->assignRole($request->input('roles'));
        Log::info('User role has been updated: ' . json_encode($user));

        return response()->json(['success' => true, 'message' => 'User updated successfully.', 'type' => 'Success!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): RedirectResponse
    {
        User::find($id)->delete();
        Log::info('User has been deleted: ' . json_encode($id));
        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }

    public function changeStatus(Request $request)
    {
        if ($request->status) {

            $status = $request->status;
            $userIds = json_decode($request->userIds);

            User::whereIn('id', $userIds)->update(['status' => $status]);

            return response()->json(['success' => true, 'message' => 'Users status updated successfully.', 'type' => 'Success!'], 200);
        } else {
            return response()->json(['success' => false, 'message' => 'Please select status.', 'type' => 'Error!'], 200);
        }
    }
}
