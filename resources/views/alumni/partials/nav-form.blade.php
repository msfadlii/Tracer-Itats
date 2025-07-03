{{-- resources/views/alumni/partials/nav-form.blade.php --}}
<nav class="bg-white shadow-sm border-b border-gray-200 rounded-t-lg">
    <div class="px-6 py-4">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="flex-shrink-0">
                    <img class="h-10 w-10" src="{{ asset('images/logo-itats-new.png') }}" alt="ITATS Logo">
                </div>
                <div>
                    <h1 class="text-lg font-semibold text-gray-900">Tracer Study Alumni</h1>
                    <p class="text-sm text-gray-500">Institut Teknologi Adhi Tama Surabaya</p>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <div class="text-right">
                    <p class="text-sm font-medium text-gray-900">{{ $alumni->nama ?? 'Alumni' }}</p>
                    <p class="text-xs text-gray-500">{{ $alumni->npm ?? 'NPM' }}</p>
                </div>
                <div class="h-8 w-8 bg-blue-100 rounded-full flex items-center justify-center">
                    <span class="text-sm font-medium text-blue-600">
                        {{ substr($alumni->nama ?? 'A', 0, 1) }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</nav>