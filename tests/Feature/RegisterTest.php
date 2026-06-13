<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_with_valid_data(): void
    {
        $response = $this->post('/register', [
            'name' => 'Nguyen Van A',
            'email' => 'nguyenvana@example.com',
            'password' => 'Test@1234',
            'password_confirmation' => 'Test@1234',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertDatabaseHas('users', ['email' => 'nguyenvana@example.com']); // TC-RQ01-01
    }

    public function test_register_with_invalid_email_format(): void
    {
        $response = $this->post('/register', [
            'name' => 'Nguyen Van A',
            'email' => 'tangmail.com',
            'password' => 'Test@1234',
            'password_confirmation' => 'Test@1234',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertDatabaseMissing('users', ['email' => 'tangmail.com']); // TC-RQ01-02
    }

    public function test_register_with_duplicate_email(): void
    {
        User::factory()->create(['email' => 'existed@gmail.com']);

        $response = $this->post('/register', [
            'name' => 'Nguyen Van A',
            'email' => 'existed@gmail.com',
            'password' => 'Test@1234',
            'password_confirmation' => 'Test@1234',
        ]);

        $response->assertSessionHasErrors('email'); // TC-RQ01-03
    }

    public function test_register_password_below_minimum(): void
    {
        $response = $this->post('/register', [
            'name' => 'Nguyen Van A',
            'email' => 'short-password@example.com',
            'password' => 'Ab1@23',
            'password_confirmation' => 'Ab1@23',
        ]);

        $response->assertSessionHasErrors('password'); // TC-RQ01-04
    }

    public function test_register_password_confirmation_mismatch(): void
    {
        $response = $this->post('/register', [
            'name' => 'Nguyen Van A',
            'email' => 'mismatch@example.com',
            'password' => 'Test@1234',
            'password_confirmation' => 'Different@1234',
        ]);

        $response->assertSessionHasErrors('password'); // TC-RQ01-05
    }
}
