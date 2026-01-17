<?php

namespace Juzaweb\Installer\Tests\Feature;

use Juzaweb\Installer\Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EnvironmentPostTest extends TestCase
{
    /** @test */
    public function it_validates_required_database_fields(): void
    {
        $response = $this->post(route('installer.environment.save'), []);

        $response->assertSessionHasErrors([
            'database_hostname',
            'database_port',
            'database_name',
            'database_username',
        ]);
    }

    /** @test */
    public function it_validates_database_port_is_numeric(): void
    {
        $response = $this->post(route('installer.environment.save'), [
            'database_hostname' => 'localhost',
            'database_port' => 'not-a-number',
            'database_name' => 'test_db',
            'database_username' => 'root',
        ]);

        $response->assertSessionHasErrors(['database_port']);
    }

    /** @test */
    public function it_validates_max_length_for_database_fields(): void
    {
        $response = $this->post(route('installer.environment.save'), [
            'database_hostname' => str_repeat('a', 151),
            'database_port' => 3306,
            'database_name' => str_repeat('b', 151),
            'database_username' => str_repeat('c', 151),
        ]);

        $response->assertSessionHasErrors([
            'database_hostname',
            'database_name',
            'database_username',
        ]);
    }

    /** @test */
    public function it_allows_nullable_database_password(): void
    {
        // Mock database connection to avoid actual connection
        DB::shouldReceive('purge')->once();
        DB::shouldReceive('connection->getPdo')->once()->andReturn(true);

        $response = $this->post(route('installer.environment.save'), [
            'database_hostname' => 'localhost',
            'database_port' => 3306,
            'database_name' => 'test_db',
            'database_username' => 'root',
            'database_password' => null,
        ]);

        // Should not have password validation error
        $response->assertSessionDoesntHaveErrors(['database_password']);
    }

    /** @test */
    public function it_redirects_back_on_validation_failure(): void
    {
        $response = $this->post(route('installer.environment.save'), [
            'database_hostname' => '',
        ]);

        $response->assertRedirect(route('installer.environment'));
        $response->assertSessionHasErrors();
    }

    /** @test */
    public function it_preserves_input_on_validation_failure(): void
    {
        $data = [
            'database_hostname' => 'localhost',
            'database_port' => 'invalid',
            'database_name' => 'test_db',
            'database_username' => 'root',
        ];

        $response = $this->post(route('installer.environment.save'), $data);

        $response->assertRedirect(route('installer.environment'));
        $response->assertSessionHasInput('database_hostname', 'localhost');
    }
}
