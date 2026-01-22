<?php
use App\Http\Controllers\Admin\HalamanKuesionerController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\AlumniFormController;
use App\Http\Controllers\Admin\AnswerController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\AlumniController;
use App\Http\Controllers\AnalyticsController;
use Illuminate\Support\Facades\Route;

// 🔁 Redirect halaman utama ke register
Route::get('/', fn () => redirect()->route('login'));
// ✅ Redirect setelah login ke dashboard admin
Route::get('/dashboard', fn () => redirect()->route('admin.dashboard'))
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/alumni/export', [AlumniController::class, 'export'])->name('alumni.export');
Route::get('/analytics/summary', [AnalyticsController::class, 'summary']);

//Admin route group
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    //Dashboard Admin
    Route::get('/dashboard', [DashboardController::class, 'showdashboard'])->name('dashboard');

    //CRUD Pertanyaan
    Route::resource('questions', QuestionController::class);

    // CRUD Halaman Kuesioner
    Route::resource('page_kuesioners', HalamanKuesionerController::class);

    // awaban Alumni - daftar & hapus
    Route::get('alumni-answers', [AnswerController::class, 'showAnswers'])->name('alumni-answers.index');
    Route::delete('alumni-answers/{idPengisian}', [AnswerController::class, 'destroyBySubmission'])->name('alumni_answers.destroy');
  
    // Sudah di dalam prefix('admin') dan name('admin.')
    Route::get('alumni_answers/detail/{id}', [AnswerController::class, 'detailJawaban'])->name('alumni_answers.detail');

    // Statistik & Laporan
    Route::get('reports', [ReportController::class, 'showReport'])->name('reports.showReport');
});

// Menampilkan form awal
Route::get('/alumni/form', [AlumniFormController::class, 'showForm'])->name('FormAlumni');

// Submit formulir
Route::post('/alumni/form', [AlumniFormController::class, 'storeForm'])->name('alumni.form.submit');

Route::get('/formulir/sukses', function () {
    return view('alumni.success'); 
})->name('alumni.form.success');

Route::fallback(function () {
    abort(404, 'Halaman tidak ditemukan');
});

require __DIR__.'/auth.php';
