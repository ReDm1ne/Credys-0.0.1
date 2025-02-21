<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use ReCaptcha\ReCaptcha;

class CaptchaValidationRule implements Rule {
    protected $reCaptcha;

    public function __construct()
    {
        $this->reCaptcha = new ReCaptcha(config('recaptcha.secret'));
    }

    public function passes($attribute, $value)
    {
        $response = $this->reCaptcha->verify($value, request()->ip());

        return $response->isSuccess();
    }

    public function message()
    {
        return 'El captcha es inválido.';
    }
}