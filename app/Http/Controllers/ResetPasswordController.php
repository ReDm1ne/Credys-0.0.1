<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

class ResetPasswordController extends Controller
{
    public function showResetPasswordForm(Request $request, $token)
    {
        $email = $request->email;
        
        return view('reset-password', ['token' => $token, 'email' => $email]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
        ]);

        $tokenData = DB::table('password_reset_tokens')
            ->where('email', $request->input('email'))
            ->first();

        if (!$tokenData) {
            return Redirect::back()->withErrors(['message' => 'El token de restablecimiento no es válido o ha expirado']);
        }

        if (!Hash::check($request->input('token'), $tokenData->token)) {
            return Redirect::back()->withErrors(['message' => 'El token de restablecimiento no es válido o ha expirado']);
        }

        \Log::info('Solicitud de restablecimiento: ', $request->all());

        $status = Password::reset(
            $request->only(['email', 'password', 'password_confirmation', 'token']),
            function ($user, $password) {
                $user->password = Hash::make($password);
                $user->save();

                DB::table('password_reset_tokens')->where('email', $user->email)->delete();
                \Log::info('Token eliminado para email: ' . $user->email);
            }
        );

        \Log::info('Estado del restablecimiento: ' . $status);

        if ($status === Password::PASSWORD_RESET) {
            return Redirect::route('login', ['success-password-changed' => true]);
        }

        $statusMessages = [
            Password::PASSWORD_RESET => 'Contraseña restablecida con éxito',
            Password::INVALID_USER => 'El correo electrónico no es válido',
            Password::INVALID_TOKEN => 'El token de restablecimiento no es válido',
            Password::RESET_THROTTLED => 'Has intentado restablecer la contraseña demasiadas veces. Por favor, espera un momento antes de volver a intentarlo.'
        ];

        return Redirect::back()->withErrors(['message' => $statusMessages[$status] ?? 'No se pudo restablecer la contraseña']);
    }
}