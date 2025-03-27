<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class APIUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return response()->json([
            'success' => true,
            'data' => $users
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar datos de entrada
        $validated = $request->validate([
            'dni' => 'required|string|unique:users,dni',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:5',
            'role' => 'sometimes|string|in:ADMIN,NORMAL',
            'membership_id' => 'required|exists:memberships,id',
        ]);

        // Encriptar contraseña
        $validated['password'] = bcrypt($validated['password']);

        // Si no se especifica un rol, asignar 'NORMAL' por defecto
        if (!isset($validated['role'])) {
            $validated['role'] = 'NORMAL';
        }

        // Crear el usuario
        $user = User::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Usuario creado correctamente',
            'data' => $user
        ], 201); // 201 Created
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no encontrado'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Buscar el usuario
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no encontrado'
            ], 404);
        }

        // Validar datos de entrada
        $validated = $request->validate([
            'dni' => 'string|unique:users,dni,' . $user->id,
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:users,email,' . $id,
            'password' => 'sometimes|string|min:5',
            'role' => 'sometimes|string|in:ADMIN,NORMAL',
            'membership_id' => 'nullable|exists:memberships,id',
        ]);

        // Si se está actualizando la contraseña, encriptarla
        if (isset($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        }

        // Actualizar el usuario
        $user->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Usuario actualizado correctamente',
            'data' => $user
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Buscar el usuario
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no encontrado'
            ], 404);
        }

        // Verificar si es el último administrador
        if ($user->role === 'admin') {
            $adminCount = User::where('role', 'admin')->count();
            if ($adminCount <= 1) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se puede eliminar el último administrador del sistema'
                ], 400);
            }
        }

        // Eliminar el usuario
        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'Usuario eliminado correctamente'
        ]);
    }
}
