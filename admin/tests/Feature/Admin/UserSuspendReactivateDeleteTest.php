<?php

use App\Mail\AccountReactivatedMail;
use App\Mail\AccountSuspendedMail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;

uses(RefreshDatabase::class);

test('suspending a user sets their status, blocks login with the generic message, and emails them', function () {
    Mail::fake();
    $admin = makeSuperAdmin();
    $target = makeUser(['password' => validPassword()]);

    $this->actingAs($admin)->post(route('admin.users.suspend', $target))->assertRedirect();

    expect($target->refresh()->status->value)->toBe('suspended');
    Mail::assertSent(AccountSuspendedMail::class, fn ($mail) => $mail->user->id === $target->id);

    // Log out the admin session left behind by actingAs() before hitting
    // the guest-only /login route.
    $this->post(route('logout'));

    $this->post('/login', ['email' => $target->email, 'password' => validPassword()])
        ->assertSessionHasErrors('email');
    $this->assertGuest();
});

test('reactivating a suspended user restores login ability and emails them', function () {
    Mail::fake();
    $admin = makeSuperAdmin();
    $target = makeUser(['password' => validPassword(), 'status' => 'suspended']);

    $this->actingAs($admin)->post(route('admin.users.reactivate', $target))->assertRedirect();

    expect($target->refresh()->status->value)->toBe('active');
    Mail::assertSent(AccountReactivatedMail::class, fn ($mail) => $mail->user->id === $target->id);

    $this->post(route('logout'));

    $this->post('/login', ['email' => $target->email, 'password' => validPassword()])
        ->assertRedirect(route('otp.show'));
});

test('an already-active user cannot be reactivated', function () {
    $admin = makeSuperAdmin();
    $target = makeUser(['status' => 'active']);

    $this->actingAs($admin)->post(route('admin.users.reactivate', $target));

    expect($target->refresh()->status->value)->toBe('active');
});

test('deleting a user sets status to deleted and blocks login with the generic message', function () {
    $admin = makeSuperAdmin();
    $target = makeUser(['password' => validPassword()]);

    $this->actingAs($admin)->delete(route('admin.users.destroy', $target))->assertRedirect();

    expect($target->refresh()->status->value)->toBe('deleted');

    $this->post(route('logout'));

    $this->post('/login', ['email' => $target->email, 'password' => validPassword()])
        ->assertSessionHasErrors('email');
    $this->assertGuest();
});
