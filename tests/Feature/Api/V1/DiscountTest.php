<?php

use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
});

test('user can add global discount on his menu', function () {
    $data = [
        'discount' => 10,
    ];

    /** @var \Illuminate\Testing\TestResponse $response */
    $response = $this->actingAs($this->user)->postJson(route('api.v1.global-discount.store'), $data);

    $response->assertStatus(200);
    expect($this->user)->discount->toBe($data['discount']);
});
