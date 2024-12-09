<?php

namespace App\Http\Controllers;

use App\Models\Pacientes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class PacientesController extends Controller
{
    public function index()
    {
        $pacientes = Pacientes::all();
        return response()->json($pacientes, 200, [], JSON_PRETTY_PRINT);
    }

    public function store(Request $request)
    {
        $rules = [
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'edad' => 'required|integer',
            'telefono' => 'required|string|max:15',
            'email' => 'required|string|email|max:255|unique:pacientes',
            'direccion' => 'required|string|max:255',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()->all()
            ], 400, [], JSON_PRETTY_PRINT);
        }
        $pacientes = new Pacientes($request->all());
        $pacientes->save();
        return response()->json([
            'status' => 'success',
            'message' => 'Pacientes creado exitosamente',
            'data' => $pacientes
        ], 201, [], JSON_PRETTY_PRINT);
    }

    public function show($id)
    {
        $pacientes = Pacientes::find($id);
        if (!$pacientes) {
            return response()->json(['status' => 'error', 'message' => 'Pacientes no encontrado'], 404, [], JSON_PRETTY_PRINT);
        }
        return response()->json(['status' => 'success', 'data' => $pacientes], 200, [], JSON_PRETTY_PRINT);
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'edad' => 'required|integer',
            'telefono' => 'required|string|max:15',
            'email' => 'required|string|email|max:255|unique:pacientes,email,' . $id,
            'direccion' => 'required|string|max:255',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()->all()
            ], 400, [], JSON_PRETTY_PRINT);
        }

        $pacientes = Pacientes::find($id);
        if (!$pacientes) {
            return response()->json(['status' => 'error', 'message' => 'Pacientes no encontrado'], 404, [], JSON_PRETTY_PRINT);
        }

        $pacientes->update($request->all());
        return response()->json([
            'status' => 'success',
            'message' => 'Pacientes actualizado exitosamente',
            'data' => $pacientes
        ], 200, [], JSON_PRETTY_PRINT);
    }

    public function destroy($id)
    {
        $pacientes = Pacientes::find($id);
        if (!$pacientes) {
            return response()->json(['status' => 'error', 'message' => 'Pacientes no encontrado'], 404, [], JSON_PRETTY_PRINT);
        }

        $pacientes->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Pacientes eliminado exitosamente'
        ], 200, [], JSON_PRETTY_PRINT);
    }

    public function pacientesPorDoctor()
    {
        $pacientes = DB::table('pacientes')
            ->select(DB::raw('count(pacientes.id) as count'), 'doctores.nombre')
            ->join('doctores', 'doctores.id', '=', 'pacientes.doctor_id')
            ->groupBy('doctores.nombre')
            ->get();
        return response()->json($pacientes, 200, [], JSON_PRETTY_PRINT);
    }
}