<?php

namespace Sfolador\Support\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Sfolador\Support\Models\SupportRequest;

class NewSupportRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public SupportRequest $supportRequest
    ) {}

    public function build(): self
    {
        return $this->markdown('support::emails.new-support-request')
            ->subject('New Support Request - '.ucfirst(str_replace('_', ' ', $this->supportRequest->support_type)));
    }
}
