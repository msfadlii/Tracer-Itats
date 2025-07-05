<div
    class="relative flex flex-col justify-between h-full w-full p-4 bg-gradient-to-b from-blue-600 via-blue-600 to-blue-600 text-white shadow-xl">
    <!-- Toggle Button -->
    <div class="absolute top-1/2 -right-4 transform -translate-y-1/2 z-20">
        <button @click="sidebarCollapsed = !sidebarCollapsed"
            class="bg-blue-900 hover:bg-blue-900 text-white w-8 h-8 rounded-full shadow-lg flex items-center justify-center transition-all border-4 border-white">
            <i class="fas" :class="sidebarCollapsed ? 'fa-chevron-right' : 'fa-chevron-left'"></i>
        </button>
    </div>

    <!-- Header -->
    <div class="flex justify-center mb-6">
        <template x-if="sidebarCollapsed">
            <div
                class="flex items-center justify-center w-10 h-10 bg-white text-blue-900 font-bold text-sm rounded-full shadow-md">
                TI
            </div>
        </template>
        <template x-if="!sidebarCollapsed">
            <span class="text-xl font-bold tracking-wide text-center transition-all">Tracer Informatika</span>
        </template>
    </div>


    <!-- Divider -->
    <div class="h-px bg-white/30 mb-4"></div>

    <!-- Menu -->
    <nav class="flex-1 space-y-2 text-sm font-medium">

        <!-- GRUP: UTAMA -->
        <div class="text-xs text-white/70 uppercase tracking-wide mb-1 px-3" x-show="!sidebarCollapsed">Utama</div>

        <a href="{{ route('dashboard') }}"
            class="relative group flex p-3 rounded-md hover:bg-blue-400/20 transition-all items-center"
            :class="sidebarCollapsed ? 'justify-center pr-0 pl-2' : 'gap-3 justify-start'">
            <i class="fas fa-tachometer-alt w-5 h-3 text-white"></i>
            <span x-show="!sidebarCollapsed" x-transition>Dashboard</span>
        </a>

        <!-- GRUP: KUESIONER -->
        <div class="h-px bg-white/30 mb-4"></div><br>
        <div class="text-xs text-white/70 uppercase tracking-wide mt-4 mb-1 px-3" x-show="!sidebarCollapsed">Kuesioner
        </div>

        <a href="{{ route('admin.page_kuesioners.index') }}"
            class="relative group flex p-3 rounded-md hover:bg-blue-400/20 transition-all items-center"
            :class="sidebarCollapsed ? 'justify-center pr-0 pl-2' : 'gap-3 justify-start'">
            <i class="fas fa-question-circle w-5 h-3 text-white"></i>
            <span x-show="!sidebarCollapsed" x-transition>Halaman Kuesioner</span>
        </a>

        <a href="{{ route('admin.questions.index') }}"
            class="relative group flex p-3 rounded-md hover:bg-blue-400/20 transition-all items-center"
            :class="sidebarCollapsed ? 'justify-center pr-0 pl-2' : 'gap-3 justify-start'">
            <i class="fas fa-question-circle w-5 h-3 text-white"></i>
            <span x-show="!sidebarCollapsed" x-transition>Pertanyaan</span>
        </a>

        <a href="{{ route('admin.alumni-answers.index') }}"
            class="relative group flex p-3 rounded-md hover:bg-blue-400/20 transition-all items-center"
            :class="sidebarCollapsed ? 'justify-center pr-0 pl-2' : 'gap-3 justify-start'">
            <i class="fas fa-clipboard-list w-5 h-3 text-white"></i>
            <span x-show="!sidebarCollapsed" x-transition>Jawaban Alumni</span>
        </a>

        <a href="{{ route('FormAlumni') }}"
            class="relative group flex p-3 rounded-md hover:bg-blue-400/20 transition-all items-center"
            :class="sidebarCollapsed ? 'justify-center pr-0 pl-2' : 'gap-3 justify-start'">
            <i class="fas fa-pen-square w-5 h-3 text-white"></i>
            <span x-show="!sidebarCollapsed" x-transition>Form Pengisian</span>
        </a>

        <!-- GRUP: ANALISIS -->
        <div class="h-px bg-white/30 mb-4"></div><br>
        <div class="text-xs text-white/70 uppercase tracking-wide mt-4 mb-1 px-3" x-show="!sidebarCollapsed">Analisis
        </div>

        <a href="{{ route('admin.reports.showReport') }}"
            class="relative group flex p-3 rounded-md hover:bg-blue-400/20 transition-all items-center"
            :class="sidebarCollapsed ? 'justify-center pr-0 pl-2' : 'gap-3 justify-start'">
            <i class="fas fa-chart-bar w-5 h-3 text-white"></i>
            <span x-show="!sidebarCollapsed" x-transition>Statistik & Laporan</span>
        </a>

        <!-- GRUP: PENGATURAN -->
        <div class="h-px bg-white/30 mb-4"></div><br>
        <div class="text-xs text-white/70 uppercase tracking-wide mt-4 mb-1 px-3" x-show="!sidebarCollapsed">Pengaturan
        </div>

        <a href="{{ route('profile.edit') }}"
            class="relative group flex p-3 rounded-md hover:bg-blue-400/20 transition-all items-center"
            :class="sidebarCollapsed ? 'justify-center pr-0 pl-2' : 'gap-3 justify-start'">
            <i class="fas fa-user-circle w-5 h-3 text-white"></i>
            <span x-show="!sidebarCollapsed" x-transition>Profil</span>
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="relative group flex w-full p-3 rounded-md text-red-500 hover:bg-red-500/10 hover:text-red-600 transition-all items-center"
                :class="sidebarCollapsed ? 'justify-center pr-0 pl-2' : 'gap-3 justify-start'">
                <i class="fas fa-sign-out-alt w-5 h-3 group-hover:text-red-600 transition"></i>
                <span x-show="!sidebarCollapsed" x-transition>Logout</span>
            </button>
        </form>

        <div class="h-px bg-white/30 mb-4"></div>
    </nav>
</div>