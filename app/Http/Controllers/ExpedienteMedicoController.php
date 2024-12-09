<?php

namespace App\Http\Controllers;

use App\Models\ExpedienteMedico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ExpedienteMedicoController extends Controller
{
    public function index()
    {
        $expedientes = ExpedienteMedico::paginate(10); // Cambia el número 10 por el número de elementos por página que desees
        return response()->json($expedientes, 200, [], JSON_PRETTY_PRINT);
    }

    public function store(Request $request)
    {
        $rules = [
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
            'fecha' => 'required|date',
            'doctor_id' => 'required|exists:doctores,id',
            'diagnostico' => 'required|string|max:255',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()->all()
            ], 400, [], JSON_PRETTY_PRINT);
        }
    
        try {
            $expediente = new ExpedienteMedico($request->all());
            $expediente->save();
    
            // Subir la imagen
            if ($request->hasFile('imagen')) {
                $imageName = 'expediente_' . $expediente->id . '.' . $request->imagen->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('expedientes', $request->file('imagen'), $imageName);
                $expediente->imagen = 'expedientes/' . $imageName;
                $expediente->save();
            }
    
            return response()->json([
                'status' => 'success',
                'message' => 'Expediente médico creado con éxito.',
                'data' => $expediente
            ], 201, [], JSON_PRETTY_PRINT);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Algo salió mal!'
            ], 500, [], JSON_PRETTY_PRINT);
        }
    }

    public function show($id)
    {
        $expedienteMedico = ExpedienteMedico::find($id);
        if (!$expedienteMedico) {
            return response()->json(['status' => 'error', 'message' => 'Expediente médico no encontrado'], 404, [], JSON_PRETTY_PRINT);
        }
        return response()->json(['status' => 'success', 'data' => $expedienteMedico], 200, [], JSON_PRETTY_PRINT);
    }


    public function update(Request $request, $id)
    {
        $rules = [
            'imagen' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:5120',
            'fecha' => 'required|date',
            'doctor_id' => 'required|exists:doctores,id',
            'diagnostico' => 'required|string|max:255',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()->all()
            ], 400, [], JSON_PRETTY_PRINT);
        }
    
        $expedienteMedico = ExpedienteMedico::find($id);
        if (!$expedienteMedico) {
            return response()->json(['status' => 'error', 'message' => 'Expediente médico no encontrado'], 404, [], JSON_PRETTY_PRINT);
        }
    
        // Subir la imagen si está presente
        if ($request->hasFile('imagen')) {
            // Eliminar la imagen existente
            $imageName = 'expediente_' . $expedienteMedico->id . '.' . $request->imagen->getClientOriginalExtension();
            if ($expedienteMedico->imagen && Storage::disk('public')->exists($expedienteMedico->imagen)) {
                Storage::disk('public')->delete($expedienteMedico->imagen);
            }
    
            Storage::disk('public')->putFileAs('expedientes', $request->file('imagen'), $imageName);
            $request->merge(['imagen' => 'expedientes/' . $imageName]);
        }
    
        $expedienteMedico->update($request->all());
    
        return response()->json([
            'status' => 'success',
            'message' => 'Expediente médico actualizado con éxito.',
            'data' => $expedienteMedico
        ], 200, [], JSON_PRETTY_PRINT);
    }

    public function destroy($id)
    {
        $expedienteMedico = ExpedienteMedico::find($id);
        if (!$expedienteMedico) {
            return response()->json(['status' => 'error', 'message' => 'Expediente médico no encontrado'], 404, [], JSON_PRETTY_PRINT);
        }

        $expedienteMedico->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Expediente médico eliminado con éxito.'
        ], 200, [], JSON_PRETTY_PRINT);
    }

    public function expedientesPorDoctor()
    {
        $expedientes = ExpedienteMedico::select(DB::raw('count(expedientes_medicos.id) as count'), 'doctores.nombre')
            ->join('doctores', 'doctores.id', '=', 'expedientes_medicos.doctor_id')
            ->groupBy('doctores.nombre')
            ->get();
        return response()->json($expedientes, 200, [], JSON_PRETTY_PRINT);
    }

    public function allexpedientes()
    {
        try {
            $expedientes = ExpedienteMedico::all();
            return response()->json($expedientes, 200, [], JSON_PRETTY_PRINT);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Algo salió mal!',
                'error' => $e->getMessage()
            ], 500, [], JSON_PRETTY_PRINT);
        }
    }
}