<?php

use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
});

test('guest can NOT create a menu item', function () {
    /** @var \Illuminate\Testing\TestResponse $response */
    $this->postJson(route('api.v1.menu-items.store'));

    $this->assertGuest();
});
