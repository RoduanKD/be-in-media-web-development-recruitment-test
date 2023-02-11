<?php

use App\Models\Category;
use App\Models\MenuItem;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->category = Category::factory()->create(['user_id' => $this->user->id]);
});

test('guest can NOT create a menu item', function () {
    /** @var \Illuminate\Testing\TestResponse $response */
    $this->postJson(route('api.v1.menu-items.store'));

    $this->assertGuest();
});

test('user can create a menu item', function () {
    $data = [
        'name'        => 'Rice with bean',
        'price'       => 30,
        'category_id' => $this->category->id,
    ];

    /** @var \Illuminate\Testing\TestResponse $response */
    $response = $this->actingAs($this->user)
        ->postJson(route('api.v1.menu-items.store'), $data);

    $response->assertStatus(201);
    $this->assertEquals(1, MenuItem::count());
    expect(MenuItem::first())
        ->name->toBe($data['name'])
        ->price->toBe($data['price'])
        ->category_id->toBe($data['category_id']);
});
