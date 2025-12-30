<?php

use Sfolador\Support\Mail\NewSupportRequestMail;
use Sfolador\Support\Models\SupportRequest;

it('builds the mail correctly', function () {
    $supportRequest = SupportRequest::create([
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'support_type' => 'data_removal',
        'content' => 'Please remove my data.',
    ]);

    $mail = new NewSupportRequestMail($supportRequest);
    $mail->build();

    expect($mail->subject)->toBe('New Support Request - Data removal');
});

it('uses markdown view', function () {
    $supportRequest = SupportRequest::create([
        'name' => 'Jane Doe',
        'email' => 'jane@example.com',
        'support_type' => 'inquiry',
        'content' => 'General question.',
    ]);

    $mail = new NewSupportRequestMail($supportRequest);
    $built = $mail->build();

    expect($built)->toBeInstanceOf(NewSupportRequestMail::class);
});
