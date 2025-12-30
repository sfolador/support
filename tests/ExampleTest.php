<?php

use Sfolador\Support\Models\SupportRequest;

it('can create a support request', function () {
    $supportRequest = SupportRequest::create([
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'support_type' => 'inquiry',
        'content' => 'This is a test request.',
    ]);

    expect($supportRequest)->toBeInstanceOf(SupportRequest::class)
        ->and($supportRequest->name)->toBe('John Doe')
        ->and($supportRequest->email)->toBe('john@example.com')
        ->and($supportRequest->support_type)->toBe('inquiry')
        ->and($supportRequest->content)->toBe('This is a test request.');
});

it('has fillable attributes', function () {
    $supportRequest = new SupportRequest;

    expect($supportRequest->getFillable())->toBe([
        'name',
        'email',
        'support_type',
        'content',
    ]);
});
