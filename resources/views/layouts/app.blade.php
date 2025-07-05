
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      x-data="{ sidebarOpen: false, sidebarCollapsed: false }"
      class="h-full">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        rel="stylesheet"
        integrity="sha512-Avb2QiuDEEvB4bZJYdft2mNjVShBftLdPG8FJ0V7irTLQ8Uo0qcPxh4Plq7G5tGm0rU+1SPhVotteLpBERwTkw=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer"
        />


    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-white text-gray-900">
    <div class="min-h-screen flex relative">

        <!-- Navbar (Include this part to call the navigation) -->
        @include('layouts.navigation')  <!-- Menambahkan Navbar dari resources/views/layouts/navigation.blade.php -->

        <!-- Sidebar Desktop -->
        <aside
            :class="sidebarCollapsed ? 'w-20' : 'w-64'"
            class="fixed inset-y-0 left-0 z-40 hidden lg:flex flex-col transition-all duration-300 bg-white border-r border-gray-200">
            @include('components.admin-sidebar')
        </aside>

        <!-- Sidebar Mobile Fixed Bottom -->
        @include('components.admin-sidebar-mobile')

        <!-- Main Content -->
        <div :class="sidebarCollapsed ? 'lg:pl-20' : 'lg:pl-64'" class="flex-1 flex flex-col transition-all duration-300 pt-14">

            <main class="flex-1 p-6">
                @isset($header)
                    <div class="mb-6">
                        <h1 class="text-2xl font-bold text-gray-900">{{ $header }}</h1>
                    </div>
                @endisset

                @if (session('success'))
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                {{ $slot }}
            </main>

            <!-- Footer -->
            <footer class="bg-white border-t border-gray-200 text-sm text-center py-4 text-gray-500">
                &copy; {{ date('Y') }} Tracer Alumni ITATS. Aplikasi ini dikembangkan oleh Mahasiswa Kerja Praktik Teknik Informatika ITATS.
            </footer>

        </div>
    </div>

    {{-- Memanggil file JS --}}
    @stack('scripts')
</body>

</html>
