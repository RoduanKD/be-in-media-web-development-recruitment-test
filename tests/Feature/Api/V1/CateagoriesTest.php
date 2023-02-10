<?php

use App\Models\User;

test('user can create a category', function () {
    $user = User::factory()->create();
    $data = [
        'name' => 'Main dishes',
    ];

    /** @var \Illuminate\Testing\TestResponse $response */
    $response = $this->actingAs($user)->post(route('api.v1.categories.store'), $data);

    $response->assertStatus(201);
    $this->assertEquals(1, $user->categories()->count());
    $this->assertEquals($data['name'], $user->categories()->first()->name);
});
