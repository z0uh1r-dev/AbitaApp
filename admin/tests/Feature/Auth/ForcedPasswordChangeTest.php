<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('a user flagged must_change_password is redirected to the change-password screen after OTP success', function () {
    $user = makeUser(['password' => validPassword(), 'must_change_password' => true]);
    $code = loginToPendingOtp($user->email, validPassword());

    $this->post(route('otp.verify'), ['code' => $code])
        ->assertRedirect(route('password.change.show'));
});

test('a user flagged must_change_password cannot reach other authenticated routes until they change it', function () {
    $user = makeUser(['must_change_password' => true]);

    $this->actingAs($user)
        ->get(route('admin.dashboard'))
        ->assertRedirect(route('password.change.show'));

    $this->actingAs($user)
        ->get(route('password.change.show'))
        ->assertOk();
});

test('after changing the password, the flag clears and normal access resumes', function () {
    $user = makeUser(['must_change_password' => true]);

    $this->actingAs($user)
        ->put(route('password.change.update'), [
            'password' => 'Br4nd!NewPassw0rd',
            'password_confirmation' => 'Br4nd!NewPassw0rd',
        ])
        ->assertRedirect(route('admin.dashboard'));

    expect($user->refresh()->must_change_password)->toBeFalse();

    $this->actingAs($user)
        ->get(route('admin.dashboard'))
        ->assertOk();
});
