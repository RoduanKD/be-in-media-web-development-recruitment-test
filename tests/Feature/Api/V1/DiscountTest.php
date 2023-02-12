<?php

use App\Models\Category;
use App\Models\MenuItem;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
});

test('user can add global discount on his menu', function () {
    $data = [
        'discount' => 10,
    ];

    /** @var \Illuminate\Testing\TestResponse $response */
    $response = $this->actingAs($this->user)->postJson(route('api.v1.global-discount.update'), $data);

    $response->assertStatus(200);
    expect($this->user)->discount->toBe($data['discount']);
});

test('user can add discount to a category', function () {
    $category = Category::factory()->create(['user_id' => $this->user->id]);
    $data = [
        'discount' => 10,
    ];

    /** @var \Illuminate\Testing\TestResponse $response */
    $response = $this->actingAs($this->user)->postJson(route('api.v1.category-discount.update', $category), $data);

    $response->assertStatus(200);
    $category->refresh();
    expect($category)->discount->toBe($data['discount']);
});

test('user can NOT add discount to a category he doesnt own', function () {
    $category = Category::factory()->create(['user_id' => User::factory()->create()->id]);
    $data = [
        'discount' => 10,
    ];

    /** @var \Illuminate\Testing\TestResponse $response */
    $response = $this->actingAs($this->user)->postJson(route('api.v1.category-discount.update', $category), $data);

    $response->assertStatus(403);
    $category->refresh();
    expect($category)->discount->toBe(0);
});

test('user can add discount to a menu item', function () {
    $item = MenuItem::factory()->for(Category::factory()->state(['user_id' => $this->user]))->create();
    $data = [
        'discount' => 10,
    ];

    /** @var \Illuminate\Testing\TestResponse $response */
    $response = $this->actingAs($this->user)->postJson(route('api.v1.item-discount.update', $item), $data);

    $response->assertStatus(200);
    $item->refresh();
    expect($item)->discount->toBe($data['discount']);
});

test('menu item returns correct discount price when discount is stored inside it', function () {
    $item = MenuItem::factory(null, ['discount' => 10, 'price' => 150])
        ->for(Category::factory(null, ['user_id' => $this->user]))->create();

    expect($item)->discount_price->toBe(15);
});

test('menu item returns price when discount is 0', function () {
    $item = MenuItem::factory(null, ['discount' => 0, 'price' => 150])
        ->for(Category::factory(null, ['user_id' => $this->user]))->create();

    expect($item)->discount_price->toBe(150);
});
