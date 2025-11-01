<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Auto-create admin user saat aplikasi boot
        $this->createDefaultAdmin();
    }

    /**
     * Create default admin user if not exists
     */
    private function createDefaultAdmin(): void
    {
        try {
            // Hanya jalankan jika tabel users sudah ada
            if (\Illuminate\Support\Facades\Schema::hasTable('users')) {
                
                $adminEmail = env('ADMIN_EMAIL', 'admin@itats.ac.id');
                
                // Cek apakah admin sudah ada
                if (!\App\Models\User::where('email', $adminEmail)->exists()) {
                    \App\Models\User::create([
                        'name' => env('ADMIN_NAME', 'Admin_ITATS'),
                        'email' => $adminEmail,
                        'password' => \Illuminate\Support\Facades\Hash::make(
                            env('ADMIN_PASSWORD', 'admin')
                        ),
                    ]);
                    
                    \Illuminate\Support\Facades\Log::info('Default admin user created: ' . $adminEmail);
                }
            }
        } catch (\Exception $e) {
            // Jangan crash aplikasi jika ada error
            \Illuminate\Support\Facades\Log::warning('Failed to create default admin: ' . $e->getMessage());
        }
    }
}
