<?php

namespace App\Http\Controllers;

use App\Models\Membership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MembershipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $memberships = Membership::withCount('users')->get();
        return view('memberships.index', compact('memberships'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('memberships.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'type' => 'required|string|max:255|unique:memberships,type',
                'price' => 'required|numeric|min:0',
                'duration_months' => 'required|integer|min:0',
            ]);

            Membership::create($validated);

            return redirect()->route('memberships.index')->with('success', 'Membresía creada correctamente.');
        } catch (\Illuminate\Database\QueryException $e) {
            // Error de base de datos
            Log::error('Error al crear membresía (DB): ' . $e->getMessage());
            $errorCode = $e->errorInfo[1] ?? null;

            if ($errorCode == 1062) { // Duplicate entry
                return back()->withInput()->with('error', 'Ya existe una membresía con ese tipo.');
            }

            // Otros errores de base de datos
            return back()->withInput()->with('error', 'Error de base de datos al crear la membresía.');
        } catch (\Exception $e) {
            // Cualquier otro error
            Log::error('Error al crear membresía: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Ha ocurrido un error al crear la membresía.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Membership $membership)
    {
        $membership->load('users');
        return view('memberships.show', compact('membership'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Membership $membership)
    {
        return view('memberships.edit', compact('membership'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Membership $membership)
    {
        try {
            $validated = $request->validate([
                'type' => 'required|string|max:255|unique:memberships,type,' . $membership->id,
                'price' => 'required|numeric|min:0',
                'duration_months' => 'required|integer|min:0',
            ]);

            $membership->update($validated);

            return redirect()->route('memberships.index')->with('success', 'Membresía actualizada correctamente.');
        } catch (\Illuminate\Database\QueryException $e) {
            // Error de base de datos
            Log::error('Error al actualizar membresía (DB): ' . $e->getMessage());
            $errorCode = $e->errorInfo[1] ?? null;

            if ($errorCode == 1062) { // Duplicate entry
                return back()->withInput()->with('error', 'Ya existe una membresía con ese tipo.');
            }

            // Otros errores de base de datos
            return back()->withInput()->with('error', 'Error de base de datos al actualizar la membresía.');
        } catch (\Exception $e) {
            // Cualquier otro error
            Log::error('Error al actualizar membresía: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Ha ocurrido un error al actualizar la membresía.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Membership $membership)
    {
        try {
            // Verificar si es una membresía que no debe eliminarse
            if ($membership->type === 'Sin membresía') {
                return back()->with('error', 'No puedes eliminar la membresía "Sin membresía" ya que es utilizada por defecto.');
            }

            // Buscar o crear membresía por defecto
            $defaultMembership = Membership::where('type', 'Sin membresía')->first();
            if (!$defaultMembership) {
                $defaultMembership = Membership::create([
                    'type' => 'Sin membresía',
                    'price' => 0,
                    'duration_months' => 0,
                ]);
            }

            // Verificar usuarios asociados
            $userCount = $membership->users()->count();
            if ($userCount > 0) {
                // Reasignar usuarios a la membresía por defecto
                $membership->users()->update(['membership_id' => $defaultMembership->id]);
                $message = 'Membresía eliminada correctamente. Se han reasignado ' . $userCount . ' usuarios a la membresía "Sin membresía".';
            } else {
                $message = 'Membresía eliminada correctamente.';
            }

            $membership->delete();
            return redirect()->route('memberships.index')->with('success', $message);
        } catch (\Exception $e) {
            Log::error('Error al eliminar membresía: ' . $e->getMessage());
            return back()->with('error', 'Ha ocurrido un error al eliminar la membresía.');
        }
    }



    public function indexUser()
    {
        // Obtener todas las membresías ordenadas por precio
        $memberships = Membership::orderBy('price')->get();

        // return view('memberships.index2', compact('memberships'));

        $memberships = Membership::withCount('users')->get();
        return view('memberships.indexUser', compact('memberships'));
    }
}
