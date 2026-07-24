<?php

use App\Models\AuthLog;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('a failed login against an unknown email is logged with no user and the attempted email captured', function () {
    $this->post('/login', ['email' => 'ghost@abitaofficedesign.com', 'password' => 'whatever12345!A']);

    $log = AuthLog::where('event', 'login_failed')->latest('id')->first();

    expect($log)->not->toBeNull();
    expect($log->user_id)->toBeNull();
    expect($log->email_attempted)->toBe('ghost@abitaofficedesign.com');
    expect($log->ip_address)->not->toBeNull();
});

test('a successful login logs otp_generated, otp_verified and login_success against the user', function () {
    $user = makeUser(['password' => validPassword()]);
    $code = loginToPendingOtp($user->email, validPassword());
    $this->post(route('otp.verify'), ['code' => $code]);

    expect(AuthLog::where('user_id', $user->id)->where('event', 'otp_generated')->exists())->toBeTrue();
    expect(AuthLog::where('user_id', $user->id)->where('event', 'otp_verified')->exists())->toBeTrue();
    expect(AuthLog::where('user_id', $user->id)->where('event', 'login_success')->exists())->toBeTrue();
});

test('a wrong OTP code logs otp_failed', function () {
    $user = makeUser(['password' => validPassword()]);
    $code = loginToPendingOtp($user->email, validPassword());
    $wrongCode = $code === '000000' ? '000001' : '000000';

    $this->post(route('otp.verify'), ['code' => $wrongCode]);

    expect(AuthLog::where('user_id', $user->id)->where('event', 'otp_failed')->exists())->toBeTrue();
});

test('logout is logged', function () {
    $user = makeSuperAdmin();
    $this->actingAs($user)->post(route('logout'));

    expect(AuthLog::where('user_id', $user->id)->where('event', 'logout')->exists())->toBeTrue();
});

test('user-management actions are all logged', function () {
    $admin = makeSuperAdmin();
    $target = makeUser();

    $this->actingAs($admin)->post(route('admin.users.suspend', $target));
    $this->actingAs($admin)->post(route('admin.users.reactivate', $target));
    $this->actingAs($admin)->delete(route('admin.users.destroy', $target));

    expect(AuthLog::where('user_id', $target->id)->where('event', 'user_suspended')->exists())->toBeTrue();
    expect(AuthLog::where('user_id', $target->id)->where('event', 'user_reactivated')->exists())->toBeTrue();
    expect(AuthLog::where('user_id', $target->id)->where('event', 'user_deleted')->exists())->toBeTrue();
});

test('password reset and password change are logged', function () {
    $admin = makeSuperAdmin();
    $target = makeUser(['password' => 'OldPassw0rd!123']);

    $this->actingAs($admin)->post(route('admin.users.reset-password', $target), [
        'password' => 'Br4nd!NewPassw0rd',
        'password_confirmation' => 'Br4nd!NewPassw0rd',
    ]);
    expect(AuthLog::where('user_id', $target->id)->where('event', 'password_reset')->exists())->toBeTrue();

    // $target's in-memory password attribute is stale after the reset
    // above (which happened via a fresh model instance in the controller);
    // refresh before authenticating as them for the change-password step.
    $target->refresh();

    $this->actingAs($target)->put(route('password.change.update'), [
        'current_password' => 'Br4nd!NewPassw0rd',
        'password' => 'AnotherStr0ng!Pass',
        'password_confirmation' => 'AnotherStr0ng!Pass',
    ]);
    expect(AuthLog::where('user_id', $target->id)->where('event', 'password_changed')->exists())->toBeTrue();
});

test('the auth log page is super-admin-only and supports filtering by event', function () {
    $admin = makeSuperAdmin();
    $user = makeUser();

    $this->actingAs($user)->get(route('admin.auth-logs.index'))->assertForbidden();

    AuthLog::create(['event' => 'logout', 'user_id' => $admin->id]);

    $this->actingAs($admin)
        ->get(route('admin.auth-logs.index', ['event' => 'logout']))
        ->assertOk();
});
