<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserCreateRequest extends FormRequest
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
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm_password|min:8|regex:"^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[@$!%*#?&]).*$"',
            'phone' => 'required|unique:users|regex:/^\+\d{1,3}\s?(\d\s?){11,11}$/',
            'country_id' => 'required',
            'roles' => 'required',
            'business_unit_id' => 'required',
            'status' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.required' => __('validation.user.firstName.required'),
            'last_name.required' => __('validation.user.lastName.required'),
            'email.required' => __('validation.user.email.required'),
            'email.email' => __('validation.user.email.email'),
            'email.unique' => __('validation.user.email.unique'),
            'password.required' => __('validation.user.password.required'),
            'password.same' => __('validation.user.password.same'),
            'password.regex' => __('validation.user.password.regex'),
            'phone.required' => __('validation.user.phone.required'),
            'phone.unique' => __('validation.user.phone.unique'),
            'phone.regex' => __('validation.user.phone.regex'),
            'country_id.required' => __('validation.user.country.required'),
            'roles.required' => __('validation.user.roles.required'),
            'business_unit_id.required' => __('validation.user.businessUnit.required'),
            'status.required' => __('validation.user.status.required'),
        ];
    }
}
