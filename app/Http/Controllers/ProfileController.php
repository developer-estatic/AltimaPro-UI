<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Country;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $countries = Country::all();
        return view('profile.edit', [
            'user' => $request->user(),
            'countries' => $countries,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): \Illuminate\Http\JsonResponse
    {
        $user = auth()->user();
        $request->user()->fill($request->validated());

        if ($request->hasFile('avatar')) {
            try {
                $old = $user->avatar;
                $user->avatar = fileUploader($request->avatar, getFilePath('userProfile'), getFileSize('userProfile'), $old);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => 'Oops! Avatar cannot be updated. <br> Incident ID: ' . log_incident($e), 'type' => 'Error!'], 200);
            }
        }

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();
        return response()->json(['success' => true, 'message' => 'Profile updated successfully.', 'type' => 'Success!'], 200);
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', ['password' => ['required', 'current_password'],]);
        $user = $request->user();

        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function changePassword(ChangePasswordRequest $request): \Illuminate\Http\JsonResponse
    {
        $request->validated();

        // Check if the current password matches
        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return response()->json(['success' => false, 'message' => 'The current password is incorrect.', 'type' => 'Failed!'], 201);
        }

        $request->user()->update(['password' => Hash::make($request->new_password),]);
        return response()->json(['success' => true, 'message' => 'Password updated successfully.', 'type' => 'Success!'], 200);

    }

}
