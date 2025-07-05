<!-- Mobile Collapsed Sidebar -->
<div class="fixed bottom-0 left-0 right-0 z-50 bg-blue-600 text-white flex justify-around items-center py-2 shadow-lg md:hidden">
    
    <a href="{{ route('dashboard') }}" class="flex flex-col items-center text-xs hover:text-blue-300 transition-all">
        <i class="fas fa-tachometer-alt text-lg"></i>
        <span>Dashboard</span>
    </a>

    <a href="{{ route('admin.page_kuesioners.index') }}" class="flex flex-col items-center text-xs hover:text-blue-300 transition-all">
        <i class="fas fa-question-circle text-lg"></i>
        <span>Halaman Kuesioner</span>
    </a>

    <a href="{{ route('admin.questions.index') }}" class="flex flex-col items-center text-xs hover:text-blue-300 transition-all">
        <i class="fas fa-question-circle text-lg"></i>
        <span>Pertanyaan</span>
    </a>

    <a href="{{ route('admin.alumni-answers.index') }}" class="flex flex-col items-center text-xs hover:text-blue-300 transition-all">
        <i class="fas fa-clipboard-list text-lg"></i>
        <span>Jawaban</span>
    </a>

    <a href="{{ route('FormAlumni') }}" class="flex flex-col items-center text-xs hover:text-blue-300 transition-all">
        <i class="fas fa-pen-square text-lg"></i>
        <span>Form</span>
    </a>

    <a href="{{ route('admin.reports.showReport') }}" class="flex flex-col items-center text-xs hover:text-blue-300 transition-all">
        <i class="fas fa-chart-bar text-lg"></i>
        <span>Analisis</span>
    </a>

    <a href="{{ route('profile.edit') }}" class="flex flex-col items-center text-xs hover:text-blue-300 transition-all">
        <i class="fas fa-user-circle text-lg"></i>
        <span>Profil</span>
    </a> 

    <form method="POST" action="{{ route('logout') }}" class="flex flex-col items-center text-xs hover:text-red-400 transition-all">
        @csrf
        <button type="submit" class="flex flex-col items-center text-xs text-red-500 hover:bg-red-500/10 hover:text-red-600">
            <i class="fas fa-sign-out-alt text-lg"></i>
            <span>Logout</span>
        </button>
    </form>

</div>
