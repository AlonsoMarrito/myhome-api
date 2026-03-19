<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    // LOGIN
    public function login(Request $request)
    {
        $request->validate([
            'id_persona' => 'required|integer',
            'password' => 'required'
        ]);

        $user = Usuario::where('id_persona', $request->id_persona)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Credenciales incorrectas'
            ], 401);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'admin' => $user->admin
        ]);
    }

    // LOGOUT
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Sesión cerrada'
        ]);
    }

    // CAMBIO DE CONTRASEÑA CON LA CONTRASEÑA ACTUAL
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed'
        ]);

        $user = $request->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'message' => 'La contraseña actual es incorrecta'
            ], 400);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        $user->tokens()->delete(); // cerrar todas las sesiones

        return response()->json([
            'message' => 'Contraseña actualizada. Todas las sesiones fueron cerradas.'
        ]);
    }

    // ENVIAR CORREO DE RECUPERACIÓN DE CONTRASEÑA
    public function sendRecoverEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:usuarios,email',
        ]);

        try {
            $status = Password::sendResetLink(
                $request->only('email')
            );

            if ($status === Password::RESET_LINK_SENT) {
                return response()->json([
                    'message' => 'Correo de recuperación enviado correctamente.'
                ]);
            } else {
                return response()->json([
                    'message' => 'No se pudo enviar el correo.'
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al enviar el correo: ' . $e->getMessage()
            ], 500);
        }
    }

    // RESETEAR CONTRASEÑA CON TOKEN
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:usuarios,email',
            'password' => 'required|confirmed|min:6',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->password = Hash::make($password);
                $user->save();
                $user->tokens()->delete(); // Cierra todas las sesiones
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return response()->json([
                'message' => 'Contraseña actualizada correctamente.'
            ]);
        } else {
            return response()->json([
                'message' => 'Token inválido o expirado.'
            ], 400);
        }
    }
}