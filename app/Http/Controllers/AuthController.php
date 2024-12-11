<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function create(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:users,email',
            'password' => 'required|string|min:8'
        ];
        $validator = Validator::make($request->input(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()->all()
            ], 400);
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        return response()->json([
            'status' => true,
            'message' => 'User created successfully',
            'token' => $user->createToken('API TOKEN')->plainTextToken
        ], 201);
    }

    public function login(Request $request)
{
    $rules = [
        'email' => 'required|email',
        'password' => 'required|string'
    ];
    $validator = Validator::make($request->input(), $rules);
    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'message' => 'Validation failed',
            'errors' => $validator->errors()->all()
        ], 400);
    }

    if (!Auth::attempt($request->only('email', 'password'))) {
        return response()->json([
            'status' => false,
            'message' => 'Invalid credentials'
        ], 401);
    }

    $user = Auth::user(); // Obtener el usuario autenticado

    return response()->json([
        'status' => true,
        'message' => 'User logged in successfully',
        'user' => $user, // Incluye los datos del usuario
        'token' => $user->createToken('API TOKEN')->plainTextToken
    ], 200);
}

    public function logout(Request $request)
    {
        // Elimina el token de acceso actual
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => true,
            'message' => 'User logged out successfully'
        ], 200);
    }
}