<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userId = $this->route('user')->id;

        return [
            'dni' => "nullable|string|min:9|max:9|unique:users,dni,{$userId}",
            'name' => 'nullable|string|max:255',
            'email' => "nullable|email|unique:users,email,{$userId}",
            'password' => 'nullable|min:8|confirmed',
            'role' => 'nullable|in:ADMIN,NORMAL',
            'image' => 'nullable|image|max:2048',
            'membership_id' => 'nullable|exists:memberships,id',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            // DNI
            'dni.string' => 'El formato del DNI no es válido',
            'dni.min' => 'El DNI debe tener :min caracteres',
            'dni.max' => 'El DNI debe tener :max caracteres',
            'dni.unique' => 'Este DNI ya está registrado',

            // Name
            'name.string' => 'El nombre debe ser texto',
            'name.max' => 'El nombre no puede tener más de :max caracteres',

            // Email
            'email.email' => 'El formato del correo electrónico no es válido',
            'email.unique' => 'Este correo electrónico ya está registrado',

            // Password
            'password.min' => 'La contraseña debe tener al menos :min caracteres',
            'password.confirmed' => 'Las contraseñas no coinciden',

            // Role
            'role.in' => 'El rol seleccionado no es válido',

            // Image
            'image.image' => 'El archivo debe ser una imagen',
            'image.max' => 'La imagen no puede superar los :max kilobytes',

            // Membership
            'membership_id.exists' => 'La membresía seleccionada no existe',
        ];
    }
}
