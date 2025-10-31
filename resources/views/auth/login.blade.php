<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Floating Error Toast (top-right) -->
    @if ($errors->any())
        <div id="loginErrorToast" class="fixed top-4 right-4 z-50 max-w-sm w-full sm:max-w-md">
            <div role="alert" aria-live="assertive" aria-atomic="true"
                class="bg-red-50 border-l-4 border-red-400 p-4 rounded-lg shadow-lg flex items-start space-x-3"
                style="animation: slideInFromRight 260ms ease-out;">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="flex-1">
                    <div class="flex items-start justify-between">
                        <h3 class="text-sm font-medium text-red-800">Login Gagal!</h3>
                        <button id="closeLoginErrorToast" type="button"
                            class="ml-4 text-red-600 hover:text-red-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-300 rounded">
                            <span class="sr-only">Tutup notifikasi</span>
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="mt-2 text-sm text-red-700">
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <style>
            @keyframes slideInFromRight {
                from {
                    opacity: 0;
                    transform: translateX(12px);
                }

                to {
                    opacity: 1;
                    transform: translateX(0);
                }
            }
            @media (max-width: 480px) {
                #loginErrorToast {
                    left: 12px !important;
                    right: 12px !important;
                    top: 12px !important;
                    max-width: calc(100% - 24px) !important;
                }
            }
        </style>
    @endif


    <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-2xl shadow-xl border border-gray-100">
        <!-- Header Section -->
        <div class="text-center">
            <div class="flex justify-center mb-6">
                <div class="relative">
                    <div
                        class="absolute inset-0 bg-gradient-to-r from-blue-400 to-indigo-500 rounded-full blur opacity-30">
                    </div>
                    <img src="/images/logo-itats-new.png" alt="logo itats" width="100" class="relative z-10 mx-auto">
                </div>
            </div>
            <h2 class="text-3xl font-bold text-gray-900 mb-2">Selamat Datang</h2>
            <p class="text-gray-600">Masuk ke akun ITATS Anda</p>
        </div>

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <!-- Email Address -->
            <div class="group">
                <x-input-label for="email" :value="__('Email')" class="text-gray-700 font-medium" />
                <div class="mt-2 relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400 group-focus-within:text-blue-500 transition-colors"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                        </svg>
                    </div>
                    <x-text-input id="email"
                        class="block w-full pl-10 pr-3 py-3 border {{ $errors->has('email') ? 'border-red-500 bg-red-50' : 'border-gray-300 bg-gray-50' }} rounded-lg focus:ring-2 {{ $errors->has('email') ? 'focus:ring-red-500 focus:border-red-500' : 'focus:ring-blue-500 focus:border-blue-500' }} transition-all duration-200 focus:bg-white"
                        type="email" name="email" :value="old('email')" required autofocus autocomplete="username"
                        placeholder="nama@email.com" />
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="group">
                <x-input-label for="password" :value="__('Password')" class="text-gray-700 font-medium" />
                <div class="mt-2 relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400 group-focus-within:text-blue-500 transition-colors"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <x-text-input id="password"
                        class="block w-full pl-10 pr-12 py-3 border {{ $errors->has('password') ? 'border-red-500 bg-red-50' : 'border-gray-300 bg-gray-50' }} rounded-lg focus:ring-2 {{ $errors->has('password') ? 'focus:ring-red-500 focus:border-red-500' : 'focus:ring-blue-500 focus:border-blue-500' }} transition-all duration-200 focus:bg-white"
                        type="password" name="password" required autocomplete="current-password"
                        placeholder="Masukkan password Anda" />
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                        <button type="button" id="togglePassword"
                            class="text-gray-400 hover:text-gray-600 focus:outline-none focus:text-gray-600 transition-colors">
                            <svg id="eyeIcon" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg id="eyeSlashIcon" class="h-5 w-5 hidden" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21" />
                            </svg>
                        </button>
                    </div>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="flex items-center justify-between">
                <label for="remember_me" class="flex items-center cursor-pointer group">
                    <input id="remember_me" type="checkbox"
                        class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500 focus:ring-offset-0 transition-all duration-200 group-hover:border-blue-400"
                        name="remember">
                    <span
                        class="ml-2 text-sm text-gray-600 group-hover:text-gray-700 transition-colors">{{ __('Remember me') }}</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="text-sm text-blue-600 hover:text-blue-800 font-medium transition-colors duration-200"
                        href="{{ route('password.request') }}">
                        {{ __('Lupa password?') }}
                    </a>
                @endif
            </div>

            <!-- Login Button -->
            <div class="pt-4">
                <x-primary-button
                    class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 transform hover:scale-105">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                    </svg>
                    {{ __('Masuk') }}
                </x-primary-button>
            </div>
        </form>

        <!-- Footer -->
        <div class="text-center pt-6 border-t border-gray-100">
            <p class="text-xs text-gray-500">
                © 2024 Institut Teknologi Adhi Tama Surabaya
            </p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const togglePassword = document.getElementById('togglePassword');
            const passwordField = document.getElementById('password');
            const emailField = document.getElementById('email');
            const eyeIcon = document.getElementById('eyeIcon');
            const eyeSlashIcon = document.getElementById('eyeSlashIcon');

            // Password toggle functionality
            togglePassword.addEventListener('click', function () {
                const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordField.setAttribute('type', type);

                //Kondisi icon mata
                if (type === 'text') {
                    eyeIcon.classList.add('hidden');
                    eyeSlashIcon.classList.remove('hidden');
                } else {
                    eyeIcon.classList.remove('hidden');
                    eyeSlashIcon.classList.add('hidden');
                }
            });

            // Clear error styling when user starts typing
            const clearErrorStyling = (field) => {
                if (field.classList.contains('border-red-500')) {
                    field.classList.remove('border-red-500', 'bg-red-50', 'focus:ring-red-500', 'focus:border-red-500');
                    field.classList.add('border-gray-300', 'bg-gray-50', 'focus:ring-blue-500', 'focus:border-blue-500');
                }
            };

            emailField.addEventListener('input', function () {
                clearErrorStyling(this);
            });

            passwordField.addEventListener('input', function () {
                clearErrorStyling(this);
            });

            // Floating toast dismiss & auto-hide
            const toast = document.getElementById('loginErrorToast');
            const closeToastBtn = document.getElementById('closeLoginErrorToast');

            if (toast) {
                // Auto-hide after 6 seconds
                const hideTimeout = setTimeout(() => {
                    toast.style.transition = 'opacity 220ms ease-out, transform 220ms ease-out';
                    toast.style.opacity = '0';
                    toast.style.transform = 'translateX(8px)';
                    setTimeout(() => toast.remove(), 240);
                }, 6000);

                if (closeToastBtn) {
                    closeToastBtn.addEventListener('click', function () {
                        clearTimeout(hideTimeout);
                        toast.style.transition = 'opacity 160ms ease-out, transform 160ms ease-out';
                        toast.style.opacity = '0';
                        toast.style.transform = 'translateX(8px)';
                        setTimeout(() => toast.remove(), 180);
                    });
                }
            }
        });
    </script>
</x-guest-layout>