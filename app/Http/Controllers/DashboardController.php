<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Country;
use Illuminate\Support\Facades\Crypt;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {
        return view('dashboard');
    }

    public function getTemplate(Request $request)
    {
        $type = $request->get('type');
        $typeId = $request->get('typeId');

        if ($type == 'change-password') {
            return view('profile.change_password');
        }

        if ($type == 'view-profile') {
            return view('profile.view');
        }

        if ($type == 'edit-profile') {
            return view('profile.edit');
        }

        if ($type == 'user-add') {
            return view('user_management.create');
        }

        if ($type == 'user-edit') {
            $typeId = decrypt($typeId);
            $user = User::with('roles')->find($typeId);
            return view('user_management.edit', ['user' => $user]);
        }

        if ($type == 'change-status') {
            $userIds = $typeId;
            return view('user_management.status', ['userIds' => $userIds]);
        }

        return view('profile.view');
    }
    public function getCountryCode(Request $request) {

        $countryId = $request->get('countryId');
        $country = Country::find($countryId);

        return $country;
    }

}
