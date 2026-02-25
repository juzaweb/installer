<?php

namespace Juzaweb\Installer\Tests\Feature;

use Juzaweb\Installer\Tests\TestCase;
use Juzaweb\Installer\Helpers\DatabaseManager;
use Juzaweb\Installer\Helpers\FinalInstallManager;
use Juzaweb\Installer\Helpers\InstalledFileManager;
use Mockery;

class InstallCommandTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Mock dependencies to prevent actual execution of these parts
        $this->mock(DatabaseManager::class, function ($mock) {
            $mock->shouldReceive('run')->once();
        });

        $this->mock(FinalInstallManager::class, function ($mock) {
            $mock->shouldReceive('runFinal')->once();
        });

        $this->mock(InstalledFileManager::class, function ($mock) {
            $mock->shouldReceive('update')->once();
        });
    }

    public function test_install_command_with_options()
    {
        $this->artisan('juzaweb:install', [
            '--fullname' => 'Test User',
            '--email' => 'test@example.com',
            '--password' => 'password123',
        ])
        ->expectsOutput('Juzaweb CMS Installtion')
        ->expectsOutput('-- Database Install')
        ->expectsOutput('-- Publish assets')
        ->expectsOutput('-- Create user admin')
        ->expectsOutput('-- Update installed')
        ->expectsOutput('Juzaweb CMS Install Successfully !!!')
        ->assertExitCode(0);

        $this->assertDatabaseHas('users', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'is_super_admin' => 1,
        ]);
    }

    public function test_install_command_interactive()
    {
        // Re-mock because setUp mocks are per-test but used once in previous test?
        // Actually setUp runs before each test so mocks are fresh.

        $this->artisan('juzaweb:install')
            ->expectsQuestion('Full Name?', 'Interactive User')
            ->expectsQuestion('Email?', 'interactive@example.com')
            ->expectsQuestion('Password?', 'password123')
            ->expectsOutput('Juzaweb CMS Installtion')
            ->assertExitCode(0);

        $this->assertDatabaseHas('users', [
            'name' => 'Interactive User',
            'email' => 'interactive@example.com',
        ]);
    }

    public function test_install_command_validation_failure_and_retry()
    {
        $this->artisan('juzaweb:install', [
            '--fullname' => 'Test User',
            '--email' => 'invalid-email', // Invalid
            '--password' => 'password123',
        ])
        // Validation error might be language dependent, but typically "The email field must be a valid email address."
        // or checking that it outputs *some* error.
        // But `expectsOutput` matches exact string.
        // Let's assume English default or use translation key if possible?
        // The code uses `trans('installer::message.environment.wizard.form.email')` for attribute name.
        // Laravel default validation message for email is "The :attribute must be a valid email address."
        // So: "The Email must be a valid email address." (if attribute name is capitalized/translated)
        // Let's just check the flow and be lenient on the error message if needed, or rely on standard laravel messages.
        // Actually, let's verify what the attribute name translates to.
        // In testbench, lang might be default.
        ->expectsQuestion('Email?', 'valid@example.com')
        ->assertExitCode(0);

        $this->assertDatabaseHas('users', [
            'name' => 'Test User',
            'email' => 'valid@example.com',
        ]);
    }
}
