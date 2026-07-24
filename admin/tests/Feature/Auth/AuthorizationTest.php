<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('a regular user can access dashboard, profile, and change their own password', function () {
    $user = makeUser();

    $this->actingAs($user)->get(route('admin.dashboard'))->assertOk();
    $this->actingAs($user)->get(route('admin.profile.show'))->assertOk();
    $this->actingAs($user)->get(route('password.change.show'))->assertOk();
});

test('a regular user has no administrative permissions', function () {
    $user = makeUser();
    $category = \App\Models\Category::create(['name' => 'Test', 'slug' => 'test']);

    $this->actingAs($user)->get(route('admin.categories.index'))->assertForbidden();
    $this->actingAs($user)->get(route('admin.categories.create'))->assertForbidden();
    $this->actingAs($user)->get(route('admin.products.index'))->assertForbidden();
    $this->actingAs($user)->get(route('admin.quotes.index'))->assertForbidden();
    $this->actingAs($user)->get(route('admin.messages.index'))->assertForbidden();
    $this->actingAs($user)->get(route('admin.users.index'))->assertForbidden();
    $this->actingAs($user)->get(route('admin.auth-logs.index'))->assertForbidden();
});

test('a super admin can access every administrative section', function () {
    $admin = makeSuperAdmin();

    $this->actingAs($admin)->get(route('admin.dashboard'))->assertOk();
    $this->actingAs($admin)->get(route('admin.categories.index'))->assertOk();
    $this->actingAs($admin)->get(route('admin.products.index'))->assertOk();
    $this->actingAs($admin)->get(route('admin.quotes.index'))->assertOk();
    $this->actingAs($admin)->get(route('admin.messages.index'))->assertOk();
    $this->actingAs($admin)->get(route('admin.users.index'))->assertOk();
    $this->actingAs($admin)->get(route('admin.auth-logs.index'))->assertOk();
});

test('unauthenticated visitors are redirected to login for every protected route', function () {
    $this->get(route('admin.dashboard'))->assertRedirect(route('login'));
    $this->get(route('admin.users.index'))->assertRedirect(route('login'));
    $this->get(route('password.change.show'))->assertRedirect(route('login'));
});
