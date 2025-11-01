<section>
    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        <!-- Current Password -->
        <div class="group space-y-2">
            <x-input-label for="update_password_current_password" :value="__('Password Saat Ini')"
                class="text-gray-700 font-medium" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400 group-focus-within:text-emerald-500 transition-colors" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <x-text-input id="update_password_current_password"
                    class="block w-full pl-10 pr-12 py-3 border {{ $errors->updatePassword->has('current_password') ? 'border-red-500 bg-red-50' : 'border-gray-300' }} rounded-lg focus:ring-2 {{ $errors->updatePassword->has('current_password') ? 'focus:ring-red-500 focus:border-red-500' : 'focus:ring-emerald-500 focus:border-emerald-500' }} transition-all duration-200"
                    type="password" name="current_password" required autocomplete="current-password"
                    placeholder="Masukkan password saat ini" />
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                    <button type="button"
                        class="toggle-password text-gray-400 hover:text-gray-600 focus:outline-none focus:text-gray-600 transition-colors"
                        data-target="update_password_current_password">
                        <svg class="eye-icon h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg class="eye-slash-icon h-5 w-5 hidden" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21" />
                        </svg>
                    </button>
                </div>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <!-- New Password -->
        <div class="group space-y-2">
            <x-input-label for="update_password_password" :value="__('Password Baru')"
                class="text-gray-700 font-medium" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400 group-focus-within:text-emerald-500 transition-colors" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <x-text-input id="update_password_password"
                    class="block w-full pl-10 pr-12 py-3 border {{ $errors->updatePassword->has('password') ? 'border-red-500 bg-red-50' : 'border-gray-300' }} rounded-lg focus:ring-2 {{ $errors->updatePassword->has('password') ? 'focus:ring-red-500 focus:border-red-500' : 'focus:ring-emerald-500 focus:border-emerald-500' }} transition-all duration-200"
                    type="password" name="password" required autocomplete="new-password"
                    placeholder="Masukkan password baru"
                    oninput="validatePasswordStrength(this); validatePasswordMatch();" />
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                    <button type="button"
                        class="toggle-password text-gray-400 hover:text-gray-600 focus:outline-none focus:text-gray-600 transition-colors"
                        data-target="update_password_password">
                        <svg class="eye-icon h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg class="eye-slash-icon h-5 w-5 hidden" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21" />
                        </svg>
                    </button>
                </div>
            </div>
            <!-- Password strength indicator -->
            <div id="password-strength" class="mt-2 hidden">
                <div class="flex items-center space-x-2">
                    <div class="flex-1 bg-gray-200 rounded-full h-2">
                        <div id="strength-bar" class="h-2 rounded-full transition-all duration-300"></div>
                    </div>
                    <span id="strength-text" class="text-xs font-medium"></span>
                </div>
                <p class="text-xs text-gray-500 mt-1">Password harus minimal 5 karakter dengan kombinasi huruf, angka,
                    dan simbol</p>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="group space-y-2">
            <x-input-label for="update_password_password_confirmation" :value="__('Konfirmasi Password')"
                class="text-gray-700 font-medium" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400 group-focus-within:text-emerald-500 transition-colors" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <x-text-input id="update_password_password_confirmation"
                    class="block w-full pl-10 pr-12 py-3 border {{ $errors->updatePassword->has('password_confirmation') ? 'border-red-500 bg-red-50' : 'border-gray-300' }} rounded-lg focus:ring-2 {{ $errors->updatePassword->has('password_confirmation') ? 'focus:ring-red-500 focus:border-red-500' : 'focus:ring-emerald-500 focus:border-emerald-500' }} transition-all duration-200"
                    type="password" name="password_confirmation" required autocomplete="new-password"
                    placeholder="Konfirmasi password baru" oninput="validatePasswordMatch();" />
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                    <button type="button"
                        class="toggle-password text-gray-400 hover:text-gray-600 focus:outline-none focus:text-gray-600 transition-colors"
                        data-target="update_password_password_confirmation">
                        <svg class="eye-icon h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg class="eye-slash-icon h-5 w-5 hidden" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21" />
                        </svg>
                    </button>
                </div>
            </div>
            <!-- Password match indicator -->
            <div id="password-match" class="mt-2 hidden">
                <div class="flex items-center space-x-2">
                    <svg id="match-icon" class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span id="match-text" class="text-sm font-medium"></span>
                </div>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center justify-between pt-4">
            <div class="flex items-center gap-4">
                <x-primary-button id="save-password-btn" disabled
                    class="bg-emerald-600 hover:bg-emerald-700 focus:ring-emerald-500 disabled:bg-gray-400">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    {{ __('Perbarui Password') }}
                </x-primary-button>

                @if (session('status') === 'password-updated')
                    <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
                        class="flex items-center text-sm text-green-600 bg-green-50 px-3 py-2 rounded-lg border border-green-200">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                        {{ __('Password berhasil diperbarui!') }}
                    </div>
                @endif
            </div>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Password toggle functionality
            const toggleButtons = document.querySelectorAll('.toggle-password');

            toggleButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const targetId = this.getAttribute('data-target');
                    const passwordField = document.getElementById(targetId);
                    const eyeIcon = this.querySelector('.eye-icon');
                    const eyeSlashIcon = this.querySelector('.eye-slash-icon');

                    if (passwordField.type === 'password') {
                        passwordField.type = 'text';
                        eyeIcon.classList.add('hidden');
                        eyeSlashIcon.classList.remove('hidden');
                    } else {
                        passwordField.type = 'password';
                        eyeIcon.classList.remove('hidden');
                        eyeSlashIcon.classList.add('hidden');
                    }
                });
            });

            // Clear error styling when user starts typing
            const clearErrorStyling = (field) => {
                if (field.classList.contains('border-red-500')) {
                    field.classList.remove('border-red-500', 'bg-red-50', 'focus:ring-red-500', 'focus:border-red-500');
                    field.classList.add('border-gray-300', 'focus:ring-emerald-500', 'focus:border-emerald-500');
                }
            };

            const passwordFields = [
                'update_password_current_password',
                'update_password_password',
                'update_password_password_confirmation'
            ];

            passwordFields.forEach(fieldId => {
                const field = document.getElementById(fieldId);
                if (field) {
                    field.addEventListener('input', function () {
                        clearErrorStyling(this);
                    });
                }
            });
        });

        // Password strength validation
        function validatePasswordStrength(input) {
            const password = input.value;
            const strengthIndicator = document.getElementById('password-strength');
            const strengthBar = document.getElementById('strength-bar');
            const strengthText = document.getElementById('strength-text');

            if (password.length === 0) {
                strengthIndicator.classList.add('hidden');
                return;
            }

            strengthIndicator.classList.remove('hidden');

            let score = 0;
            let feedback = [];

            // Length check
            if (password.length >= 5) score += 1;
            else feedback.push('minimal 5 karakter');

            // Lowercase letter
            if (/[a-z]/.test(password)) score += 1;
            else feedback.push('huruf kecil');

            // Uppercase letter
            if (/[A-Z]/.test(password)) score += 1;
            else feedback.push('huruf besar');

            // Number
            if (/\d/.test(password)) score += 1;
            else feedback.push('angka');

            // Special character
            if (/[^A-Za-z0-9]/.test(password)) score += 1;
            else feedback.push('simbol');

            // Update strength bar and text
            const strengthLevels = [
                { width: '20%', color: 'bg-red-500', text: 'Sangat Lemah', textColor: 'text-red-600' },
                { width: '40%', color: 'bg-red-400', text: 'Lemah', textColor: 'text-red-500' },
                { width: '60%', color: 'bg-yellow-400', text: 'Sedang', textColor: 'text-yellow-600' },
                { width: '80%', color: 'bg-emerald-400', text: 'Kuat', textColor: 'text-emerald-600' },
                { width: '100%', color: 'bg-emerald-500', text: 'Sangat Kuat', textColor: 'text-emerald-600' }
            ];

            const level = strengthLevels[score] || strengthLevels[0];

            strengthBar.style.width = level.width;
            strengthBar.className = `h-2 rounded-full transition-all duration-300 ${level.color}`;
            strengthText.textContent = level.text;
            strengthText.className = `text-xs font-medium ${level.textColor}`;

            // Update input styling based on strength
            if (score >= 3) {
                input.style.borderColor = '#10b981'; // emerald-500
            } else if (score >= 2) {
                input.style.borderColor = '#f59e0b'; // yellow-500
            } else {
                input.style.borderColor = '#ef4444'; // red-500
            }
        }

        // Password match validation
        function validatePasswordMatch() {
            const password = document.getElementById('update_password_password').value;
            const confirmPassword = document.getElementById('update_password_password_confirmation').value;
            const matchIndicator = document.getElementById('password-match');
            const matchIcon = document.getElementById('match-icon');
            const matchText = document.getElementById('match-text');
            const saveButton = document.getElementById('save-password-btn');
            const confirmField = document.getElementById('update_password_password_confirmation');

            if (confirmPassword.length === 0) {
                matchIndicator.classList.add('hidden');
                saveButton.disabled = true;
                return;
            }

            matchIndicator.classList.remove('hidden');

            if (password === confirmPassword && password.length >= 5) {
                // Passwords match and meet minimum length
                matchIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />';
                matchIcon.className = 'h-4 w-4 text-emerald-600';
                matchText.textContent = 'Password cocok!';
                matchText.className = 'text-sm font-medium text-emerald-600';
                confirmField.style.borderColor = '#10b981'; // emerald-500
                saveButton.disabled = false;
            } else if (password === confirmPassword) {
                // Passwords match but too short
                matchIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L4.732 16.5c-.77.833.192 2.5 1.732 2.5z" />';
                matchIcon.className = 'h-4 w-4 text-yellow-600';
                matchText.textContent = 'Password terlalu pendek (minimal 5 karakter)';
                matchText.className = 'text-sm font-medium text-yellow-600';
                confirmField.style.borderColor = '#f59e0b'; // yellow-500
                saveButton.disabled = true;
            } else {
                // Passwords don't match
                matchIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />';
                matchIcon.className = 'h-4 w-4 text-red-600';
                matchText.textContent = 'Password tidak cocok';
                matchText.className = 'text-sm font-medium text-red-600';
                confirmField.style.borderColor = '#ef4444'; // red-500
                saveButton.disabled = true;
            }
        }
    </script>
</section>