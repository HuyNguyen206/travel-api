<?php

namespace API\V1;

use App\Models\Role;
use App\Models\User;
use Tests\TestCase;

class LoginTest extends TestCase
{

    /**
     * A basic feature test example.
     */
    public function test_user_can_login(): void
    {
        $admin = User::factory()->create();
        $admin->roles()->attach(Role::query()->where('name', 'admin')->value('id'));
        $response = $this->postJson(route('admin.login', [
            'email' => $admin->email,
            'password' => 'password',
            'device_name' => 'auto test',
        ]))->assertJsonStructure(['access_token']);

        $response->assertStatus(200);
    }

    public function test_user_can_not_login_with_incorrect_credential(): void
    {
        $admin = User::factory()->create(['email' => 'huy@gmail.com']);
        $admin->roles()->attach(Role::query()->where('name', 'admin')->value('id'));
        $response = $this->postJson(route('admin.login', [
            'email' => 'non_exist_email@gmail.com',
        ]))->assertJsonMissingPath('access_token');

        $response->assertStatus(422);
    }

    public function test_login_require_email_password(): void
    {
        $admin = User::factory()->create(['email' => 'huy@gmail.com']);
        $admin->roles()->attach(Role::query()->where('name', 'admin')->value('id'));
        $response = $this->postJson(route('admin.login', [
            'email' => '',
        ]))->assertJsonMissingPath('access_token')
        ->assertJsonValidationErrors(['email', 'password', 'device_name']);

        $response->assertStatus(422);
    }
}
