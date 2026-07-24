<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('an authenticated user can log out and loses access to admin routes', function () {
    $user = makeSuperAdmin();

    $this->actingAs($user)->post(route('logout'))->assertRedirect('/');
    $this->assertGuest();

    $this->get('/admin')->assertRedirect(route('login'));
});
