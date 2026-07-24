<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('self-service password change requires the correct current password', function () {
    $user = makeUser(['password' => 'OldPassw0rd!123']);

    $this->actingAs($user)
        ->put(route('password.change.update'), [
            'current_password' => 'wrong-current-password',
            'password' => 'Br4nd!NewPassw0rd',
            'password_confirmation' => 'Br4nd!NewPassw0rd',
        ])
        ->assertSessionHasErrors('current_password');
});

test('self-service password change succeeds with the correct current password and a policy-compliant new one', function () {
    $user = makeUser(['password' => 'OldPassw0rd!123']);

    $this->actingAs($user)
        ->put(route('password.change.update'), [
            'current_password' => 'OldPassw0rd!123',
            'password' => 'Br4nd!NewPassw0rd',
            'password_confirmation' => 'Br4nd!NewPassw0rd',
        ])
        ->assertRedirect(route('admin.dashboard'));

    expect(\Illuminate\Support\Facades\Hash::check('Br4nd!NewPassw0rd', $user->refresh()->password))->toBeTrue();
});

test('a new password must meet the complexity policy', function () {
    $user = makeUser(['password' => 'OldPassw0rd!123']);

    $this->actingAs($user)
        ->put(route('password.change.update'), [
            'current_password' => 'OldPassw0rd!123',
            'password' => 'short',
            'password_confirmation' => 'short',
        ])
        ->assertSessionHasErrors('password');
});
