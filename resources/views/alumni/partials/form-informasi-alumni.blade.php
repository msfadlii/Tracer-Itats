<div class="space-y-8">
  <!-- Bagian Header -->
  <div class="text-center">
    <h1 class="text-2xl font-bold text-gray-900 mb-2">Informasi Alumni</h1>
    <p class="text-gray-600">Lengkapi data diri Anda untuk memulai tracer study</p>
  </div>

  <!-- Konten Formulir -->
  <div class="space-y-6">
  <!-- Kartu Informasi Pribadi -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
  <!-- Header Kartu -->
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

  <!-- Isi Kartu -->
      <div class="p-6 space-y-6">
  <!-- Baris 1: Tahun Lulus & NPM -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div class="form-group" data-required="true">
            <label for="tahun_lulus" class="block text-sm font-medium text-gray-700 mb-2">
              Tahun Lulus <span class="text-red-500">*</span>
            </label>
            <div class="relative">
              <input type="number" id="tahun_lulus" name="tahun_lulus" 
                min="1980" max="{{ date('Y') + 1 }}"
                value="{{ old('tahun_lulus') }}" required
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                placeholder="Contoh: 2023"
                oninput="validateTahunLulus(this)">
              <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
              </div>
            </div>
            <p class="text-xs text-gray-500 mt-1">Tahun lulus minimal 1980, maksimal {{ date('Y') + 1 }}</p>
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
              maxlength="12" pattern="\d{12}"
              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
              placeholder="Contoh: 062022199999"
              oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 12); validateNPM(this)"
              title="NPM harus 12 digit angka">
            <p class="text-xs text-gray-500 mt-1">Masukkan 12 digit NPM (hanya angka)</p>
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

  <!-- Baris 2: Nama & NIK -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div class="form-group" data-required="true">
            <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">
              Nama Lengkap <span class="text-red-500">*</span>
            </label>
            <input type="text" id="nama" name="nama" value="{{ old('nama') }}" required
              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
              placeholder="Masukkan nama lengkap Anda"
              oninput="this.value = this.value.replace(/[^a-zA-Z\s\.]/g, ''); validateNama(this)"
              title="Nama hanya boleh berisi huruf, spasi, dan titik">
            <p class="text-xs text-gray-500 mt-1">Hanya huruf, spasi, dan titik yang diperbolehkan</p>
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
            <input type="text" pattern="\d{16}" maxlength="16" id="nik" name="nik" value="{{ old('nik') }}" required
              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
              placeholder="16 digit NIK (hanya angka)"
              oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 16)"
              title="NIK harus 16 digit angka">
            <p class="text-xs text-gray-500 mt-1">Masukkan 16 digit NIK sesuai KTP (hanya angka)</p>
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

  <!-- Baris 3: Tanggal Lahir & Email -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div class="form-group" data-required="true">
            <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700 mb-2">
              Tanggal Lahir <span class="text-red-500">*</span>
            </label>
            <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required
              min="1950-01-01" max="{{ date('Y-m-d') }}"
              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
              onchange="validateTanggalLahir(this)">
            <p class="text-xs text-gray-500 mt-1">Tanggal lahir minimal tahun 1950, tidak boleh di masa depan</p>
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

  <!-- Baris 4: Telepon & NPWP -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div class="form-group" data-required="true">
            <label for="nomor_telepon" class="block text-sm font-medium text-gray-700 mb-2">
              Nomor Telepon <span class="text-red-500">*</span>
            </label>
            <div class="relative">
              <input type="text" id="nomor_telepon" name="telepon" value="{{ old('telepon') }}" required
                class="w-full px-4 py-3 pl-11 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                placeholder="08123456789"
                maxlength="13"
                pattern="(\+62|62|0)[0-9]{9,13}"
                oninput="formatTelepon(this)"
                title="Format nomor Indonesia: 08xx, 62xx, atau +62xx (maksimal 13 digit)">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                </svg>
              </div>
            </div>
            <p class="text-xs text-gray-500 mt-1">Format Indonesia: 08xx, 62xx, atau +62xx (9-13 digit)</p>
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
              maxlength="20" pattern="\d{2}\.\d{3}\.\d{3}\.\d{1}-\d{3}\.\d{3}"
              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
              placeholder="01.234.567.8-901.234"
              oninput="formatNPWPSmart(this)"
              title="Format NPWP: XX.XXX.XXX.X-XXX.XXX">
            <p class="text-xs text-gray-500 mt-1">Format: XX.XXX.XXX.X-XXX.XXX (contoh: 01.234.567.8-901.234)</p>
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

  <!-- Kartu Informasi Akademik -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
  <!-- Header Kartu -->
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

  <!-- Isi Kartu -->
      <div class="p-6 space-y-6">
        <!-- Dosen Pembimbing -->
        <div class="form-group" data-required="true">
          <label for="nama_dosen_pembimbing" class="block text-sm font-medium text-gray-700 mb-2">
            Dosen Pembimbing <span class="text-red-500">*</span>
          </label>
          <input type="text" id="nama_dosen_pembimbing" name="dosen_pembimbing" value="{{ old('dosen_pembimbing') }}" required
            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
            placeholder="Nama dosen pembimbing skripsi/tugas akhir"
            oninput="this.value = this.value.replace(/[^a-zA-Z\s\.,]/g, ''); validateDosenPembimbing(this)"
            title="Nama dosen hanya boleh berisi huruf, spasi, titik, dan koma">
          <p class="text-xs text-gray-500 mt-1">Hanya huruf, spasi, titik, dan koma yang diperbolehkan</p>
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
// Tangani pilihan 'Yang lain' pada pembiayaan
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

// ===== FUNGSI VALIDASI =====

// 1. Validasi Tahun Lulus
function validateTahunLulus(input) {
  const currentYear = new Date().getFullYear();
  const value = parseInt(input.value);
  const minYear = 1980;
  const maxYear = currentYear + 1;
  
  // Clear previous custom validation
  input.setCustomValidity('');
  
  if (value && (value < minYear || value > maxYear)) {
    input.setCustomValidity(`Tahun lulus harus antara ${minYear} - ${maxYear}`);
    input.style.borderColor = '#ef4444';
  } else {
    input.style.borderColor = '#10b981';
  }
}

// 2. Validasi NPM
function validateNPM(input) {
  input.setCustomValidity('');
  
  if (input.value.length !== 12) {
    input.setCustomValidity('NPM harus tepat 12 digit');
    input.style.borderColor = '#ef4444';
  } else {
    input.style.borderColor = '#10b981';
  }
}

// 3. Validasi Nama
function validateNama(input) {
  const pattern = /^[a-zA-Z\s\.]+$/;
  input.setCustomValidity('');
  
  if (input.value && !pattern.test(input.value)) {
    input.setCustomValidity('Nama hanya boleh berisi huruf, spasi, dan titik');
    input.style.borderColor = '#ef4444';
  } else if (input.value.length > 0) {
    input.style.borderColor = '#10b981';
  } else {
    input.style.borderColor = '';
  }
}

// 4. Validasi Tanggal Lahir
function validateTanggalLahir(input) {
  const selectedDate = new Date(input.value);
  const today = new Date();
  const minDate = new Date('1950-01-01');
  
  input.setCustomValidity('');
  
  if (selectedDate > today) {
    input.setCustomValidity('Tanggal lahir tidak boleh di masa depan');
    input.style.borderColor = '#ef4444';
  } else if (selectedDate < minDate) {
    input.setCustomValidity('Tanggal lahir minimal tahun 1950');
    input.style.borderColor = '#ef4444';
  } else {
    input.style.borderColor = '#10b981';
  }
}

// 5. Format & Validasi Telepon
function formatTelepon(input) {
  let value = input.value.replace(/[^\d\+]/g, '');
  if (value.includes('+') && !value.startsWith('+')) {
    value = value.replace(/\+/g, '');
  }
  if (value.length > 13) {
    value = value.substring(0, 13);
  }
  
  input.value = value;
  
  // Validate Indonesian phone number pattern
  const pattern = /^(\+62|62|0)[0-9]{9,13}$/;
  input.setCustomValidity('');
  
  if (value && !pattern.test(value)) {
    input.setCustomValidity('Format nomor Indonesia: 08xx, 62xx, atau +62xx (maksimal 13 digit)');
    input.style.borderColor = '#ef4444';
  } else if (value.length > 0) {
    input.style.borderColor = '#10b981';
  } else {
    input.style.borderColor = '';
  }
}

// 6. Format & Validasi NPWP
function formatNPWPSmart(input) {
  const cursorPosition = input.selectionStart;
  let value = input.value;
  
  // Hapus semua karakter non-numerik untuk mendapatkan digit bersih
  const cleanValue = value.replace(/[^\d]/g, '');
  if (cleanValue.length > 15) {
    const limitedClean = cleanValue.substring(0, 15);
    const formatted = formatNPWPDigits(limitedClean);
    input.value = formatted;
    return;
  }
  
  const formatted = formatNPWPDigits(cleanValue);
  
  // Hitung posisi kursor baru
  let newCursorPos = cursorPosition;
  
  // Jika kita menambahkan karakter (pemisah), sesuaikan posisi kursor
  const addedChars = formatted.length - value.length;
  if (addedChars > 0) {
    newCursorPos += addedChars;
  }
  input.value = formatted;
  setTimeout(() => {
    input.setSelectionRange(newCursorPos, newCursorPos);
  }, 0);
  
  // Validasi pola NPWP (field opsional)
  validateNPWPField(input, cleanValue, formatted);
}

// Fungsi pembantu: format digit NPWP ke XX.XXX.XXX.X-XXX.XXX
function formatNPWPDigits(digits) {
  let formatted = '';
  
  for (let i = 0; i < digits.length; i++) {
    if (i === 2 || i === 5 || i === 8) {
      formatted += '.';
    } else if (i === 9) {
      formatted += '-';
    } else if (i === 12) {
      formatted += '.';
    }
    formatted += digits[i];
  }
  
  return formatted;
}
function validateNPWPField(input, cleanValue, formattedValue) {
  if (formattedValue) {
    const pattern = /^\d{2}\.\d{3}\.\d{3}\.\d{1}-\d{3}\.\d{3}$/;
    input.setCustomValidity('');
    
    if (cleanValue.length === 15 && pattern.test(formattedValue)) {
  input.style.borderColor = '#10b981'; 
    } else if (cleanValue.length > 0) {
  input.style.borderColor = '#f59e0b';
    }
    
  // Tampilkan error hanya jika pengguna memasukkan 15 digit lengkap namun format salah
    if (cleanValue.length === 15 && !pattern.test(formattedValue)) {
      input.setCustomValidity('Format NPWP: XX.XXX.XXX.X-XXX.XXX');
      input.style.borderColor = '#ef4444';
    }
  } else {
    input.style.borderColor = '';
    input.setCustomValidity('');
  }
}

// (Dihapus) Fungsi formatNPWP asli diganti oleh formatNPWPSmart.
// Jika Anda ingin menyimpan fungsi cadangan, pertimbangkan memindahkannya ke file helper
// atau beri komentar di repository. Fungsi ini dihapus untuk merapikan kode karena
// tidak pernah dipanggil.

// 7. Validasi Dosen Pembimbing
function validateDosenPembimbing(input) {
  const pattern = /^[a-zA-Z\s\.,]+$/;
  input.setCustomValidity('');
  
  if (input.value && !pattern.test(input.value)) {
    input.setCustomValidity('Nama dosen hanya boleh berisi huruf, spasi, titik, dan koma');
    input.style.borderColor = '#ef4444';
  } else if (input.value.length > 0) {
    input.style.borderColor = '#10b981';
  } else {
    input.style.borderColor = '';
  }
}

// Validasi real-time saat halaman dimuat
document.addEventListener('DOMContentLoaded', function() {
  const requiredInputs = document.querySelectorAll('input[required], select[required]');
  
  requiredInputs.forEach(input => {
    input.addEventListener('blur', function() {
      if (this.value.trim() === '') {
        this.style.borderColor = '#ef4444';
      }
    });
    
    input.addEventListener('focus', function() {
      if (this.style.borderColor === 'rgb(239, 68, 68)') {
        this.style.borderColor = '#6366f1';
      }
    });
  });
  
  // Penanganan field NPWP yang ditingkatkan dengan penghapusan alami
  const npwpField = document.getElementById('npwp');
  if (npwpField) {
    npwpField.addEventListener('input', function(e) {
      formatNPWPSmart(this);
    });
    
  // Tambah event listener untuk paste agar menangani konten yang ditempel
    npwpField.addEventListener('paste', function(e) {
      setTimeout(() => {
        formatNPWPSmart(this);
      }, 10);
    });
    
  // Tambah event focus untuk menampilkan contoh
    npwpField.addEventListener('focus', function() {
      if (this.value === '') {
        this.placeholder = 'Ketik angka: otomatis jadi 01.234.567.8-901.234';
      }
    });
    
  // Kembalikan placeholder asli saat blur
    npwpField.addEventListener('blur', function() {
      this.placeholder = '01.234.567.8-901.234';
    });
  }
});
</script>