<?php

namespace Sfolador\Support\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSupportRequestRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $supportTypes = implode(',', array_keys(config('support.support_types', [])));

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'support_type' => ['required', "in:{$supportTypes}"],
            'content' => ['required', 'string', 'max:5000'],
        ];

        if (config('support.recaptcha.enabled')) {
            $rules['g-recaptcha-response'] = ['required'];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'g-recaptcha-response.required' => __('support::messages.recaptcha_required'),
        ];
    }
}
