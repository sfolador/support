<?php

namespace Sfolador\Support\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Sfolador\Support\Http\Requests\StoreSupportRequestRequest;
use Sfolador\Support\Mail\NewSupportRequestMail;
use Sfolador\Support\Models\SupportRequest;
use Sfolador\Support\Services\RecaptchaService;

class SupportRequestController extends Controller
{
    public function __construct(
        protected RecaptchaService $recaptchaService = new RecaptchaService
    ) {}

    public function index(): View
    {
        return view('support::support-request', [
            'supportTypes' => config('support.support_types', []),
            'recaptchaEnabled' => config('support.recaptcha.enabled', false),
            'recaptchaSiteKey' => config('support.recaptcha.site_key'),
        ]);
    }

    public function store(StoreSupportRequestRequest $request): RedirectResponse
    {
        if (config('support.recaptcha.enabled')) {
            $recaptchaValid = $this->recaptchaService->verify($request->input('g-recaptcha-response', ''));

            if (! $recaptchaValid) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['g-recaptcha-response' => __('support::messages.recaptcha_failed')]);
            }
        }

        $supportRequest = SupportRequest::create($request->validated());

        $supportEmail = config('support.support_email');
        if ($supportEmail) {
            Mail::to($supportEmail)->queue(new NewSupportRequestMail($supportRequest));
        }

        return redirect()->back()->with('success', __('support::messages.request_submitted'));
    }
}
