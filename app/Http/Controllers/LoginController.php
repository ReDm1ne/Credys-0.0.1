<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\RateLimiter;
use App\Models\BlockedIp;
use App\Rules\CaptchaValidationRule;

class LoginController extends Controller
{
    protected $redirectTo = 'clientes.index';  // Ajusta el nombre de la ruta de redirección según tus necesidades

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        // Verifica si la dirección IP del usuario está bloqueada.
        if (BlockedIp::where('ip_address', $request->ip())->exists()) {
            return response()->json(['error' => 'Dirección IP bloqueada'], 403);
        }

        // Validación del formulario.
        $validator = Validator::make($request->all(), [
            'g-recaptcha-response' => ['required', new CaptchaValidationRule],
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $credentials = $request->only('email', 'password');

        // Rate limiting para el login.
        $key = 'login.attempt.'. $request->ip();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            return response()->json(['error' => 'Has intentado demasiadas veces. Intenta de nuevo en un minuto.']);
        }

        // Autenticación del usuario.
        if (Auth::attempt($credentials)) {
            RateLimiter::clear($key);
            return redirect()->route($this->redirectTo)->withSuccess('Bienvenido!');
        }

        RateLimiter::hit($key, 60);

        return back()->withErrors(['message' => 'Correo electrónico o contraseña incorrectos. <br> Por favor, inténtalo de nuevo.'])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login'); // Ajusta el nombre de la ruta según tus necesidades
    }
}
