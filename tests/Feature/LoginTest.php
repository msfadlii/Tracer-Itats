<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;

class LoginTest extends TestCase
{
    public function test_user_can_login_with_correct_credentials()
    {
        $response = $this->post('/login', [
            'email' => 'admin@itats.ac.id',
            'password' => 'admin',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/dashboard');
    }

    public function test_login_fails_with_wrong_password()
    {
        $response = $this->from('/login')->post('/login', [
            'email' => 'admin@itats.ac.id',
            'password' => 'salahpassword',
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_login_fails_with_password_below_minimum_boundary()
    {
        // Uji password dibawah batas (5 karakter)
        $response = $this->from('/login')->post('/login', [
            'email' => 'admin@itats.ac.id',
            'password' => '1234', // Di bawah batas
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('password');      
    }
}
