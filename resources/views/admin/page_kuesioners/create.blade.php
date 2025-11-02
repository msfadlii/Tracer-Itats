{{-- resources/views/admin/page_kuesioners/create.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="mb-6 flex items-start gap-4 animate-fade-in">
            <div class="border-l-4 border-green-600 pl-4">
                <h2 class="text-3xl font-bold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-plus-circle text-green-600"></i>
                    Tambah Halaman Baru
                </h2>
                <p class="text-sm text-gray-600 mt-1">
                    Buat halaman baru untuk kuesioner sistem.
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen text-gray-800">
        <div class="max-w-4xl mx-auto px-4">
            <div class="bg-white shadow rounded-xl p-6">

                {{-- Back Button --}}
                <div class="mb-6">
                    <a href="{{ route('admin.page_kuesioners.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition shadow-md">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali ke Daftar Halaman
                    </a>
                </div>

                {{-- Kuesioner Info --}}
                <div class="mb-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
                    <h3 class="text-lg font-semibold text-blue-800 mb-2">
                        <i class="fas fa-info-circle mr-2"></i>
                        Informasi halaman Kuesioner
                    </h3>
                    <p class="text-sm text-blue-700 mb-3">
                        Halaman yang Anda buat akan berisi pertanyaan-pertanyaan yang dapat dikonfigurasi untuk tampil
                        berdasarkan status kerja alumni.
                    </p>
                    <div class="bg-blue-100 p-3 rounded-md">
                        <p class="text-xs text-blue-600">
                            <i class="fas fa-eye mr-1"></i>
                            <strong>Kondisi Tampil:</strong> Saat membuat pertanyaan di halaman ini, Anda dapat mengatur
                            agar pertanyaan hanya muncul untuk alumni dengan status kerja tertentu (Bekerja, Wiraswasta,
                            Melanjutkan Pendidikan, dll.).
                        </p>
                    </div>
                </div>

                {{-- Form --}}
                <form action="{{ route('admin.page_kuesioners.store') }}" method="POST">
                    @csrf

                    <div class="space-y-6">
                        {{-- Judul Halaman --}}
                        <div>
                            <label for="judul" class="block text-sm font-medium text-gray-700 mb-2">
                                Judul Halaman <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="judul" id="judul" value="{{ old('judul') }}" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                placeholder="Masukkan judul halaman...">
                            @error('judul')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Deskripsi --}}
                        <div>
                            <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">
                                Deskripsi Halaman
                            </label>
                            <textarea name="deskripsi" id="deskripsi" rows="4"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                placeholder="Masukkan deskripsi halaman (opsional)...">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Urutan --}}
                        <div>
                            <label for="urutan" class="block text-sm font-medium text-gray-700 mb-2">
                                Urutan Halaman <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="urutan" id="urutan" value="{{ old('urutan', 1) }}" required
                                min="1"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            @error('urutan')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">
                                <i class="fas fa-info-circle mr-1"></i>
                                Tentukan urutan tampilan halaman dalam kuesioner
                            </p>
                        </div>
                    </div>

                    {{-- Submit Buttons --}}
                    <div class="flex justify-end space-x-3 mt-8 pt-6 border-t border-gray-200">
                        <a href="{{ route('admin.page_kuesioners.index') }}"
                            class="px-6 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition shadow-md">
                            Batal
                        </a>
                        <button type="submit"
                            class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition shadow-md">
                            <i class="fas fa-save mr-2"></i>
                            Simpan Halaman
                        </button>
                    </div>
                </form>

                {{-- Help Section --}}
                <div class="mt-8 p-4 bg-gray-50 rounded-lg border">
                    <h4 class="text-sm font-medium text-gray-800 mb-2">
                        <i class="fas fa-lightbulb text-yellow-500 mr-2"></i>
                        Tips Membuat Halaman Kuesioner
                    </h4>
                    <ul class="text-sm text-gray-600 space-y-1">
                        <li>• Gunakan judul yang jelas dan deskriptif</li>
                        <li>• Atur urutan halaman sesuai dengan alur kuesioner</li>
                        <li>• Deskripsi membantu responden memahami tujuan halaman</li>
                        <li>• Setelah membuat halaman, Anda dapat menambahkan pertanyaan</li>
                    </ul>
                </div>

                {{-- Status Condition Info --}}
                <div class="mt-6 p-4 bg-indigo-50 rounded-lg border border-indigo-200">
                    <h4 class="text-sm font-medium text-indigo-800 mb-2">
                        <i class="fas fa-filter text-indigo-600 mr-2"></i>
                        Kondisi Tampil Berdasarkan Status Kerja
                    </h4>
                    <div class="text-sm text-indigo-700 space-y-2">
                        <p>
                            <strong>Halaman ini akan menampilkan pertanyaan berdasarkan status kerja alumni:</strong>
                        </p>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mt-3">
                            <div class="flex items-center text-xs">
                                <i class="fas fa-briefcase text-green-600 mr-2"></i>
                                <span>Bekerja (full time/part time)</span>
                            </div>
                            <div class="flex items-center text-xs">
                                <i class="fas fa-store text-blue-600 mr-2"></i>
                                <span>Wiraswasta</span>
                            </div>
                            <div class="flex items-center text-xs">
                                <i class="fas fa-graduation-cap text-purple-600 mr-2"></i>
                                <span>Melanjutkan Pendidikan</span>
                            </div>
                            <div class="flex items-center text-xs">
                                <i class="fas fa-search text-orange-600 mr-2"></i>
                                <span>Sedang Mencari Kerja</span>
                            </div>
                            <div class="flex items-center text-xs">
                                <i class="fas fa-clock text-gray-600 mr-2"></i>
                                <span>Belum Memungkinkan Bekerja</span>
                            </div>
                        </div>
                        <div class="mt-3 p-3 bg-indigo-100 rounded-md">
                            <p class="text-xs text-indigo-600">
                                <i class="fas fa-info-circle mr-1"></i>
                                <strong>Catatan:</strong> Setiap pertanyaan dalam halaman ini dapat dikonfigurasi untuk
                                tampil pada status kerja tertentu saat Anda membuat pertanyaan baru. Jika tidak ada
                                kondisi yang dipilih, pertanyaan akan tampil untuk semua status.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>