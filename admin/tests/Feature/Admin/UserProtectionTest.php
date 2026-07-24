<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('the protected owner account cannot be deleted or suspended', function () {
    $admin = makeSuperAdmin();
    $admin->is_protected = true;
    $admin->save();

    $this->actingAs($admin)->delete(route('admin.users.destroy', $admin))->assertForbidden();
    $this->actingAs($admin)->post(route('admin.users.suspend', $admin))->assertForbidden();

    expect($admin->refresh()->status->value)->toBe('active');
});

test('the protected owner account role cannot be changed, even by another super admin', function () {
    $actingAdmin = makeSuperAdmin();
    $protected = makeSuperAdmin();
    $protected->is_protected = true;
    $protected->save();

    $this->actingAs($actingAdmin)->put(route('admin.users.update', $protected), [
        'first_name' => $protected->first_name,
        'last_name' => $protected->last_name,
        'email' => $protected->email,
        'role' => 'user',
    ]);

    expect($protected->refresh()->role->value)->toBe('super_admin');
});

test('non-role fields on the protected owner account can still be edited', function () {
    $admin = makeSuperAdmin();
    $admin->is_protected = true;
    $admin->save();

    $this->actingAs($admin)->put(route('admin.users.update', $admin), [
        'first_name' => 'Renamed',
        'last_name' => $admin->last_name,
        'email' => $admin->email,
        'role' => 'super_admin',
    ])->assertRedirect(route('admin.users.index'));

    expect($admin->refresh()->first_name)->toBe('Renamed');
});
