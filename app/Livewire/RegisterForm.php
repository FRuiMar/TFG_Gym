<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\User;
use App\Models\Membership;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;

class RegisterForm extends Component
{
    use WithFileUploads;

    public $dni = '';
    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    public $image;
    public $membership_id = '';

    public function rules()
    {
        return [
            'dni' => ['required', 'string', 'max:9', 'unique:users'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'membership_id' => ['required', 'exists:memberships,id'],
            'image' => ['nullable', 'image', 'max:5120'], // max 5MB
        ];
    }

    public function messages()
    {
        return [
            'dni.required' => 'El DNI es obligatorio',
            'dni.unique' => 'Este DNI ya está registrado',
            'name.required' => 'El nombre es obligatorio',
            'email.required' => 'El email es obligatorio',
            'email.email' => 'Por favor, introduce un email válido',
            'email.unique' => 'Este email ya está registrado',
            'password.required' => 'La contraseña es obligatoria',
            'password.confirmed' => 'Las contraseñas no coinciden',
            'membership_id.required' => 'Debes seleccionar una membresía',
            'membership_id.exists' => 'La membresía seleccionada no existe',
            'image.image' => 'El archivo debe ser una imagen',
            'image.max' => 'La imagen no puede superar los 5MB',
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function register()
    {
        $validatedData = $this->validate();

        // Procesar la imagen si existe
        $imagePath = null;
        if ($this->image) {
            $imagePath = $this->image->store('users', 'public');
        }

        $user = User::create([
            'dni' => $this->dni,
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role' => 'NORMAL',
            'image' => $imagePath,
            'membership_id' => $this->membership_id,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('dashboard');
    }

    public function render()
    {
        return view('livewire.register-form', [
            'memberships' => Membership::all()
        ]);
    }
}
