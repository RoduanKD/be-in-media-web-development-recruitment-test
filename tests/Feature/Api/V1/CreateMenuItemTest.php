<?php

use App\Models\Category;
use App\Models\MenuItem;
use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;

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

test('menu item can NOT be siblings with other categories', function () {
    $subCategory = Category::factory()->create(['user_id' => $this->user->id, 'parent_id' => $this->category->id]);
    $data = [
        'name'        => 'Rice with beans',
        'price'       => 30,
        'category_id' => $this->category->id,
    ];

    /** @var \Illuminate\Testing\TestResponse $response */
    $response = $this->actingAs($this->user)
        ->postJson(route('api.v1.menu-items.store'), $data);

    $response->assertStatus(422)
        ->assertJsonValidationErrorFor('category_id')
        ->assertJson(fn(AssertableJson $json) => $json
            ->where('message', __('Category must NOT contain mixed children'))
            ->where('errors.category_id.0', __('Category must NOT contain mixed children'))
        );
    $this->assertEquals(0, MenuItem::count());
});
