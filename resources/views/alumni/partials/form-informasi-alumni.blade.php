{{-- Form Informasi Alumni --}}
<div class="space-y-6 w-full">
  <div class="w-full bg-white rounded shadow overflow-hidden">
    <!-- Header Identitas -->
    <div class="bg-orange-700 px-6 py-2">
      <h2 class="text-white text-sm font-semibold">Identitas</h2>
    </div>

    <!-- Tahun Lulus -->
    <div class="pertanyaan-item p-9" data-required="true">
      <label for="tahun_lulus" class="block font-semibold text-base text-gray-700">
        Tahun Lulus <span class="text-red-600">*</span>
      </label>
      <input type="number" id="tahun_lulus" name="tahun_lulus" min="1900" max="2099"
        value="{{ old('tahun_lulus') }}" required
        class="w-1/2 mt-1 border-0 border-b border-gray-300 focus:ring-0 focus:border-orange-600 py-2 bg-transparent text-base placeholder-gray-500"
        placeholder="Jawaban Anda">
      @error('tahun_lulus') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>
  </div>

  <!-- NPM -->
  <div class="pertanyaan-item w-full bg-white p-9 rounded shadow" data-required="true">
    <label for="npm" class="block font-semibold text-base text-gray-700">NPM <span class="text-red-600">*</span></label>
    <input type="text" id="npm" name="npm" value="{{ old('npm') }}" required
      class="w-1/2 mt-1 border-0 border-b border-gray-300 focus:ring-0 focus:border-orange-600 py-2 bg-transparent text-base">
    @error('npm') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
  </div>

  <!-- Nama -->
  <div class="pertanyaan-item w-full bg-white p-9 rounded shadow" data-required="true">
    <label for="nama" class="block font-semibold text-base text-gray-700">Nama <span class="text-red-600">*</span></label>
    <input type="text" id="nama" name="nama" value="{{ old('nama') }}" required
      class="w-1/2 mt-1 border-0 border-b border-gray-300 focus:ring-0 focus:border-orange-600 py-2 bg-transparent text-base">
    @error('nama') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
  </div>

  <!-- NIK -->
  <div class="pertanyaan-item w-full bg-white p-9 rounded shadow" data-required="true">
    <label for="nik" class="block font-semibold text-base text-gray-700">NIK <span class="text-red-600">*</span></label>
    <input type="text" pattern="\d{16}" id="nik" name="nik" value="{{ old('nik') }}" required
      class="w-1/2 mt-1 border-0 border-b border-gray-300 focus:ring-0 focus:border-orange-600 py-2 bg-transparent text-base">
    @error('nik') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
  </div>

  <!-- Tanggal Lahir -->
  <div class="pertanyaan-item w-full bg-white p-9 rounded shadow" data-required="true">
    <label for="tanggal_lahir" class="block font-semibold text-base text-gray-700">Tanggal Lahir <span class="text-red-600">*</span></label>
    <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required
      class="w-1/2 mt-1 border-0 border-b border-gray-300 focus:ring-0 focus:border-orange-600 py-2 bg-transparent text-base">
    @error('tanggal_lahir') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
  </div>

  <!-- Email -->
  <div class="pertanyaan-item w-full bg-white p-9 rounded shadow"data-required="true">
    <label for="email" class="block font-semibold text-base text-gray-700">Email <span class="text-red-600">*</span></label>
    <input type="email" id="email" name="email" value="{{ old('email') }}" required
      class="w-1/2 mt-1 border-0 border-b border-gray-300 focus:ring-0 focus:border-orange-600 py-2 bg-transparent text-base">
    @error('email') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
  </div>

  <!-- Telepon -->
  <div class="pertanyaan-item w-full bg-white p-9 rounded shadow" data-required="true">
    <label for="nomor_telepon" class="block font-semibold text-base text-gray-700">Nomor Telepon <span class="text-red-600">*</span></label>
    <input type="text" id="nomor_telepon" name="telepon" value="{{ old('telepon') }}" required
      class="w-1/2 mt-1 border-0 border-b border-gray-300 focus:ring-0 focus:border-orange-600 py-2 bg-transparent text-base">
    @error('telepon') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
  </div>

  <!-- NPWP -->
  <div class="pertanyaan-item w-full bg-white p-9 rounded shadow" data-required="true">
    <label for="npwp" class="block font-semibold text-base text-gray-700">NPWP</label>
    <input type="text" id="npwp" name="npwp" value="{{ old('npwp') }}"
      class="w-1/2 mt-1 border-0 border-b border-gray-300 focus:ring-0 focus:border-orange-600 py-2 bg-transparent text-base">
    @error('npwp') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
  </div>

  <!-- Dosen Pembimbing -->
  <div class="pertanyaan-item w-full bg-white p-9 rounded shadow" data-required="true">
    <label for="nama_dosen_pembimbing" class="block font-semibold text-base text-gray-700">Dosen Pembimbing <span class="text-red-600">*</span></label>
    <input type="text" id="nama_dosen_pembimbing" name="dosen_pembimbing" value="{{ old('dosen_pembimbing') }}" required
      class="w-1/2 mt-1 border-0 border-b border-gray-300 focus:ring-0 focus:border-orange-600 py-2 bg-transparent text-base">
    @error('dosen_pembimbing') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
  </div>

  <!-- Pembiayaan -->
  <div class="pertanyaan-item w-full bg-white p-9 rounded shadow" data-required="true">
    <label class="block font-semibold text-base text-gray-700 mb-2">
      Sumber Pembiayaan Kuliah <span class="text-red-600">*</span>
    </label>
    @php
      $options = [
        'Biaya Sendiri / Keluarga',
        'Beasiswa ADIK',
        'Beasiswa BIDIK MISI',
        'Beasiswa PPA',
        'Beasiswa AFIRMASI',
        'Beasiswa Perusahaan/Swasta',
        'Yang lain',
      ];
      $pembiayaan = old('pembiayaan');
    @endphp
    @foreach ($options as $index => $item)
      <div class="flex items-center mb-2">
        <input type="radio" name="pembiayaan" id="pembiayaan_{{ $index }}" value="{{ $item }}"
          {{ $pembiayaan === $item ? 'checked' : '' }} required
          class="text-blue-500 focus:ring-blue-500 border-gray-300">
        <label for="pembiayaan_{{ $index }}" class="ml-2 text-sm text-gray-700">{{ $item }}</label>
      </div>
    @endforeach

    <div id="input_lainnya_container" class="pertanyaan-item {{ $pembiayaan === 'Yang lain' ? '' : 'hidden' }}">
      <label for="pembiayaan_lainnya" class="block mt-2 text-sm text-gray-700">Tuliskan sumber lainnya:</label>
      <input type="text" name="pembiayaan_lainnya" id="pembiayaan_lainnya"
        value="{{ old('pembiayaan_lainnya') }}"
        class="w-full mt-1 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 text-base">
    </div>
    @error('pembiayaan') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
  </div>

  <!-- Status -->
  <div class="pertanyaan-item w-full  bg-white p-9 rounded shadow " data-required="true">
    <label for="status" class="block font-semibold text-base text-gray-700">
      Status Saat Ini <span class="text-red-600">*</span>
    </label>
    <select id="status" name="status" required
      class="w-1/2 mt-1 border-0 border-b border-gray-300 focus:ring-0 focus:border-orange-600 py-2 bg-transparent text-base">
      <option value="" disabled selected>Pilih status</option>
      @foreach ([
        'Bekerja (full time/part time)',
        'Belum Memungkinkan Bekerja',
        'Wiraswasta',
        'Melanjutkan Pendidikan',
        'Tidak Kerja Tetapi Sedang Mencari Kerja'
      ] as $status)
        <option value="{{ $status }}" {{ old('status') === $status ? 'selected' : '' }}>{{ $status }}</option>
      @endforeach
    </select>
    @error('status') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
  </div>
</div>
