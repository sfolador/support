<?php

use Sfolador\Support\Services\RecaptchaService;

it('returns true when recaptcha is disabled', function () {
    config(['support.recaptcha.enabled' => false]);

    $service = new RecaptchaService;

    expect($service->verify('any-token'))->toBeTrue();
});
