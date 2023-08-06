<?php

namespace API\V1;

use App\Models\Role;
use App\Models\Travel;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class TravelCreateTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_only_admin_can_create_travel(): void
    {
        $this->postJson(route('admin.travels.store', [
            'name' => 'test',
            'number_of_days' => 2,
            'is_public' => 1,
            'description' => 'test desc',
        ]))->assertStatus(Response::HTTP_UNAUTHORIZED);

        $editor = User::factory()->create();
        $editor->roles()->attach(Role::query()->where('name', 'editor')->value('id'));
        $this->actingAs($editor)->postJson(route('admin.travels.store', [
            'name' => 'test',
            'number_of_days' => 2,
            'is_public' => 1,
            'description' => 'test desc',
        ]))->assertStatus(Response::HTTP_FORBIDDEN);


        $admin = User::factory()->create();
        $admin->roles()->attach(Role::query()->where('name', 'admin')->value('id'));
        $this->actingAs($admin)->postJson(route('admin.travels.store', [
            'name' => 'test',
            'number_of_days' => 2,
            'is_public' => 1,
            'description' => 'test desc',
        ]))->assertJsonFragment(['name' => 'test'])->assertStatus(Response::HTTP_CREATED);

        $this->assertCount(1, $travels = Travel::all());
        self::assertEquals($travels->first()->name, 'test');
        self::assertEquals($travels->first()->number_of_days, 2);
        self::assertEquals($travels->first()->description, 'test desc');
    }
}
