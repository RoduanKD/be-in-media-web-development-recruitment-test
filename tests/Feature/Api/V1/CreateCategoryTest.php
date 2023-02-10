<?php

use App\Models\Category;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
});

test('guest can NOT create a category', function () {
    $data = [
        'name' => 'Main dishes',
    ];

    /** @var \Illuminate\Testing\TestResponse $response */
    $this->post(route('api.v1.categories.store'), $data);

    $this->assertGuest();
});

test('user can create a category', function () {
    $data = [
        'name' => 'Main dishes',
    ];

    /** @var \Illuminate\Testing\TestResponse $response */
    $response = $this->actingAs($this->user)->post(route('api.v1.categories.store'), $data);

    $response->assertStatus(201);
    $this->assertEquals(1, $this->user->categories()->count());
    $this->assertEquals($data['name'], $this->user->categories()->first()->name);
});

test('user can create a subcategory', function () {
    $category = Category::factory()->create(['user_id' => $this->user->id]);
    $data = [
        'name'      => 'Main dishes',
        'parent_id' => $category->id,
    ];

    /** @var \Illuminate\Testing\TestResponse $response */
    $response = $this->actingAs($this->user)->post(route('api.v1.categories.store'), $data);

    $response->assertStatus(201);
    $this->assertEquals(2, $this->user->categories()->count());
    $this->assertEquals(1, $category->children()->count());
    $this->assertEquals($data['name'], $category->children()->first()->name);
});
