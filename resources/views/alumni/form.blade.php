<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Formulir Alumni - Tracer Study ITATS</title>
    @vite('resources/css/app.css')
    <style>
        .progress-bar-fill {
            background-color: #3b82f6;
            height: 100%;
            width: 0%;
            transition: width 0.3s ease;
        }
    </style>
</head>
<body class="bg-[#F2EBDC] min-h-screen flex items-center justify-center">
    <div class="bg-gray-100 w-full max-w-[40rem] mx-auto bg-transparent">
        @include('alumni.partials.nav-form')
        <img src="{{ asset('images/image.png') }}" alt="Ilustrasi Tracer Study" class="py-4 relative rounded">
        @include('alumni.partials.box-sambutan')

        <form id="multiStepForm" action="{{ route('alumni.form.submit') }}" method="POST" class="space-y-6">
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
                        <h2 class="text-lg font-bold mb-2">{{ $halaman->judul }}</h2>
                        @if ($halaman->deskripsi)
                            <p class="mb-4 text-sm text-gray-600">{{ $halaman->deskripsi }}</p>
                        @endif
                        <p class="text-sm text-gray-500">
                            Jumlah pertanyaan: <span class="jumlah-pertanyaan" data-step="{{ $stepIndex }}">0</span>
                        </p>
                        @include('alumni.partials.dinamis-pertanyaan', ['halaman' => $halaman])
                    </div>
                    @php $stepIndex++; @endphp
                @endif
            @empty
                <p class="text-red-500">⚠️ Tidak ada halaman ditemukan.</p>
            @endforelse

            <!-- Navigasi & Tombol -->
            <div class="flex items-center justify-between mt-8">
                <button type="button" id="resetBtn" class="text-gray-500 hover:text-red-600 font-normal transition">
                    Reset Formulir
                </button>

                <div class="flex-1 flex items-center justify-center gap-4">
                    <span class="text-gray-600 text-sm">
                        Halaman <span id="currentPage" class="font-semibold text-blue-600">1</span> dari
                        <span id="totalPages">1</span>
                    </span>
                    <div class="w-56 bg-gray-200 rounded-full h-1.5 overflow-hidden">
                        <div id="progressFill" class="progress-bar-fill"></div>
                    </div>
                </div>

                <div class="flex gap-3">
                    <button type="button" id="prevBtn" class="hidden bg-transparent border border-gray-300 text-gray-700 px-5 py-2 rounded-lg">
                        Sebelumnya
                    </button>
                    <button type="button" id="nextBtn" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg">
                        Berikutnya
                    </button>
                    <button type="submit" id="submitBtn" class="hidden bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg">
                        Kirim Formulir
                    </button>
                </div>
            </div>
                 @if ($errors->any())
            <div class="bg-red-100 text-red-800 p-3 rounded">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        </form>
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
                    el.querySelectorAll('[data-required="true"]').forEach(input => {
                        input.setAttribute('required', 'required');
                    });
                } else {
                    el.style.display = 'none';
                    el.querySelectorAll('[required]').forEach(input => {
                        input.removeAttribute('required');
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
        progressFill.style.width = (step / stepsFiltered.length * 100) + '%';

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
        }
    });

    prevBtn?.addEventListener('click', () => {
        if (currentStep > 1) {
            currentStep--;
            showFilteredStep(currentStep);
        }
    });

    resetBtn?.addEventListener('click', () => {
        form.reset();
        currentStep = 1;
        if (statusSelect) {
            filterHalamanBerdasarkanStatus(statusSelect.value);
        } else {
            showFilteredStep(currentStep);
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
