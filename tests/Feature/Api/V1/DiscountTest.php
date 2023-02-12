<?php

use App\Models\Category;
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
    $response = $this->actingAs($this->user)->postJson(route('api.v1.category-discounts.update', $category), $data);

    $response->assertStatus(200);
    $category->refresh();
    expect($category)->discount->toBe($data['discount']);
});
