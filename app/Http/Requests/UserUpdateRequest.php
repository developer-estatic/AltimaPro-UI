<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends UserCreateRequest
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
        $userId = $this->route('user');
        $rules = parent::rules();

        $rules['email'] = 'required|email|' . Rule::unique('users')->ignore($userId);
        $rules['password'] = 'nullable|same:confirm_password|min:8|regex:"^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[@$!%*#?&]).*$"';
        $rules['phone'] = 'required|' . Rule::unique('users')->ignore($userId) . '|regex:/^\+\d{1,3}\s?(\d\s?){11,11}$/';
        return $rules;
    }

    public function messages(): array
    {
        return parent::messages();
    }
}
