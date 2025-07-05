<div class="space-y-8">
  <!-- Header Section -->
  <div class="text-center">
    <h1 class="text-2xl font-bold text-gray-900 mb-2">Informasi Alumni</h1>
    <p class="text-gray-600">Lengkapi data diri Anda untuk memulai tracer study</p>
  </div>

  <!-- Form Content -->
  <div class="space-y-6">
    <!-- Personal Information Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
      <!-- Card Header -->
      <div class="bg-gradient-to-r from-indigo-600 to-purple-600 p-5">
        <div class="flex items-center space-x-3">
          <div class="bg-white bg-opacity-20 p-2 rounded-lg">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
          </div>
          <h2 class="text-lg font-semibold text-white">Identitas Pribadi</h2>
        </div>
      </div>

      <!-- Card Body -->
      <div class="p-6 space-y-6">
        <!-- Row 1: Tahun Lulus & NPM -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div class="form-group" data-required="true">
            <label for="tahun_lulus" class="block text-sm font-medium text-gray-700 mb-2">
              Tahun Lulus <span class="text-red-500">*</span>
            </label>
            <div class="relative">
              <input type="number" id="tahun_lulus" name="tahun_lulus" min="1900" max="2099"
                value="{{ old('tahun_lulus') }}" required
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                placeholder="Contoh: 2023">
              <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
              </div>
            </div>
            @error('tahun_lulus')
              <p class="text-red-500 text-sm mt-1 flex items-center">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                {{ $message }}
              </p>
            @enderror
          </div>

          <div class="form-group" data-required="true">
            <label for="npm" class="block text-sm font-medium text-gray-700 mb-2">
              NPM <span class="text-red-500">*</span>
            </label>
            <input type="text" id="npm" name="npm" value="{{ old('npm') }}" required
              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
              placeholder="Contoh: 062022199999">
            @error('npm')
              <p class="text-red-500 text-sm mt-1 flex items-center">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                {{ $message }}
              </p>
            @enderror
          </div>
        </div>

        <!-- Row 2: Nama & NIK -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div class="form-group" data-required="true">
            <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">
              Nama Lengkap <span class="text-red-500">*</span>
            </label>
            <input type="text" id="nama" name="nama" value="{{ old('nama') }}" required
              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
              placeholder="Masukkan nama lengkap Anda">
            @error('nama')
              <p class="text-red-500 text-sm mt-1 flex items-center">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                {{ $message }}
              </p>
            @enderror
          </div>

          <div class="form-group" data-required="true">
            <label for="nik" class="block text-sm font-medium text-gray-700 mb-2">
              NIK <span class="text-red-500">*</span>
            </label>
            <input type="text" pattern="\d{16}" id="nik" name="nik" value="{{ old('nik') }}" required
              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
              placeholder="16 digit NIK">
            <p class="text-xs text-gray-500 mt-1">Masukkan 16 digit NIK sesuai KTP</p>
            @error('nik')
              <p class="text-red-500 text-sm mt-1 flex items-center">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                {{ $message }}
              </p>
            @enderror
          </div>
        </div>

        <!-- Row 3: Tanggal Lahir & Email -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div class="form-group" data-required="true">
            <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700 mb-2">
              Tanggal Lahir <span class="text-red-500">*</span>
            </label>
            <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required
              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200">
            @error('tanggal_lahir')
              <p class="text-red-500 text-sm mt-1 flex items-center">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                {{ $message }}
              </p>
            @enderror
          </div>

          <div class="form-group" data-required="true">
            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
              Email <span class="text-red-500">*</span>
            </label>
            <div class="relative">
              <input type="email" id="email" name="email" value="{{ old('email') }}" required
                class="w-full px-4 py-3 pl-11 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                placeholder="contoh@email.com">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                </svg>
              </div>
            </div>
            @error('email')
              <p class="text-red-500 text-sm mt-1 flex items-center">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                {{ $message }}
              </p>
            @enderror
          </div>
        </div>

        <!-- Row 4: Telepon & NPWP -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div class="form-group" data-required="true">
            <label for="nomor_telepon" class="block text-sm font-medium text-gray-700 mb-2">
              Nomor Telepon <span class="text-red-500">*</span>
            </label>
            <div class="relative">
              <input type="text" id="nomor_telepon" name="telepon" value="{{ old('telepon') }}" required
                class="w-full px-4 py-3 pl-11 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                placeholder="08123456789">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                </svg>
              </div>
            </div>
            @error('telepon')
              <p class="text-red-500 text-sm mt-1 flex items-center">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                {{ $message }}
              </p>
            @enderror
          </div>

          <div class="form-group">
            <label for="npwp" class="block text-sm font-medium text-gray-700 mb-2">
              NPWP <span class="text-gray-400">(Opsional)</span>
            </label>
            <input type="text" id="npwp" name="npwp" value="{{ old('npwp') }}"
              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
              placeholder="Nomor NPWP (jika ada)">
            @error('npwp')
              <p class="text-red-500 text-sm mt-1 flex items-center">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                {{ $message }}
              </p>
            @enderror
          </div>
        </div>
      </div>
    </div>

    <!-- Academic Information Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
      <!-- Card Header -->
      <div class="bg-gradient-to-r from-indigo-600 to-purple-600 p-5">
        <div class="flex items-center space-x-3">
          <div class="bg-white bg-opacity-20 p-2 rounded-lg">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
            </svg>
          </div>
          <h2 class="text-lg font-semibold text-white">Informasi Akademik</h2>
        </div>
      </div>

      <!-- Card Body -->
      <div class="p-6 space-y-6">
        <!-- Dosen Pembimbing -->
        <div class="form-group" data-required="true">
          <label for="nama_dosen_pembimbing" class="block text-sm font-medium text-gray-700 mb-2">
            Dosen Pembimbing <span class="text-red-500">*</span>
          </label>
          <input type="text" id="nama_dosen_pembimbing" name="dosen_pembimbing" value="{{ old('dosen_pembimbing') }}" required
            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
            placeholder="Nama dosen pembimbing skripsi/tugas akhir">
          @error('dosen_pembimbing')
            <p class="text-red-500 text-sm mt-1 flex items-center">
              <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
              </svg>
              {{ $message }}
            </p>
          @enderror
        </div>

        <!-- Sumber Pembiayaan -->
        <div class="form-group" data-required="true">
          <label class="block text-sm font-medium text-gray-700 mb-4">
            Sumber Pembiayaan Kuliah <span class="text-red-500">*</span>
          </label>
          <div class="bg-gray-50 p-4 rounded-lg">
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
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
              @foreach ($options as $index => $item)
                <div class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-white transition-colors duration-200">
                  <input type="radio" name="pembiayaan" id="pembiayaan_{{ $index }}" value="{{ $item }}"
                    {{ $pembiayaan === $item ? 'checked' : '' }} required
                    class="w-4 h-4 text-indigo-600 focus:ring-indigo-500 border-gray-300">
                  <label for="pembiayaan_{{ $index }}" class="ml-3 text-sm text-gray-700 cursor-pointer">{{ $item }}</label>
                </div>
              @endforeach
            </div>

            <div id="input_lainnya_container" class="mt-4 {{ $pembiayaan === 'Yang lain' ? '' : 'hidden' }}">
              <label for="pembiayaan_lainnya" class="block text-sm font-medium text-gray-700 mb-2">Tuliskan sumber lainnya:</label>
              <input type="text" name="pembiayaan_lainnya" id="pembiayaan_lainnya"
                value="{{ old('pembiayaan_lainnya') }}"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                placeholder="Sebutkan sumber pembiayaan lainnya">
            </div>
          </div>
          @error('pembiayaan')
            <p class="text-red-500 text-sm mt-1 flex items-center">
              <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
              </svg>
              {{ $message }}
            </p>
          @enderror
        </div>

        <!-- Status Saat Ini -->
        <div class="form-group" data-required="true">
          <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
            Status Saat Ini <span class="text-red-500">*</span>
          </label>
          <div class="relative">
            <select id="status" name="status" required
              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 text-base appearance-none bg-white">
              <option value="" disabled selected>Pilih status saat ini</option>
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
            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
              <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
              </svg>
            </div>
          </div>
          @error('status')
            <p class="text-red-500 text-sm mt-1 flex items-center">
              <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
              </svg>
              {{ $message }}
            </p>
          @enderror
        </div>
      </div>
    </div>
  </div>
</div>

<script>
// Handle other option selection for pembiayaan
document.addEventListener('DOMContentLoaded', function() {
  const radioOptions = document.querySelectorAll('input[name="pembiayaan"]');
  const otherInputContainer = document.getElementById('input_lainnya_container');
  
  radioOptions.forEach(radio => {
    radio.addEventListener('change', function() {
      if (this.value === 'Yang lain') {
        otherInputContainer.classList.remove('hidden');
        document.getElementById('pembiayaan_lainnya').required = true;
      } else {
        otherInputContainer.classList.add('hidden');
        document.getElementById('pembiayaan_lainnya').required = false;
      }
    });
  });
});
</script>