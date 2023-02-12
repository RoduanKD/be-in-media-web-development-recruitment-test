<?php

use App\Models\Category;
use App\Models\MenuItem;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->has(
        Category::factory(3)
            ->has(MenuItem::factory(3), 'items')
    )->create();

    $category = Category::orderByDesc('id')->firstOrFail('id');
    Category::factory(2, [
        'parent_id' => $category->id,
        'user_id'   => $this->user->id,
    ])
        ->has(MenuItem::factory(3), 'items')
        ->create();
});

it('returns categories with proper structure', function () {
    /** @var \Illuminate\Testing\TestResponse $response */
    $response = $this->get(route('api.v1.categories.index', $this->user));

    $categoryStructure = [
        'name',
        'slug',
    ];
    $response->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                '0' => [
                    'children' => ['*' => $categoryStructure],
                ],
                '*' => $categoryStructure,
            ],
            'links',
            'meta',
        ]);
});

it('returns menu items of a category with proper structure', function () {
    /** @var \Illuminate\Testing\TestResponse $response */
    $response = $this->get(route('api.v1.menu-items.index', Category::first()));

    $response->assertStatus(200)
        ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'name',
                        'slug',
                        'price',
                        'discount_price',
                    ],
                ],
            ]
        );
});
