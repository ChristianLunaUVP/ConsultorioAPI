<?php

namespace App\Http\Controllers;

use App\Models\Tratamientos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TratamientosController extends Controller
{
    public function index()
    {
        $tratamientos = Tratamientos::all();
        return response()->json($tratamientos, 200, [], JSON_PRETTY_PRINT);
    }

    public function store(Request $request)
    {
        $rules = [
            'tipo_tratamiento' => 'required|string|max:255',
            'costo' => 'required|numeric',
            'duración' => 'required|string|max:255',
            'doctor_id' => 'required|exists:doctores,id',
        ];
        $validator = Validator::make($request->input(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400, [], JSON_PRETTY_PRINT);
        }
        $tratamientos = new Tratamientos($request->input());
        $tratamientos->save();
        return response()->json(
            [
                'status' => true,
                'message' => 'Tratamiento creado correctamente'
            ],
            201,
            [],
            JSON_PRETTY_PRINT
        );
    }

    public function show($id)
    {
        $tratamientos = Tratamientos::find($id);
        if (!$tratamientos) {
            return response()->json(['status' => 'error', 'message' => 'Tratamiento no encontrado'], 404, [], JSON_PRETTY_PRINT);
        }
        return response()->json(['status' => 'success', 'data' => $tratamientos], 200, [], JSON_PRETTY_PRINT);
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'tipo_tratamiento' => 'required|string|max:255',
            'costo' => 'required|numeric',
            'duración' => 'required|string|max:255',
            'doctor_id' => 'required|exists:doctores,id',
        ];
        $validator = Validator::make($request->input(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400, [], JSON_PRETTY_PRINT);
        }

        $tratamientos = Tratamientos::find($id);
        if (!$tratamientos) {
            return response()->json(['status' => 'error', 'message' => 'Tratamiento no encontrado'], 404, [], JSON_PRETTY_PRINT);
        }

        $tratamientos->update($request->input());
        return response()->json($tratamientos, 200, [], JSON_PRETTY_PRINT);
    }

    public function destroy($id)
    {
        $tratamientos = Tratamientos::find($id);
        if (!$tratamientos) {
            return response()->json(['status' => 'error', 'message' => 'Tratamiento no encontrado'], 404, [], JSON_PRETTY_PRINT);
        }

        $tratamientos->delete();
        return response()->json([
            'status' => true,
            'message' => 'Tratamiento eliminado correctamente'
        ], 200, [], JSON_PRETTY_PRINT);
    }
}