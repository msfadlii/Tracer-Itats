
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome untuk ikon bell -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-XxX..." crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Alpine.js untuk dropdown -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100 text-gray-800">

    <!-- Header/Navbar -->
    <header id="navbar" class="fixed top-0 left-0 right-0 z-30 bg-white border-b border-gray-200 shadow-sm h-14 flex items-center px-4 lg:pl-64 transition-all duration-300">
        <div class="flex justify-between items-center w-full">

            <!-- Right Items -->
            <div class="flex items-center space-x-4 ml-auto">

               

                <!-- Pemisah -->
                <div class="h-6 w-px bg-gray-300"></div>

                <!-- Profil -->
                <a href="{{ route('profile.edit') }}" class="flex items-center space-x-2 focus:outline-none">
                    <span class="text-sm font-medium text-gray-800">{{ Auth::user()->name }}</span>
                    <div class="w-8 h-8 rounded-full bg-[#3b82f6] text-white flex items-center justify-center font-bold">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                </a>

            </div>
        </div>
    </header>

    <!-- Spacer agar konten tidak tertutup navbar -->
    <div class="h-14"></div>
    
</body>
</html>
