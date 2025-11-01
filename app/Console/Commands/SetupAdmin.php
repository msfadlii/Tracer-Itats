<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SetupAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:setup {--force : Force create admin even if exists}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup default admin user from environment variables';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $adminEmail = env('ADMIN_EMAIL', 'admin@itats.ac.id');
        $adminName = env('ADMIN_NAME', 'Admin_ITATS');
        $adminPassword = env('ADMIN_PASSWORD', 'admin');

        // Cek apakah admin sudah ada
        $existingAdmin = \App\Models\User::where('email', $adminEmail)->first();
        
        if ($existingAdmin && !$this->option('force')) {
            $this->warn("Admin user already exists: {$adminEmail}");
            $this->info("Use --force to update existing admin");
            return 0;
        }

        try {
            if ($existingAdmin && $this->option('force')) {
                // Update existing admin
                $existingAdmin->update([
                    'name' => $adminName,
                    'password' => \Illuminate\Support\Facades\Hash::make($adminPassword),
                ]);
                $this->info("✅ Admin user updated: {$adminEmail}");
            } else {
                // Create new admin
                \App\Models\User::create([
                    'name' => $adminName,
                    'email' => $adminEmail,
                    'password' => \Illuminate\Support\Facades\Hash::make($adminPassword),
                ]);
                $this->info("✅ Admin user created: {$adminEmail}");
            }

            $this->table(
                ['Field', 'Value'],
                [
                    ['Name', $adminName],
                    ['Email', $adminEmail],
                    ['Password', str_repeat('*', strlen($adminPassword))],
                ]
            );

            return 0;
        } catch (\Exception $e) {
            $this->error("❌ Failed to setup admin: " . $e->getMessage());
            return 1;
        }
    }
}
