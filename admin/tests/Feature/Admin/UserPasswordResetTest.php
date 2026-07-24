<?php

use App\Mail\PasswordResetMail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

uses(RefreshDatabase::class);

test('an immediate admin password reset lets the user log in right away with the new password', function () {
    Mail::fake();
    $admin = makeSuperAdmin();
    $target = makeUser(['password' => 'OldPassw0rd!123', 'must_change_password' => false]);

    $this->actingAs($admin)->post(route('admin.users.reset-password', $target), [
        'password' => 'Br4nd!NewPassw0rd',
        'password_confirmation' => 'Br4nd!NewPassw0rd',
    ])->assertRedirect();

    $target->refresh();
    expect(Hash::check('Br4nd!NewPassw0rd', $target->password))->toBeTrue();
    expect($target->must_change_password)->toBeFalse();

    Mail::assertSent(PasswordResetMail::class, fn ($mail) => $mail->user->id === $target->id);

    // The admin's session from actingAs() is still authenticated — log out
    // first so the /login route (guest-only) is actually reachable.
    $this->post(route('logout'));

    $this->post('/login', ['email' => $target->email, 'password' => 'Br4nd!NewPassw0rd'])
        ->assertRedirect(route('otp.show'));
});

test('forcing a password reset keeps the current password valid but requires a change at next login', function () {
    $admin = makeSuperAdmin();
    $target = makeUser(['password' => 'StillW0rks!123', 'must_change_password' => false]);

    $this->actingAs($admin)->post(route('admin.users.force-password-reset', $target))->assertRedirect();

    $target->refresh();
    expect($target->must_change_password)->toBeTrue();
    expect(Hash::check('StillW0rks!123', $target->password))->toBeTrue();

    $this->post(route('logout'));

    $this->post('/login', ['email' => $target->email, 'password' => 'StillW0rks!123'])
        ->assertRedirect(route('otp.show'));
});
