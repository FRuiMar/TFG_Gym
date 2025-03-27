<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;  //---> estoooo leñe.. a true. que si no bloquea todas las solicitudes.
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'role' => 'required|in:ADMIN,NORMAL',
            'membership_id' => 'required|exists:memberships,id',
            'image' => 'nullable|image|max:2048',
            'dni' => 'required|string|min:9|max:9|unique:users,dni'
        ];
    }

    public function messages()
    {
        return [
            // Validaciones para 'name'
            'name.required' => 'El nombre es obligatorio',
            'name.string' => 'El nombre debe ser texto',
            'name.max' => 'El nombre no puede tener más de :max caracteres',

            // Validaciones para 'email'
            'email.required' => 'El correo electrónico es obligatorio',
            'email.email' => 'El formato del correo electrónico no es válido',
            'email.unique' => 'Este correo electrónico ya está registrado',

            // Validaciones para 'password'
            'password.required' => 'La contraseña es obligatoria',
            'password.min' => 'La contraseña debe tener al menos :min caracteres, no seas vago',
            'password.confirmed' => 'Las contraseñas no coinciden',

            // Validaciones para 'role'
            'role.required' => 'El rol es obligatorio',
            'role.in' => 'El rol seleccionado no es válido',

            // Validaciones para 'membership_id'
            'membership_id.required' => 'La membresía es obligatoria',
            'membership_id.exists' => 'La membresía seleccionada no existe',

            // Validaciones para 'image'
            'image.image' => 'El archivo debe ser una imagen',
            'image.max' => 'La imagen no puede superar los :max kilobytes',

            // Validaciones para 'dni'
            'dni.required' => 'El DNI es obligatorio',
            'dni.string' => 'El DNI debe ser tipo texto',
            'dni.min' => 'El DNI debe tener :min caracteres, ya sabes.. tipo: 12345678A',
            'dni.max' => 'El DNI no puede tener más de :max caracteres',
            'dni.unique' => 'Este DNI ya está registrado, qué haces?',
        ];
    }
}
