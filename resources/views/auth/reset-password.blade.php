<x-guest-layout>
    <div class="min-h-screen flex">
        {{-- Left Panel - Branding --}}
        <div class="hidden lg:flex lg:w-1/2 flex-col justify-between bg-gradient-to-br from-primary-600 via-primary-700 to-primary-900 p-12 relative overflow-hidden">
            <div class="absolute inset-0 opacity-10" aria-hidden="true">
                <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                    <defs>
                        <pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse">
                            <path d="M 10 0 L 0 0 0 10" fill="none" stroke="white" stroke-width="0.5"/>
                        </pattern>
                    </defs>
                    <rect width="100" height="100" fill="url(#grid)"/>
                </svg>
            </div>

            <div class="absolute top-20 left-10 w-64 h-64 rounded-full bg-white/10 blur-3xl animate-pulse" aria-hidden="true"></div>
            <div class="absolute bottom-20 right-10 w-80 h-80 rounded-full bg-white/5 blur-3xl animate-pulse" style="animation-delay: 1s" aria-hidden="true"></div>

            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-14 h-14 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center border border-white/30">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-white">School CRM</h1>
                        <p class="text-primary-100 text-sm">School Management System</p>
                    </div>
                </div>
            </div>

            <div class="relative z-10 max-w-md">
                <h2 class="text-4xl lg:text-5xl font-bold text-white leading-tight mb-6">
                    Set New<br class="hidden lg:block">Password
                </h2>
                <p class="text-primary-100 text-lg leading-relaxed mb-10">
                    Your new password must be different from previously used passwords.
                </p>
            </div>

            <div class="relative z-10 flex items-center gap-4 text-primary-200 text-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/>
                    <path d="M12 6v6l4 2"/>
                </svg>
                <span>Secure & Compliant</span>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="2" y="3" width="20" height="14" rx="2"/>
                    <path d="M8 21h8M12 17v4"/>
                </svg>
                <span>99.9% Uptime</span>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                </svg>
                <span>Data Encrypted</span>
            </div>
        </div>

        {{-- Right Panel - Reset Form --}}
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 lg:p-12 bg-gray-50 dark:bg-gray-950">
            <div class="w-full max-w-md">
                <div class="lg:hidden text-center mb-8">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-primary-600 mb-4">
                        <svg class="w-9 h-9 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                        </svg>
                    </div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">School CRM</h1>
                    <p class="text-gray-500 dark:text-gray-400 mt-1">School Management System</p>
                </div>

                <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-800 p-8 lg:p-10">
                    <div class="text-center mb-8">
                        <h2 class="text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white">Reset Password</h2>
                        <p class="mt-2 text-gray-600 dark:text-gray-400">Enter your new password below</p>
                    </div>

                    <form method="POST" action="{{ route('password.store') }}" class="space-y-6">
                        @csrf

                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                        <div>
                            <x-input-label for="email" :value="__('Email Address')" />
                            <div class="relative mt-2">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="2" y="4" width="20" height="16" rx="2"/>
                                        <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                                    </svg>
                                </div>
                                <x-text-input 
                                    id="email" 
                                    class="block w-full pl-12 pr-4 py-3.5" 
                                    type="email" 
                                    name="email" 
                                    :value="old('email', $request->email)" 
                                    required 
                                    autofocus 
                                    autocomplete="username" 
                                    placeholder="admin@school.edu"
                                />
                            </div>
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="password" :value="__('New Password')" />
                            <div class="relative mt-2">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                        <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                                    </svg>
                                </div>
                                <x-text-input 
                                    id="password" 
                                    class="block w-full pl-12 pr-14 py-3.5" 
                                    type="password" 
                                    name="password" 
                                    required 
                                    autocomplete="new-password"
                                    placeholder="••••••••"
                                />
                                <button type="button" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors" onclick="togglePasswordVisibility(this)" aria-label="Toggle password visibility">
                                    <svg class="w-5 h-5 eye-open" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/>
                                        <circle cx="12" cy="12" r="3"/>
                                    </svg>
                                    <svg class="w-5 h-5 eye-closed hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"/>
                                        <path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.99"/>
                                        <line x1="2" y1="2" x2="22" y2="22"/>
                                    </svg>
                                </button>
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                            <div class="relative mt-2">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                        <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                                    </svg>
                                </div>
                                <x-text-input 
                                    id="password_confirmation" 
                                    class="block w-full pl-12 pr-4 py-3.5" 
                                    type="password" 
                                    name="password_confirmation" 
                                    required 
                                    autocomplete="new-password"
                                    placeholder="••••••••"
                                />
                            </div>
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>

                        <x-primary-button class="w-full py-3.5 text-base">
                            {{ __('Reset Password') }}
                        </x-primary-button>
                    </form>

                    <div class="mt-8 text-center">
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            <a href="{{ route('login') }}" class="font-medium text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300">
                                Back to Sign In
                            </a>
                        </p>
                    </div>

                    <div class="mt-6 text-center">
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            © {{ date('Y') }} {{ config('app.name', 'School CRM') }}. All rights reserved.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePasswordVisibility(button) {
            const input = button.parentElement.querySelector('input[type="password"], input[type="text"]');
            const eyeOpen = button.querySelector('.eye-open');
            const eyeClosed = button.querySelector('.eye-closed');

            if (input.type === 'password') {
                input.type = 'text';
                eyeOpen.classList.add('hidden');
                eyeClosed.classList.remove('hidden');
            } else {
                input.type = 'password';
                eyeOpen.classList.remove('hidden');
                eyeClosed.classList.add('hidden');
            }
        }
    </script>
</x-guest-layout>