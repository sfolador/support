<?php

namespace Sfolador\Support\Services;

class RecaptchaService
{
    public function verify(string $recaptchaResponse): bool
    {
        if (! config('support.recaptcha.enabled')) {
            return true;
        }

        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $data = [
            'secret' => config('support.recaptcha.secret_key'),
            'response' => $recaptchaResponse,
            'remoteip' => request()->ip(),
        ];

        $options = [
            'http' => [
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data),
            ],
        ];

        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);

        if ($result === false) {
            return false;
        }

        $response = json_decode($result, true);

        return $response['success'] ?? false;
    }
}
