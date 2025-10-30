<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ChangePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'current_password' => 'required',
            'new_password' => 'required|same:new_password_confirmation|min:8|regex:"^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[@$!%*#?&]).*$"',
            'new_password_confirmation' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'current_password.required' => __('validation.changePassword.currentPassword.required'),
            'new_password.required' => __('validation.changePassword.newPassword.required'),
            'new_password_confirmation.required' => __('validation.changePassword.confirmPassword.required'),
            'new_password.same' => __('validation.changePassword.newPassword.same'),
            'new_password.min' => __('validation.profileUpdate.password.min'),
            'new_password.regex' => __('validation.profileUpdate.password.regex'),
        ];
    }
}
