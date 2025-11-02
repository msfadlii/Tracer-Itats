<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Formulir Alumni - Tracer Study ITATS</title>
    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8fafc;
        }

        .progress-bar-fill {
            background: linear-gradient(90deg, #4F46E5 0%, #7C3AED 100%);
            height: 100%;
            width: 0%;
            transition: width 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 9999px;
        }

        .form-container {
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            border-radius: 1.5rem;
            overflow: hidden;
        }

        .step {
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .input-field {
            transition: all 0.3s ease;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        }

        .input-field:focus {
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.3);
            border-color: #6366f1;
        }

        .btn-primary {
            background: linear-gradient(90deg, #4F46E5 0%, #7C3AED 100%);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.3), 0 2px 4px -1px rgba(79, 70, 229, 0.2);
        }

        .question-card {
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
        }

        .question-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            border-left-color: #4F46E5;
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-4xl mx-auto">
        <!-- Header Section -->
        @include('alumni.partials.nav-form')
        @include('alumni.partials.box-sambutan')
        <!-- Main Form Container -->
        <div class="form-container bg-white">
            <!-- Progress Bar -->
            <div class="px-6 pt-6">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-medium text-gray-700">
                        <span id="currentPage" class="text-indigo-600">1</span> dari
                        <span id="totalPages">1</span> langkah
                    </span>
                    <span class="text-sm font-medium text-indigo-600">
                        <span id="progressPercentage">0</span>% selesai
                    </span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2.5">
                    <div id="progressFill" class="progress-bar-fill"></div>
                </div>
            </div>

            <!-- Form Content -->
            <form id="multiStepForm" action="{{ route('alumni.form.submit') }}" method="POST" class="space-y-6 p-6">
                @csrf

                <!-- STEP 1: Informasi Alumni -->
                <div class="step" id="step1">
                    @include('alumni.partials.form-informasi-alumni')
                </div>

                <!-- STEP 2-n: Halaman Pertanyaan Dinamis -->
                @php $stepIndex = 2; @endphp
                @forelse ($halamanKuesioners as $halaman)
                    @if ($halaman->urutan != 0)
                        <div class="step hidden" id="step{{ $stepIndex }}">
                            <!-- Header Section -->
                            <div class="bg-indigo-50 rounded-xl p-6 mb-6 border border-indigo-100">
                                <div class="flex items-start gap-4">

                                    <div>
                                        <h2 class="text-xl font-bold text-gray-800 mb-1">{{ $halaman->judul }}</h2>
                                        @if ($halaman->deskripsi)
                                            <p class="text-gray-600 mb-2">{{ $halaman->deskripsi }}</p>
                                        @endif
                                        <div class="flex items-center text-sm text-gray-500">
                                            <span class="flex items-center mr-4">
                                                <span class="jumlah-pertanyaan" data-step="{{ $stepIndex }}">0</span>
                                                <span class="ml-1">pertanyaan</span>
                                            </span>

                                            @if($halaman->estimasi_waktu)
                                                <span class="flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    Estimasi: {{ $halaman->estimasi_waktu }} menit
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Questions container -->
                            <div class="space-y-4">
                                @include('alumni.partials.dinamis-pertanyaan', ['halaman' => $halaman])
                            </div>
                        </div>
                        @php $stepIndex++; @endphp
                    @endif
                @empty
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-yellow-700">
                                    Tidak ada halaman kuesioner yang tersedia saat ini.
                                </p>
                            </div>
                        </div>
                    </div>
                @endforelse

                <!-- Navigation Buttons -->
                <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                    <button type="button" id="resetBtn"
                        class="text-gray-500 hover:text-red-600 font-medium transition flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Reset Formulir
                    </button>

                    <div class="flex gap-3">
                        <button type="button" id="prevBtn"
                            class="hidden bg-white border border-gray-300 text-gray-700 px-5 py-2.5 rounded-lg font-medium hover:bg-gray-50 transition">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 19l-7-7 7-7" />
                                </svg>
                                Sebelumnya
                            </div>
                        </button>
                        <button type="button" id="nextBtn"
                            class="btn-primary text-white px-6 py-2.5 rounded-lg font-medium">
                            <div class="flex items-center">
                                Berikutnya
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </div>
                        </button>
                        <button type="submit" id="submitBtn"
                            class="hidden bg-green-600 hover:bg-green-700 text-white px-6 py-2.5 rounded-lg font-medium transition">
                            Kirim Formulir
                        </button>
                    </div>
                </div>

                @if ($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-400 p-4 mt-6">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Terdapat {{ $errors->count() }} error dalam
                                    pengisian form:</h3>
                                <div class="mt-2 text-sm text-red-700">
                                    <ul class="list-disc pl-5 space-y-1">
                                        @foreach ($errors->all() as $err)
                                            <li>{{ $err }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let steps = Array.from(document.querySelectorAll('.step'));
            let stepsFiltered = [];
            let currentStep = 1;
            let totalSteps = 0;

            const nextBtn = document.getElementById('nextBtn');
            const prevBtn = document.getElementById('prevBtn');
            const submitBtn = document.getElementById('submitBtn');
            const progressFill = document.getElementById('progressFill');
            const currentPage = document.getElementById('currentPage');
            const totalPages = document.getElementById('totalPages');
            const progressPercentage = document.getElementById('progressPercentage');
            const resetBtn = document.getElementById('resetBtn');
            const form = document.getElementById('multiStepForm');
            const statusSelect = document.querySelector('select[name="status"]');

            function filterHalamanBerdasarkanStatus(status) {
                stepsFiltered = [];

                steps.forEach((stepEl, i) => {
                    const pertanyaans = stepEl.querySelectorAll('.pertanyaan-item');
                    let jumlahTampil = 0;

                    pertanyaans.forEach(el => {
                        const allowed = el.dataset.status ? JSON.parse(el.dataset.status) : null;
                        const isAllowed = !allowed || allowed.includes(status);

                        if (isAllowed) {
                            el.style.display = '';
                            jumlahTampil++;
                            // Re-apply required attributes untuk validasi yang benar
                            el.querySelectorAll('[data-required="true"]').forEach(input => {
                                input.setAttribute('required', 'required');
                            });
                        } else {
                            el.style.display = 'none';
                            // Remove required attributes dan clear values untuk field yang disembunyikan
                            el.querySelectorAll('[required]').forEach(input => {
                                input.removeAttribute('required');
                                // Clear nilai untuk field yang disembunyikan
                                if (input.type === 'checkbox' || input.type === 'radio') {
                                    input.checked = false;
                                } else {
                                    input.value = '';
                                }
                            });
                        }
                    });

                    const jumlahDisplay = stepEl.querySelector('.jumlah-pertanyaan');
                    if (jumlahDisplay) jumlahDisplay.textContent = jumlahTampil;

                    if (jumlahTampil > 0 || i === 0) {
                        stepEl.classList.remove('hidden');
                        stepsFiltered.push(stepEl);
                    } else {
                        stepEl.classList.add('hidden');
                    }
                });

                totalSteps = stepsFiltered.length;
                currentStep = 1;
                showFilteredStep(currentStep);
            }

            function showFilteredStep(step) {
                stepsFiltered.forEach((s, i) => s.classList.toggle('hidden', i !== step - 1));
                currentPage.textContent = step;
                totalPages.textContent = stepsFiltered.length;

                const progress = (step / stepsFiltered.length * 100);
                progressFill.style.width = progress + '%';
                progressPercentage.textContent = Math.round(progress);

                prevBtn.classList.toggle('hidden', step === 1);
                nextBtn.classList.toggle('hidden', step === stepsFiltered.length);
                submitBtn.classList.toggle('hidden', step !== stepsFiltered.length);
            }

            function isCurrentStepValid() {
                const currentStepEl = stepsFiltered[currentStep - 1];
                const visibleInputs = Array.from(currentStepEl.querySelectorAll('input, select, textarea'))
                    .filter(el => el.offsetParent !== null);
                for (let input of visibleInputs) {
                    if (!input.checkValidity()) {
                        input.reportValidity();
                        return false;
                    }
                }
                return true;
            }

            // Saat status kerja berubah
            if (statusSelect) {
                let hidden = form.querySelector('input[name="status"]');
                if (!hidden) {
                    hidden = document.createElement('input');
                    hidden.type = 'hidden';
                    hidden.name = 'status';
                    form.appendChild(hidden);
                }
                hidden.value = statusSelect.value;
                filterHalamanBerdasarkanStatus(statusSelect.value);

                statusSelect.addEventListener('change', function () {
                    hidden.value = this.value;
                    filterHalamanBerdasarkanStatus(this.value);
                });
            }

            nextBtn?.addEventListener('click', () => {
                if (isCurrentStepValid() && currentStep < totalSteps) {
                    currentStep++;
                    showFilteredStep(currentStep);
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }
            });

            prevBtn?.addEventListener('click', () => {
                if (currentStep > 1) {
                    currentStep--;
                    showFilteredStep(currentStep);
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }
            });

            resetBtn?.addEventListener('click', () => {
                if (confirm('Apakah Anda yakin ingin mereset semua data yang telah diisi?')) {
                    // Reset form
                    form.reset();

                    // Reset semua field "Lainnya" yang mungkin tersembunyi
                    document.querySelectorAll('[id^="opsiLainInput-"]').forEach(input => {
                        input.classList.add('hidden');
                        input.required = false;
                        input.value = '';
                    });

                    // Reset posisi step
                    currentStep = 1;

                    // Reinitialize validasi berdasarkan status yang terpilih
                    if (statusSelect) {
                        const hidden = form.querySelector('input[name="status"]');
                        if (hidden) {
                            hidden.value = statusSelect.value;
                        }
                        // Delay sedikit untuk memastikan DOM sudah ter-reset
                        setTimeout(() => {
                            filterHalamanBerdasarkanStatus(statusSelect.value);
                        }, 100);
                    } else {
                        showFilteredStep(currentStep);
                    }

                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }
            });

            window.handleOtherOption = function (input, id) {
                const isOther = input.value === "Lainnya";
                const inputLain = document.getElementById(`opsiLainInput-${id}`);
                if (inputLain) {
                    inputLain.classList.toggle('hidden', !isOther);
                    inputLain.required = isOther;
                    if (!isOther) inputLain.value = '';
                }
            }

            window.handleCheckboxOtherOption = function (checkbox, id) {
                const inputLain = document.getElementById(`opsiLainInput-${id}`);
                if (inputLain) {
                    inputLain.classList.toggle('hidden', !checkbox.checked);
                    inputLain.required = checkbox.checked;
                    if (!checkbox.checked) inputLain.value = '';
                }
            }
        });
    </script>
</body>

</html>