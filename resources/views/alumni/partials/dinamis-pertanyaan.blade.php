 @foreach ($halaman->pertanyaans as $pertanyaan)
                @php
                    $kondisiStatus = $pertanyaan->kondisiPertanyaan->pluck('nilai_status_kerja')->toArray();
                @endphp
       
                <div class="w-full bg-white p-6 rounded shadow mb-6 pertanyaan-item"
                    @if (count($kondisiStatus))
                        data-status='@json($kondisiStatus)'
                    @endif
                >
                    <label class="block font-semibold text-base text-gray-700 mb-3">
                        {{ $pertanyaan->teks }}
                        @if ($pertanyaan->wajib)
                            <span class="text-red-600">*</span>
                        @endif
                    </label>
                   
                    {{-- Render input berdasarkan jenis --}}
                    @switch($pertanyaan->jenisPertanyaan?->nama)
                        @case('text')
                            <input type="text" name="answers[{{ $pertanyaan->id }}]"
                                {{ $pertanyaan->wajib ? 'required' : '' }}
                                class="w-full sm:w-1/2 border-b border-gray-300 focus:border-orange-600 py-2 bg-transparent text-base">
                            @break

                        @case('textarea')
                            <textarea name="answers[{{ $pertanyaan->id }}]" rows="4"
                                {{ $pertanyaan->wajib ? 'required' : '' }}
                                class="w-full border border-gray-300 rounded-md shadow-sm"></textarea>
                            @break

                        @case('radio')
                            <div class="space-y-2">
                                @foreach ($pertanyaan->opsiJawabans as $opsi)
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="answers[{{ $pertanyaan->id }}]" value="{{ $opsi->teks }}"
                                            {{ $pertanyaan->wajib ? 'required' : '' }} class="text-blue-600"
                                            onchange="handleOtherOption(this, {{ $pertanyaan->id }})">
                                        <span class="ml-2">{{ $opsi->teks }}</span>
                                    </label>
                                @endforeach

                                @if ($pertanyaan->punya_opsi_lain)
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="answers[{{ $pertanyaan->id }}]" value="Lainnya"
                                            {{ $pertanyaan->wajib ? 'required' : '' }} class="text-blue-600"
                                            onchange="handleOtherOption(this, {{ $pertanyaan->id }})">
                                        <span class="ml-2">Lainnya</span>
                                    </label>
                                    <input type="text" name="answers_lain[{{ $pertanyaan->id }}]"
                                        id="opsiLainInput-{{ $pertanyaan->id }}" class="mt-2 form-input w-full sm:w-1/2 border-gray-300 hidden"
                                        placeholder="Tulis jawaban lainnya...">
                                @endif
                            </div>
                            @break

                       @case('checkbox')
                        <div class="space-y-2">
                            @foreach ($pertanyaan->opsiJawabans as $opsi)
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="answers[{{ $pertanyaan->id }}][]" value="{{ $opsi->teks }}"
                                        class="w-5 h-5 text-blue-600">
                                    <span class="ml-2">{{ $opsi->teks }}</span>
                                </label>
                            @endforeach

                            @if ($pertanyaan->punya_opsi_lain)
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="answers[{{ $pertanyaan->id }}][]" value="Lainnya"
                                        onchange="handleCheckboxOtherOption(this, {{ $pertanyaan->id }})"
                                        class="w-5 h-5 text-blue-600">
                                    <span class="ml-2">Lainnya</span>
                                </label>
                                <input type="text" name="answers_lain[{{ $pertanyaan->id }}]"
                                    id="opsiLainInput-{{ $pertanyaan->id }}" class="mt-2 form-input w-full sm:w-1/2 border-gray-300 hidden"
                                    placeholder="Tulis jawaban lainnya...">
                            @endif
                        </div>
                        @break


                        @case('select')
                            <select name="answers[{{ $pertanyaan->id }}]"
                                {{ $pertanyaan->wajib ? 'required' : '' }}
                                class="w-full sm:w-1/2 border-b border-gray-300 focus:border-orange-600 py-2 bg-transparent text-base">
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
                                    <div class="bg-white p-4 rounded-md border border-gray-200">
                                        {{-- Label ujung kiri-kanan (atas) --}}
                                        @if (count($labels) >= 2)
                                            <div class="flex justify-between mb-3 text-sm text-gray-600">
                                                <span>{{ $labels[0] }}</span>
                                                <span>{{ $labels[1] }}</span>
                                            </div>
                                        @endif

                                        {{-- Baris angka + radio button --}}
                                        <div class="relative">
                                            <div class="absolute top-4 left-0 right-0 h-0.5 bg-gray-200 -z-10"></div>

                                            <div class="flex justify-between items-center">
                                                @foreach ($pertanyaan->opsiJawabans as $opsi)
                                                    <label class="flex flex-col items-center cursor-pointer group text-xs">
                                                        <div class="relative">
                                                            <input type="radio" 
                                                                name="answers[{{ $pertanyaan->id }}]" 
                                                                value="{{ $opsi->teks }}"
                                                                {{ $pertanyaan->wajib ? 'required' : '' }} 
                                                                class="sr-only peer">

                                                            {{-- Radio lebih kecil --}}
                                                            <div class="w-5 h-5 bg-white border-2 border-gray-300 rounded-full 
                                                                        peer-checked:border-blue-500 peer-checked:bg-blue-500 
                                                                        group-hover:border-blue-400 transition-all duration-150
                                                                        flex items-center justify-center">
                                                                <div class="w-1.5 h-1.5 bg-white rounded-full opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                                                            </div>
                                                        </div>
                                                        <span class="text-gray-700 group-hover:text-blue-600 font-medium">
                                                            {{ $opsi->teks }}
                                                        </span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>

                                        {{-- Label bawah kiri-kanan (mobile) --}}
                                        @if (count($labels) >= 2)
                                            <div class="flex justify-between mt-3 text-xs text-gray-400 md:hidden">
                                                <span class="max-w-[40%]">{{ $labels[0] }}</span>
                                                <span class="max-w-[40%] text-right">{{ $labels[1] }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                @break


                     @case('matrix')
                    <div class="overflow-x-auto">
                        <table class="min-w-full border text-sm">
                            <thead class="bg-gray-100 text-gray-700">
                                <tr>
                                    <th class="border px-4 py-2">MATRIX ROWS</th>
                                    @foreach ($pertanyaan->atribut_ekstra['columns'] ?? [] as $col)
                                        <th class="border px-4 py-2 text-center">{{ $col }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pertanyaan->barisMatrixs as $baris)
                                    <tr>
                                        <td class="border px-4 py-2 font-medium">{{ $baris->label }}</td>
                                        @foreach ($pertanyaan->atribut_ekstra['columns'] ?? [] as $colIndex => $col)
                                            <td class="border px-4 py-2 text-center">
                                                <input type="radio"
                                                    name="matrix_answers[{{ $pertanyaan->id }}][{{ $baris->id }}]"
                                                    value="{{ $col }}"
                                                    {{ $pertanyaan->wajib ? 'required' : '' }}
                                                    class="text-blue-600">
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
                        <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>
            @endforeach