<?php

namespace Tests\Feature\API\V1;

use App\Models\Travel;
use Tests\TestCase;

class TravelTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_can_get_list_public_travel_with_paginated(): void
    {
        Travel::factory(3)->create();
        Travel::factory(25)->create([
            'is_public' => true
        ]);

        $this->get(route('travels.index'))
            ->assertJsonCount(10, 'data')
            ->assertJsonPath('data', 'data')
            ->assertJsonPath('meta.per_page', 10)
            ->assertJsonPath('meta.total', 25)
            ->assertJsonStructure([
                'data' => [

                ],
                'meta' => [

                ]
            ])
            ->assertStatus(200);
    }
}
