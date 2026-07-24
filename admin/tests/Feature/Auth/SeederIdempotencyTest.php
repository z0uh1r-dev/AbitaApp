<?php

use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('seeding creates exactly the three predefined accounts with the right onboarding-exempt flags', function () {
    $this->seed(DatabaseSeeder::class);

    expect(User::count())->toBe(3);

    $admin = User::where('email', 'admin@abitaofficedesign.com')->first();
    expect($admin)->not->toBeNull();
    expect($admin->is_protected)->toBeTrue();
    expect($admin->role->value)->toBe('super_admin');
    expect($admin->must_change_password)->toBeFalse();

    $zohair = User::where('email', 'f.zohair@abitaofficedesign.com')->first();
    $hachem = User::where('email', 'f.hachem@abitaofficedesign.com')->first();
    expect($zohair)->not->toBeNull();
    expect($hachem)->not->toBeNull();
    expect($zohair->must_change_password)->toBeFalse();
    expect($hachem->must_change_password)->toBeFalse();
    expect($zohair->is_protected)->toBeFalse();
    expect($zohair->role->value)->toBe('user');
});

test('running the seeder a second time does not duplicate or reset existing accounts', function () {
    $this->seed(DatabaseSeeder::class);
    $originalAdminHash = User::where('email', 'admin@abitaofficedesign.com')->first()->password;

    $this->seed(DatabaseSeeder::class);

    expect(User::count())->toBe(3);
    expect(User::where('email', 'admin@abitaofficedesign.com')->first()->password)->toBe($originalAdminHash);
});
