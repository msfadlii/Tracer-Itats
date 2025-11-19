<?php

namespace Tests\Feature;

use Tests\TestCase;

class LoginTest extends TestCase
{
    public function tes_login_email_pass_benar()
    {
        $response = $this->post('/login', [
            'email' => 'admin@itats.ac.id',
            'password' => 'admin',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/dashboard');
    }

    public function tes_login_password_salah()
    {
        $response = $this->from('/login')->post('/login', [
            'email' => 'admin@itats.ac.id',
            'password' => 'salahpassword',
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function tes_login_password_dibawah_batas()
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
