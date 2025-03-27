<?php

namespace App\Http\Controllers;

use App\Models\Trainer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class TrainerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // Código de blade antiguo
        // $trainers = Trainer::all();
        // return view('trainers.index', compact('trainers'));

        // Código para Livewire
        return view('trainers.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('trainers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'dni' => 'required|string|max:255|unique:trainers,dni',
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'specialty' => 'required|string|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            // Manejar la subida de imagen si existe
            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('trainers', 'public');
                $validated['image'] = $path;
            }

            Trainer::create($validated);

            return redirect()->route('trainers.index')->with('success', 'Entrenador creado correctamente.');
        } catch (\Illuminate\Database\QueryException $e) {
            // Error de base de datos (duplicados, restricciones, etc)
            Log::error('Error al crear entrenador (DB): ' . $e->getMessage());
            $errorCode = $e->errorInfo[1] ?? null;

            if ($errorCode == 1062) { // Código de error de duplicate entry
                return back()->withInput()->with('error', 'Ya existe un entrenador con ese DNI.');
            }

            // Otros errores de base de datos
            return back()->withInput()->with('error', 'Error de base de datos al crear el entrenador.');
        } catch (\Exception $e) {
            // Cualquier otro error
            Log::error('Error al crear entrenador: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Ha ocurrido un error al crear el entrenador.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Trainer $trainer)
    {
        $trainer->load('activities');
        return view('trainers.show', compact('trainer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Trainer $trainer)
    {
        return view('trainers.edit', compact('trainer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Trainer $trainer)
    {
        try {
            $validated = $request->validate([
                'dni' => 'required|string|max:255|unique:trainers,dni,' . $trainer->id,
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'specialty' => 'required|string|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            // Manejar la subida de imagen si existe
            if ($request->hasFile('image')) {
                // Eliminar imagen anterior si existe
                if ($trainer->image && Storage::disk('public')->exists($trainer->image)) {
                    Storage::disk('public')->delete($trainer->image);
                }

                $path = $request->file('image')->store('trainers', 'public');
                $validated['image'] = $path;
            }

            $trainer->update($validated);

            return redirect()->route('trainers.index')->with('success', 'Entrenador actualizado correctamente.');
        } catch (\Illuminate\Database\QueryException $e) {
            // Error de base de datos
            Log::error('Error al actualizar entrenador (DB): ' . $e->getMessage());
            $errorCode = $e->errorInfo[1] ?? null;

            if ($errorCode == 1062) { // Duplicate entry
                return back()->withInput()->with('error', 'Ya existe un entrenador con ese DNI.');
            }

            return back()->withInput()->with('error', 'Error de base de datos al actualizar el entrenador.');
        } catch (\Exception $e) {
            // Cualquier otro error
            Log::error('Error al actualizar entrenador: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Ha ocurrido un error al actualizar el entrenador.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Trainer $trainer)
    {
        try {
            // Verificar si el entrenador tiene actividades
            if ($trainer->activities()->count() > 0) {
                return back()->with('warning', 'No se puede eliminar el entrenador porque tiene actividades asociadas. Elimina primero las actividades.');
            }

            // Eliminar imagen si existe
            if ($trainer->image && Storage::disk('public')->exists($trainer->image)) {
                Storage::disk('public')->delete($trainer->image);
            }

            $trainer->delete();
            return redirect()->route('trainers.index')->with('success', 'Entrenador eliminado correctamente.');
        } catch (\Illuminate\Database\QueryException $e) {
            Log::error('Error al eliminar entrenador (DB): ' . $e->getMessage());

            // Comprobar si es un error de restricción de clave foránea
            if (str_contains($e->getMessage(), 'foreign key constraint fails')) {
                return back()->with('error', 'No se puede eliminar el entrenador porque tiene relaciones en la base de datos.');
            }

            return back()->with('error', 'Error de base de datos al eliminar el entrenador.');
        } catch (\Exception $e) {
            Log::error('Error al eliminar entrenador: ' . $e->getMessage());
            return back()->with('error', 'Ha ocurrido un error al eliminar el entrenador.');
        }
    }
}
