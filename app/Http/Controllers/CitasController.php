<?php

namespace App\Http\Controllers;

use App\Models\Citas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CitasController extends Controller
{
    public function index()
    {
        $citas = Citas::all();
        return response()->json($citas, 200, [], JSON_PRETTY_PRINT);
    }

    public function store(Request $request)
    {
        $rules = [
            'doctor_id' => 'required|exists:doctores,id',
            'paciente_id' => 'required|exists:pacientes,id',
            'fecha' => 'required|date',
            'hora' => 'required|string|min:5',
            'motivo' => 'required|string|max:255|min:5',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400, [], JSON_PRETTY_PRINT);
        }
        $citas = new Citas();
        $citas->fill($request->all());
        $citas->save();
        return response()->json(
            [
                'status' => true,
                'message' => 'Cita creada correctamente'
            ],
            201,
            [],
            JSON_PRETTY_PRINT
        );
    }

    public function show($id)
    {
        $cita = Citas::find($id);
        if (!$cita) {
            return response()->json(['status' => 'error', 'message' => 'Cita no encontrada'], 404, [], JSON_PRETTY_PRINT);
        }
        return response()->json(['status' => 'success', 'data' => $cita], 200, [], JSON_PRETTY_PRINT);
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'doctor_id' => 'required|exists:doctores,id',
            'paciente_id' => 'required|exists:pacientes,id',
            'fecha' => 'required|date',
            'hora' => 'required|string|min:5',
            'motivo' => 'required|string|max:255|min:5',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400, [], JSON_PRETTY_PRINT);
        }

        $citas = Citas::find($id);
        if (!$citas) {
            return response()->json(['status' => 'error', 'message' => 'Cita no encontrada'], 404, [], JSON_PRETTY_PRINT);
        }

        $citas->update($request->all());
        return response()->json(['status' => 'success', 'data' => $citas], 200, [], JSON_PRETTY_PRINT);
    }

    public function destroy($id)
    {
        $citas = Citas::find($id);
        if (!$citas) {
            return response()->json(['status' => 'error', 'message' => 'Cita no encontrada'], 404, [], JSON_PRETTY_PRINT);
        }

        $citas->delete();
        return response()->json([
            'status' => true,
            'message' => 'Cita eliminada correctamente'
        ], 200, [], JSON_PRETTY_PRINT);
    }
}