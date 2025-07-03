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
                        Informasi Kuesioner
                    </h3>
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
            </div>
        </div>
    </div>
</x-app-layout>