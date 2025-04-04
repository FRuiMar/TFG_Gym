<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Trainer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $activities = Activity::with('classSessions.trainer')->get();
        return view('activities.index', compact('activities'));
    }

    public function cardsUser()
    {
        $activities = Activity::with('classSessions.trainer')->get();
        return view('activities.cardsUser', compact('activities'));
    }



    /**
     * Display a listing of the resource.
     */
    public function cards()
    {
        $activities = Activity::with('classSessions.trainer')->get();
        return view('activities.cards', compact('activities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $trainers = User::where('role', 'TRAINER')->get();
        return view('activities.create', compact('trainers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'schedule' => 'required|string',
                'max_capacity' => 'required|integer|min:1',
                'trainer_id' => 'nullable|exists:trainers,id',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            // Manejar la subida de imagen si existe
            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('activities', 'public');
                $validated['image'] = $path;
            }

            Activity::create($validated);

            return redirect()->route('activities.index')->with('success', 'Actividad creada correctamente.');
        } catch (\Illuminate\Database\QueryException $e) {
            // Error de base de datos
            Log::error('Error al crear actividad (DB): ' . $e->getMessage());
            $errorCode = $e->errorInfo[1] ?? null;

            if ($errorCode == 1062) { // Duplicate entry
                return back()->withInput()->with('error', 'Ya existe una actividad con ese nombre y horario.');
            }

            // Otros errores de base de datos
            return back()->withInput()->with('error', 'Error de base de datos al crear la actividad.');
        } catch (\Exception $e) {
            // Cualquier otro error
            Log::error('Error al crear actividad: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Ha ocurrido un error al crear la actividad.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Activity $activity)
    {
        $activity->load('classSessions.trainer', 'users');
        return view('activities.show', compact('activity'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Activity $activity)
    {
        $trainers = User::where('role', 'TRAINER')->get();
        return view('activities.edit', compact('activity', 'trainers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Activity $activity)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'schedule' => 'required|string',
                'max_capacity' => 'required|integer|min:1',
                'trainer_id' => 'nullable|exists:trainers,id',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            // Manejar la subida de imagen si existe
            if ($request->hasFile('image')) {
                // Eliminar imagen anterior si existe
                if ($activity->image && Storage::disk('public')->exists($activity->image)) {
                    Storage::disk('public')->delete($activity->image);
                }

                $path = $request->file('image')->store('activities', 'public');
                $validated['image'] = $path;
            }

            $activity->update($validated);

            return redirect()->route('activities.index')->with('success', 'Actividad actualizada correctamente.');
        } catch (\Illuminate\Database\QueryException $e) {
            // Error de base de datos
            Log::error('Error al actualizar actividad (DB): ' . $e->getMessage());

            return back()->withInput()->with('error', 'Error de base de datos al actualizar la actividad.');
        } catch (\Exception $e) {
            // Cualquier otro error
            Log::error('Error al actualizar actividad: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Ha ocurrido un error al actualizar la actividad.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Activity $activity)
    {
        try {
            // Verificar si la actividad tiene usuarios inscritos
            if ($activity->users()->count() > 0) {
                // Opción 1: Impedir la eliminación
                return back()->with('warning', 'No se puede eliminar la actividad porque hay usuarios inscritos.');

                // Opción 2: Eliminar las inscripciones antes de eliminar la actividad
                // $activity->users()->detach();
            }

            // Eliminar la imagen si existe
            if ($activity->image && Storage::disk('public')->exists($activity->image)) {
                Storage::disk('public')->delete($activity->image);
            }

            $activity->delete();
            return redirect()->route('activities.index')->with('success', 'Actividad eliminada correctamente.');
        } catch (\Exception $e) {
            Log::error('Error al eliminar actividad: ' . $e->getMessage());
            return back()->with('error', 'Ha ocurrido un error al eliminar la actividad.');
        }
    }



    //le creo una función welcome() para la vista de bienvenida
    public function welcome()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        $activities = Activity::with('classSessions.trainer')->get();
        return view('welcome', compact('activities'));
    }
}
