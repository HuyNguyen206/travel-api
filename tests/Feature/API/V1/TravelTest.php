<?php

namespace Tests\Travel\Feature\API\V1;

use App\Models\Tour;
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

        $this->getJson(route('travels.index'))
            ->assertJsonCount(10, 'data')
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

    public function test_can_get_list_of_tours_paginated_belong_to_travel()
    {
        $travel = Travel::factory()->public()->create();
        Tour::factory(25)->create([
            'travel_id' => $travel->id
        ]);
        Tour::factory(10)->create();

        $this->getJson(route('travels.tours.index', $travel->slug))
            ->assertJsonCount(10, 'data')
            ->assertJsonPath('meta.total', 25)
            ->assertJsonPath('meta.last_page', 3)
            ->assertSuccessful();
    }

    public function test_can_get_list_of_tours_paginated_belong_to_travel_with_filter_and_order_by_start_date_asc()
    {
        $travel = Travel::factory()->public()->create();
        Tour::factory(5)->create([
            'travel_id' => $travel->id,
            'start_date' => '2023-08-05',
            'end_date' => '2023-08-10',
            'price' => 5
        ]);

        Tour::factory(3)->create([
            'travel_id' => $travel->id,
            'start_date' => '2023-08-08',
            'end_date' => '2023-08-10',
            'price' => 20
        ]);

        Tour::factory(3)->create([
            'travel_id' => $travel->id,
            'start_date' => '2023-08-09',
            'end_date' => '2023-08-10',
            'price' => 40,
        ]);

        Tour::factory(3)->create([
            'start_date' => '2023-08-10',
            'end_date' => '2023-08-10',
            'price' => 90,
        ]);

        $this->getJson(route('travels.tours.index', [
                $travel->slug,
                'start_date' => '2023-08-08',
                'end_date' => '2023-08-10',
                'price_from' => 10*100,
                'price_to' => 50*100,
            ]
        ))
            ->assertJsonCount(6, 'data')
            ->assertJsonPath('meta.total', 6)
            ->assertJsonPath('meta.last_page', 1)
            ->assertJsonPath('data.0.start_date', '2023-08-08')
            ->assertJsonPath('data.1.start_date', '2023-08-08')
            ->assertJsonPath('data.2.start_date', '2023-08-08')
            ->assertJsonPath('data.3.start_date', '2023-08-09')
            ->assertJsonPath('data.4.start_date', '2023-08-09')
            ->assertJsonPath('data.5.start_date', '2023-08-09')
            ->assertSuccessful();
    }

    public function test_can_get_list_of_tours_paginated_belong_to_travel_order_by_price_asc()
    {
        $travel = Travel::factory()->public()->create();
        Tour::factory()->create([
            'travel_id' => $travel->id,
            'start_date' => '2023-08-08',
            'end_date' => '2023-08-10',
            'price' => 20
        ]);

        Tour::factory()->create([
            'travel_id' => $travel->id,
            'start_date' => '2023-08-08',
            'end_date' => '2023-08-10',
            'price' => 22
        ]);

        Tour::factory()->create([
            'travel_id' => $travel->id,
            'start_date' => '2023-08-09',
            'end_date' => '2023-08-10',
            'price' => 22
        ]);


        $this->getJson(route('travels.tours.index', [
                $travel->slug,
                'start_date' => '2023-08-08',
                'end_date' => '2023-08-10',
                'price_from' => 5*100,
                'price_to' => 50*100,
                'sort[price]' => 'asc'
            ]
        ))
            ->assertJsonCount(3, 'data')
            ->assertJsonPath('meta.total', 3)
            ->assertJsonPath('meta.last_page', 1)

            ->assertJsonPath('data.0.start_date', '2023-08-08')
            ->assertJsonPath('data.0.price', 20)

            ->assertJsonPath('data.1.start_date', '2023-08-08')
            ->assertJsonPath('data.1.price', 22)

            ->assertJsonPath('data.2.start_date', '2023-08-09')
            ->assertJsonPath('data.2.price', 22)

            ->assertSuccessful();
    }
}
