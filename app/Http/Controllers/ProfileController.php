<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use App\Models\Membership;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        // Obtener todas las membresías para el selector
        $memberships = Membership::orderBy('price')->get();

        return view('profile.edit', [
            'user' => $request->user(),
            'memberships' => $memberships,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        // Actualizar los campos básicos
        $user->name = $request->name;
        $user->email = $request->email;

        // Si se cambió el email, requiere nueva verificación
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // Actualizar la membresía si se seleccionó una
        if ($request->has('membership_id')) {
            $user->membership_id = $request->membership_id;
        }

        // Procesar la imagen si se subió una nueva
        if ($request->hasFile('image')) {
            // Borrar la imagen anterior si existe
            if ($user->image && Storage::disk('public')->exists($user->image)) {
                Storage::disk('public')->delete($user->image);
            }

            // Guardar la nueva imagen
            $path = $request->file('image')->store('users', 'public');
            $user->image = $path;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        // Eliminar la imagen del usuario si existe
        if ($user->image && Storage::disk('public')->exists($user->image)) {
            Storage::disk('public')->delete($user->image);
        }

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
