@extends(config('support.layout', 'support::layouts.app'))

@section('title', config('support.page_title', 'Contact Support'))

@if($recaptchaEnabled)
@section('scripts')
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endsection
@endif

@section('content')
    <section class="min-h-screen py-20 relative overflow-hidden">
        <!-- Background decorations -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-20 right-1/4 w-96 h-96 bg-cyan-500 rounded-full mix-blend-screen filter blur-3xl opacity-10 animate-float"></div>
            <div class="absolute bottom-20 left-1/4 w-96 h-96 bg-pink-500 rounded-full mix-blend-screen filter blur-3xl opacity-10 animate-float" style="animation-delay: -2s;"></div>
        </div>

        <div class="max-w-2xl mx-auto px-6 relative z-10">
            <!-- Header -->
            <div class="text-center mb-12 opacity-0 animate-fade-in-up">
                <span class="inline-flex items-center space-x-2 px-4 py-2 rounded-full border border-white/10 bg-white/5 backdrop-blur-sm mb-6">
                    <svg class="w-4 h-4 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                    <span class="text-sm text-gray-300">{{ __('support::messages.hero_badge') }}</span>
                </span>
                <h1 class="font-display text-4xl sm:text-5xl font-bold mb-4">
                    {{ __('support::messages.page_title') }}
                </h1>
                <p class="text-lg text-gray-400">
                    {{ __('support::messages.page_description') }}
                </p>
            </div>

            <!-- Form Card -->
            <div class="card-glass p-8 md:p-10 opacity-0 animate-fade-in-up delay-200">
                <form action="{{ route('support.store') }}" method="POST" class="space-y-6">
                    @csrf

                    @if(session('success'))
                        <div class="flex items-center space-x-3 p-4 rounded-xl bg-green-500/10 border border-green-500/30">
                            <svg class="w-5 h-5 text-green-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="text-green-300">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="p-4 rounded-xl bg-red-500/10 border border-red-500/30">
                            <div class="flex items-center space-x-3 mb-2">
                                <svg class="w-5 h-5 text-red-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="text-red-300 font-medium">{{ __('support::messages.fix_errors') }}</span>
                            </div>
                            <ul class="list-disc list-inside text-red-400 text-sm space-y-1 ml-8">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Name Field -->
                    <div class="space-y-2">
                        <label for="name" class="block text-sm font-medium text-gray-300">
                            {{ __('support::messages.name_label') }}
                        </label>
                        <input
                            type="text"
                            name="name"
                            id="name"
                            required
                            class="input-dark w-full"
                            placeholder="{{ __('support::messages.name_placeholder') }}"
                            value="{{ old('name') }}"
                        >
                    </div>

                    <!-- Email Field -->
                    <div class="space-y-2">
                        <label for="email" class="block text-sm font-medium text-gray-300">
                            {{ __('support::messages.email_label') }}
                        </label>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            required
                            class="input-dark w-full"
                            placeholder="{{ __('support::messages.email_placeholder') }}"
                            value="{{ old('email') }}"
                        >
                    </div>

                    <!-- Support Type Field -->
                    <div class="space-y-2">
                        <label for="support_type" class="block text-sm font-medium text-gray-300">
                            {{ __('support::messages.support_type_label') }}
                        </label>
                        <div class="relative">
                            <select
                                name="support_type"
                                id="support_type"
                                required
                                class="input-dark w-full appearance-none cursor-pointer pr-10"
                            >
                                <option value="" class="bg-gray-900">{{ __('support::messages.select_type') }}</option>
                                @foreach($supportTypes as $value => $label)
                                    <option value="{{ $value }}" class="bg-gray-900" {{ old('support_type') == $value ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Request Details Field -->
                    <div class="space-y-2">
                        <label for="content" class="block text-sm font-medium text-gray-300">
                            {{ __('support::messages.content_label') }}
                        </label>
                        <textarea
                            name="content"
                            id="content"
                            rows="6"
                            required
                            class="input-dark w-full resize-none"
                            placeholder="{{ __('support::messages.content_placeholder') }}"
                        >{{ old('content') }}</textarea>
                    </div>

                    @if($recaptchaEnabled)
                    <!-- reCAPTCHA -->
                    <div class="space-y-2">
                        <div class="g-recaptcha" data-sitekey="{{ $recaptchaSiteKey }}" data-theme="dark"></div>
                        @error('g-recaptcha-response')
                            <p class="text-sm text-red-400 flex items-center space-x-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>
                    @endif

                    <!-- Submit Button -->
                    <button type="submit" class="btn-primary w-full group">
                        <span class="flex items-center justify-center space-x-2">
                            <span>{{ __('support::messages.submit_button') }}</span>
                            <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </span>
                    </button>
                </form>
            </div>

            <!-- Additional Info -->
            <div class="mt-12 grid grid-cols-1 sm:grid-cols-2 gap-6 opacity-0 animate-fade-in-up delay-400">
                <!-- Response Time -->
                <div class="flex items-start space-x-4 p-5 rounded-xl bg-white/5 border border-white/10">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 rounded-lg bg-cyan-500/10 border border-cyan-500/30 flex items-center justify-center">
                            <svg class="w-5 h-5 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <h3 class="font-semibold text-white text-sm">{{ __('support::messages.fast_response_title') }}</h3>
                        <p class="text-gray-500 text-sm mt-1">{{ __('support::messages.fast_response_description') }}</p>
                    </div>
                </div>

                <!-- Privacy -->
                <div class="flex items-start space-x-4 p-5 rounded-xl bg-white/5 border border-white/10">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 rounded-lg bg-pink-500/10 border border-pink-500/30 flex items-center justify-center">
                            <svg class="w-5 h-5 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <h3 class="font-semibold text-white text-sm">{{ __('support::messages.secure_title') }}</h3>
                        <p class="text-gray-500 text-sm mt-1">{{ __('support::messages.secure_description') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }
        @keyframes fade-in-up {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-float { animation: float 6s ease-in-out infinite; }
        .animate-fade-in-up { animation: fade-in-up 0.6s ease-out forwards; }
        .delay-200 { animation-delay: 0.2s; }
        .delay-400 { animation-delay: 0.4s; }
        .gradient-text {
            background: linear-gradient(135deg, #06b6d4 0%, #ec4899 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .card-glass {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 1rem;
        }
        .input-dark {
            background: rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 0.75rem;
            padding: 0.75rem 1rem;
            color: white;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .input-dark:focus {
            outline: none;
            border-color: #06b6d4;
            box-shadow: 0 0 0 3px rgba(6, 182, 212, 0.1);
        }
        .input-dark::placeholder { color: #6b7280; }
        .btn-primary {
            background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
            color: white;
            font-weight: 600;
            padding: 0.875rem 1.5rem;
            border-radius: 0.75rem;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 40px rgba(6, 182, 212, 0.3);
        }
    </style>
@endsection
