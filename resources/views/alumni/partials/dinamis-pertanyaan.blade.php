@foreach ($halaman->pertanyaans as $pertanyaan)
    @php
        $kondisiStatus = $pertanyaan->kondisiPertanyaan->pluck('nilai_status_kerja')->toArray();
    @endphp

    <div class="question-card bg-white rounded-xl shadow-sm p-6 mb-6 border border-gray-100 hover:border-indigo-100 transition-all duration-200 pertanyaan-item"
        @if (count($kondisiStatus))
            data-status='@json($kondisiStatus)'
        @endif
    >
        <label class="block text-lg font-semibold text-gray-800 mb-4">
            {{ $pertanyaan->teks }}
            @if ($pertanyaan->wajib)
                <span class="text-red-500">*</span>
            @endif
        </label>
       
        {{-- Render input berdasarkan jenis --}}
        @switch($pertanyaan->jenisPertanyaan?->nama)
            @case('text')
                <input type="text" name="answers[{{ $pertanyaan->id }}]"
                    {{ $pertanyaan->wajib ? 'required' : '' }}
                    class="w-full md:w-1/2 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200">
                @break

            @case('textarea')
                <textarea name="answers[{{ $pertanyaan->id }}]" rows="4"
                    {{ $pertanyaan->wajib ? 'required' : '' }}
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"></textarea>
                @break

            @case('radio')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    @foreach ($pertanyaan->opsiJawabans as $index => $opsi)
                    <div class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-white transition-colors duration-200">
                        <input type="radio" 
                            name="answers[{{ $pertanyaan->id }}]" 
                            id="jawaban_{{ $pertanyaan->id }}_{{ $index }}"
                            value="{{ $opsi->teks }}"
                            {{ $pertanyaan->wajib ? 'required' : '' }} 
                            class="w-4 h-4 text-indigo-600 focus:ring-indigo-500 border-gray-300"
                            onchange="handleOtherOption(this, {{ $pertanyaan->id }})">
                        <label for="jawaban_{{ $pertanyaan->id }}_{{ $index }}" class="ml-3 text-sm text-gray-700 cursor-pointer">
                        {{ $opsi->teks }}
                        </label>
                    </div>
                    @endforeach

                    @if ($pertanyaan->punya_opsi_lain)
                    <!-- Radio "Lainnya" -->
                    <div class="col-span-1 md:col-span-2">
                        <div class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-white transition-colors duration-200">
                        <input type="radio" 
                                name="answers[{{ $pertanyaan->id }}]" 
                                id="jawaban_{{ $pertanyaan->id }}_lainnya"
                                value="Lainnya"
                                {{ $pertanyaan->wajib ? 'required' : '' }}
                                class="w-4 h-4 text-indigo-600 focus:ring-indigo-500 border-gray-300"
                                onchange="handleOtherOption(this, {{ $pertanyaan->id }})">
                        <label for="jawaban_{{ $pertanyaan->id }}_lainnya" class="ml-3 text-sm text-gray-700 cursor-pointer">
                            Lainnya
                        </label>
                        </div>

                        <!-- Input teks "Lainnya" -->
                        <div id="opsiLainInputContainer-{{ $pertanyaan->id }}" class="mt-4 {{ old('answers['.$pertanyaan->id.']') === 'Lainnya' ? '' : 'hidden' }}">
                        <label for="opsiLainInput-{{ $pertanyaan->id }}" class="block text-sm font-medium text-gray-700 mb-2">
                            Tulis jawaban lainnya:
                        </label>
                        <input type="text" 
                                name="answers_lain[{{ $pertanyaan->id }}]" 
                                id="opsiLainInput-{{ $pertanyaan->id }}" 
                                value="{{ old('answers_lain.'.$pertanyaan->id) }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                                placeholder="Tulis jawaban lainnya...">
                        </div>
                    </div>
                    @endif
                </div>
                @break

            @case('checkbox')
                @php
                    $jawabanLainDipilih = is_array(old('answers.' . $pertanyaan->id)) && in_array('Lainnya', old('answers.' . $pertanyaan->id));
                @endphp

                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    {{-- Checkbox Opsi Biasa --}}
                    @foreach ($pertanyaan->opsiJawabans as $index => $opsi)
                    <div class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-white transition-colors duration-200">
                        <input type="checkbox" 
                            name="answers[{{ $pertanyaan->id }}][]" 
                            id="checkbox_{{ $pertanyaan->id }}_{{ $index }}"
                            value="{{ $opsi->teks }}"
                            class="w-4 h-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                            @checked(is_array(old('answers.' . $pertanyaan->id)) && in_array($opsi->teks, old('answers.' . $pertanyaan->id)))>
                        <label for="checkbox_{{ $pertanyaan->id }}_{{ $index }}" class="ml-3 text-sm text-gray-700 cursor-pointer">
                            {{ $opsi->teks }}
                        </label>
                    </div>
                    @endforeach

                    {{-- Checkbox "Lainnya" --}}
                    @if ($pertanyaan->punya_opsi_lain)
                    <div class="col-span-1 md:col-span-2">
                        <div class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-white transition-colors duration-200">
                            <input type="checkbox" 
                                name="answers[{{ $pertanyaan->id }}][]" 
                                id="checkbox_{{ $pertanyaan->id }}_lainnya"
                                value="Lainnya"
                                class="w-4 h-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                {{ $jawabanLainDipilih ? 'checked' : '' }}>
                            <label for="checkbox_{{ $pertanyaan->id }}_lainnya" class="ml-3 text-sm text-gray-700 cursor-pointer">
                                Lainnya
                            </label>
                        </div>

                        {{-- Input teks untuk "Lainnya" --}}
                        <div id="opsiLainInputContainer-{{ $pertanyaan->id }}" class="mt-4 {{ $jawabanLainDipilih ? '' : 'hidden' }}">
                            <label for="opsiLainInput-{{ $pertanyaan->id }}" class="block text-sm font-medium text-gray-700 mb-2">
                                Tulis jawaban lainnya:
                            </label>
                            <input type="text" 
                                name="answers_lain[{{ $pertanyaan->id }}]" 
                                id="opsiLainInput-{{ $pertanyaan->id }}" 
                                value="{{ $jawabanLainDipilih ? old('answers_lain.' . $pertanyaan->id) : '' }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                                placeholder="Tulis jawaban lainnya...">
                        </div>
                    </div>
                    @endif
                </div>
                @break



            @case('select')
                <select name="answers[{{ $pertanyaan->id }}]"
                    {{ $pertanyaan->wajib ? 'required' : '' }}
                    class="w-full md:w-1/2 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200">
                    <option value="">-- Pilih --</option>
                    @foreach ($pertanyaan->opsiJawabans as $opsi)
                        <option value="{{ $opsi->teks }}">{{ $opsi->teks }}</option>
                    @endforeach
                </select>
                @break

            @case('scale')
                @php
                    $labels = $pertanyaan->atribut_ekstra['labels'] ?? [];
                    $range = $pertanyaan->atribut_ekstra['range'] ?? [1, 5];
                    $start = (int) $range[0];
                    $end = (int) $range[1];
                @endphp

                <div class="w-full max-w-xl mx-auto">
                    <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                        {{-- Label ujung kiri-kanan (atas) --}}
                        @if (count($labels) >= 2)
                            <div class="flex justify-between mb-4 text-sm font-medium text-gray-600">
                                <span class="max-w-[45%]">{{ $labels[0] }}</span>
                                <span class="max-w-[45%] text-right">{{ $labels[1] }}</span>
                            </div>
                        @endif

                        {{-- Baris angka + radio button --}}
                        <div class="relative">
                            <div class="absolute top-1/2 left-0 right-0 h-1 bg-gray-200 -z-10 transform -translate-y-1/2 rounded-full"></div>

                            <div class="flex justify-between items-center">
                                @foreach ($pertanyaan->opsiJawabans as $opsi)
                                    <label class="flex flex-col items-center cursor-pointer group">
                                        <div class="relative mb-2">
                                            <input type="radio" 
                                                name="answers[{{ $pertanyaan->id }}]" 
                                                value="{{ $opsi->teks }}"
                                                {{ $pertanyaan->wajib ? 'required' : '' }} 
                                                class="sr-only peer">

                                            <div class="w-6 h-6 bg-white border-2 border-gray-300 rounded-full 
                                                    peer-checked:border-indigo-500 peer-checked:bg-indigo-500 
                                                    group-hover:border-indigo-400 transition-all duration-150
                                                    flex items-center justify-center">
                                                <div class="w-2 h-2 bg-white rounded-full opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                                            </div>
                                        </div>
                                        <span class="text-sm font-medium text-gray-700 group-hover:text-indigo-600">
                                            {{ $opsi->teks }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        {{-- Label bawah kiri-kanan (mobile) --}}
                        @if (count($labels) >= 2)
                            <div class="flex justify-between mt-4 text-xs text-gray-500 md:hidden">
                                <span class="max-w-[40%]">{{ $labels[0] }}</span>
                                <span class="max-w-[40%] text-right">{{ $labels[1] }}</span>
                            </div>
                        @endif
                    </div>
                </div>
                @break

            @case('matrix')
                <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-sm">
                    <table class="min-w-full text-sm text-gray-700">
                    <thead class="bg-gradient-to-r from-blue-50 to-indigo-100">
                        <tr>
                        <th class="px-6 py-3 text-left font-semibold text-gray-700">Pernyataan</th>
                        @foreach ($pertanyaan->atribut_ekstra['columns'] ?? [] as $col)
                            <th class="px-6 py-3 text-center font-semibold text-gray-700">{{ $col }}</th>
                        @endforeach
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($pertanyaan->barisMatrixs as $baris)
                        <tr class="hover:bg-gray-50 transition duration-200">
                            <td class="px-6 py-4 font-medium text-gray-900">
                            {{ $baris->label }}
                            </td>
                            @foreach ($pertanyaan->atribut_ekstra['columns'] ?? [] as $colIndex => $col)
                            <td class="px-6 py-4 text-center">
                                <label class="inline-flex items-center justify-center w-6 h-6 rounded-full hover:bg-gray-100 cursor-pointer">
                                <input type="radio"
                                        name="matrix_answers[{{ $pertanyaan->id }}][{{ $baris->id }}]"
                                        value="{{ $col }}"
                                        {{ $pertanyaan->wajib ? 'required' : '' }}
                                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300">
                                </label>
                            </td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                    </table>
                </div>
                @break

        @endswitch

        @error('answers.' . $pertanyaan->id)
            <p class="mt-2 text-sm text-red-600 flex items-center">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                {{ $message }}
            </p>
        @enderror
    </div>
@endforeach

<script>
document.addEventListener('DOMContentLoaded', function() {
  const allRadioInputs = document.querySelectorAll('input[type="radio"][name^="answers["]');
  allRadioInputs.forEach(radio => {
    radio.addEventListener('change', function () {
      const match = this.name.match(/answers\[(\d+)\]/);
      if (!match) return;
      const id = match[1];

      const container = document.getElementById('opsiLainInputContainer-' + id);
      const inputLain = document.getElementById('opsiLainInput-' + id);

      if (this.value === 'Lainnya') {
        container.classList.remove('hidden');
        inputLain.required = true;
      } else {
        container.classList.add('hidden');
        inputLain.required = false;
        inputLain.value = '';
      }
    });
  });
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
  const checkboxes = document.querySelectorAll('input[type="checkbox"][id*="_lainnya"]');

  checkboxes.forEach(checkbox => {
    const match = checkbox.name.match(/answers\[(\d+)\]/);
    if (!match) return;
    const id = match[1];

    const container = document.getElementById('opsiLainInputContainer-' + id);
    const input = document.getElementById('opsiLainInput-' + id);

    if (!container || !input) return;

    // Saat klik atau perubahan nilai
    checkbox.addEventListener('change', function () {
      if (this.checked) {
        container.classList.remove('hidden');
        input.required = true;
      } else {
        container.classList.add('hidden');
        input.required = false;
        input.value = '';
      }
    });

    // Trigger awal agar tampilan sesuai kondisi saat reload
    if (checkbox.checked) {
      container.classList.remove('hidden');
      input.required = true;
    } else {
      container.classList.add('hidden');
      input.required = false;
    }
  });
});
</script>
