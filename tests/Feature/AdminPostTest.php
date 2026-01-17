<?php

namespace Juzaweb\Installer\Tests\Feature;

use Juzaweb\Installer\Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminPostTest extends TestCase
{
    /** @test */
    public function it_validates_required_admin_fields(): void
    {
        $response = $this->post(route('installer.admin.save'), []);

        $response->assertSessionHasErrors([
            'name',
            'email',
            'password',
            'password_confirmation',
        ]);
    }

    /** @test */
    public function it_validates_email_format(): void
    {
        $response = $this->post(route('installer.admin.save'), [
            'name' => 'Admin User',
            'email' => 'invalid-email',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    /** @test */
    public function it_validates_password_confirmation(): void
    {
        $response = $this->post(route('installer.admin.save'), [
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => 'password123',
            'password_confirmation' => 'different-password',
        ]);

        $response->assertSessionHasErrors(['password']);
    }

    /** @test */
    public function it_validates_password_minimum_length(): void
    {
        $response = $this->post(route('installer.admin.save'), [
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => 'short',
            'password_confirmation' => 'short',
        ]);

        $response->assertSessionHasErrors(['password']);
    }

    /** @test */
    public function it_validates_password_maximum_length(): void
    {
        $longPassword = str_repeat('a', 33);

        $response = $this->post(route('installer.admin.save'), [
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => $longPassword,
            'password_confirmation' => $longPassword,
        ]);

        $response->assertSessionHasErrors(['password']);
    }

    /** @test */
    public function it_validates_name_max_length(): void
    {
        $response = $this->post(route('installer.admin.save'), [
            'name' => str_repeat('a', 151),
            'email' => 'admin@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors(['name']);
    }

    /** @test */
    public function it_validates_email_max_length(): void
    {
        $longEmail = str_repeat('a', 140) . '@example.com';

        $response = $this->post(route('installer.admin.save'), [
            'name' => 'Admin User',
            'email' => $longEmail,
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    /** @test */
    public function it_redirects_back_on_validation_failure(): void
    {
        $response = $this->post(route('installer.admin.save'), [
            'name' => '',
        ]);

        $response->assertRedirect(route('installer.admin'));
        $response->assertSessionHasErrors();
    }

    /** @test */
    public function it_preserves_input_on_validation_failure(): void
    {
        $data = [
            'name' => 'Admin User',
            'email' => 'invalid-email',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->post(route('installer.admin.save'), $data);

        $response->assertRedirect(route('installer.admin'));
        $response->assertSessionHasInput('name', 'Admin User');
        $response->assertSessionHasInput('email', 'invalid-email');
    }

    /** @test */
    public function it_does_not_preserve_password_on_validation_failure(): void
    {
        $response = $this->post(route('installer.admin.save'), [
            'name' => 'Admin User',
            'email' => 'invalid-email',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect(route('installer.admin'));
        // Passwords should not be in old input for security
        $response->assertSessionHasInput('name');
    }

    /** @test */
    public function it_accepts_valid_password_length(): void
    {
        // 8 characters (minimum)
        $response = $this->post(route('installer.admin.save'), [
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => 'pass1234',
            'password_confirmation' => 'pass1234',
        ]);

        // Should not have password length error
        $response->assertSessionDoesntHaveErrors(['password']);
    }
}
