@component('mail::message')
# New Support Request

You have received a new support request from {{ $supportRequest->name }}.

**Support Type:** {{ ucfirst(str_replace('_', ' ', $supportRequest->support_type)) }}

**Email:** {{ $supportRequest->email }}

**Request Details:**

{{ $supportRequest->content }}

{{ config('app.name') }}
@endcomponent
