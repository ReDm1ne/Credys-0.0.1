<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordEmail extends Mailable
{
    use SerializesModels;

    public $token;
    public $email;
    public $name;

    /**
     * Create a new message instance.
     *
     * @param string $token
     * @param string $email
     * @param string $name
     */
    public function __construct($token, $email, $name)
    {
        $this->token = $token;
        $this->email = $email;
        $this->name = $name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $resetLink = url(route('password.reset', ['token' => $this->token, 'email' => $this->email], false));

        return $this->from('soporte@tu-dominio.com', 'Soporte')
            ->subject('Restablecimiento de Contraseña')
            ->view('emails.reset-password-email')
            ->with([
                'resetLink' => $resetLink,
                'name' => $this->name,
            ]);
    }
}
