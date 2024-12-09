<?php

namespace App\Http\Controllers;

use App\Models\Doctores;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DoctoresController extends Controller
{
    public function index()
    {
        $doctores = Doctores::all();
        return response()->json($doctores, 200, [], JSON_PRETTY_PRINT);
    }

    public function store(Request $request)
    {
        $rules = [
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'especialidad' => 'required|string|max:255',
            'telefono' => 'required|numeric|min:10',
            'email' => 'required|email',
            'direccion' => 'required|string|min:10|max:100',
        ];
        $validator = Validator::make($request->input(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400, [], JSON_PRETTY_PRINT);
        }
        $doctores = new Doctores($request->input());
        $doctores->save();
        return response()->json(
            [
                'status' => true,
                'message' => 'Doctor creado correctamente'
            ],
            201,
            [],
            JSON_PRETTY_PRINT
        );
    }

    public function show($id)
    {
        $doctor = Doctores::find($id);
        if (!$doctor) {
            return response()->json(['status' => 'error', 'message' => 'Doctor no encontrado'], 404, [], JSON_PRETTY_PRINT);
        }
        return response()->json(['status' => 'success', 'data' => $doctor], 200, [], JSON_PRETTY_PRINT);
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'especialidad' => 'required|string|max:255',
            'telefono' => 'required|numeric|min:10',
            'email' => 'required|email',
            'direccion' => 'required|string|min:10|max:100',
        ];
        $validator = Validator::make($request->input(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400, [], JSON_PRETTY_PRINT);
        }

        $doctor = Doctores::find($id);
        if (!$doctor) {
            return response()->json(['status' => 'error', 'message' => 'Doctor no encontrado'], 404, [], JSON_PRETTY_PRINT);
        }

        $doctor->update($request->input());
        return response()->json(['status' => 'success', 'data' => $doctor], 200, [], JSON_PRETTY_PRINT);
    }

    public function destroy($id)
    {
        $doctor = Doctores::find($id);
        if (!$doctor) {
            return response()->json(['status' => 'error', 'message' => 'Doctor no encontrado'], 404, [], JSON_PRETTY_PRINT);
        }

        $doctor->delete();
        return response()->json([
            'status' => true,
            'message' => 'Doctor eliminado correctamente'
        ], 200, [], JSON_PRETTY_PRINT);
    }
}