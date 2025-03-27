<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;  // Usa esta importación en lugar de PDF

class PdfController extends Controller
{
    public function generateUsersPdf()
    {
        // Obtener todos los usuarios con sus membresías
        $users = User::with('membership')->get();

        // Para debug: visualizar primero la vista
        // return view('pdf.users', compact('users'));



        // Generar el PDF    y      Descargar el PDF
        $pdf = Pdf::loadView('pdf.users', compact('users'));  // Nota la "P" minúscula

        return $pdf->download('lista_usuarios.pdf');
    }
}
