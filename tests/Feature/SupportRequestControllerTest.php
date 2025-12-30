<?php

use Illuminate\Support\Facades\Mail;
use Sfolador\Support\Mail\NewSupportRequestMail;

beforeEach(function () {
    Mail::fake();
});

it('can display the support page', function () {
    $response = $this->get(route('support'));

    $response->assertStatus(200)
        ->assertViewIs('support::support-request');
});

it('can submit a support request without recaptcha', function () {
    config(['support.recaptcha.enabled' => false]);
    config(['support.support_email' => 'support@example.com']);

    $response = $this->post(route('support.store'), [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'support_type' => 'inquiry',
        'content' => 'This is a test support request.',
    ]);

    $response->assertRedirect()
        ->assertSessionHas('success');

    $this->assertDatabaseHas('support_requests', [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'support_type' => 'inquiry',
    ]);

    Mail::assertQueued(NewSupportRequestMail::class, function ($mail) {
        return $mail->hasTo('support@example.com');
    });
});

it('validates required fields', function () {
    config(['support.recaptcha.enabled' => false]);

    $response = $this->post(route('support.store'), []);

    $response->assertSessionHasErrors(['name', 'email', 'support_type', 'content']);
});

it('validates email format', function () {
    config(['support.recaptcha.enabled' => false]);

    $response = $this->post(route('support.store'), [
        'name' => 'John Doe',
        'email' => 'invalid-email',
        'support_type' => 'inquiry',
        'content' => 'Test content.',
    ]);

    $response->assertSessionHasErrors(['email']);
});

it('validates support type', function () {
    config(['support.recaptcha.enabled' => false]);

    $response = $this->post(route('support.store'), [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'support_type' => 'invalid_type',
        'content' => 'Test content.',
    ]);

    $response->assertSessionHasErrors(['support_type']);
});

it('validates content max length', function () {
    config(['support.recaptcha.enabled' => false]);

    $response = $this->post(route('support.store'), [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'support_type' => 'inquiry',
        'content' => str_repeat('a', 5001),
    ]);

    $response->assertSessionHasErrors(['content']);
});

it('requires recaptcha when enabled', function () {
    config(['support.recaptcha.enabled' => true]);

    $response = $this->post(route('support.store'), [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'support_type' => 'inquiry',
        'content' => 'Test content.',
    ]);

    $response->assertSessionHasErrors(['g-recaptcha-response']);
});

it('does not send email when support_email is not configured', function () {
    config(['support.recaptcha.enabled' => false]);
    config(['support.support_email' => null]);

    $response = $this->post(route('support.store'), [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'support_type' => 'inquiry',
        'content' => 'Test content.',
    ]);

    $response->assertRedirect()
        ->assertSessionHas('success');

    Mail::assertNothingQueued();
});
