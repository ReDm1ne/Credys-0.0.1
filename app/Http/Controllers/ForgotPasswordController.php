<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash; 
use App\Mail\ResetPasswordEmail;
use App\Models\User;
use Illuminate\Support\Str;
use Carbon\Carbon;
use DB;

class ForgotPasswordController extends Controller
{
    public function showForgotPasswordForm()
    {
        return view('forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $email = $request->input('email');

        $user = User::where('email', $email)->first();

        if (!$user) {
            return Redirect::back()->with('status', 'Enlace de restablecimiento enviado');
        }

        $token = Str::random(60);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $email],
            ['email' => $email, 'token' => Hash::make($token), 'created_at' => Carbon::now()]
        );

        $tokenData = DB::table('password_reset_tokens')->where('email', $email)->first();
        if ($tokenData) {
            \Log::info('Token generado: ' . $token);
            \Log::info('Token en la base de datos: ', ['data' => json_decode(json_encode($tokenData), true)]);
        } else {
            \Log::error('Error guardando el token para el email: ' . $email);
        }

        Mail::to($email)->send(new ResetPasswordEmail($token, $email, $user->name));

        return Redirect::back()->with('status', 'Enlace de restablecimiento enviado');
    }
}