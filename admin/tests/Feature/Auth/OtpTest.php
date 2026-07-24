<?php

use App\Models\Otp;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('correct OTP within the window logs the user in and regenerates the session', function () {
    $user = makeUser(['password' => validPassword()]);
    $code = loginToPendingOtp($user->email, validPassword());

    $response = $this->post(route('otp.verify'), ['code' => $code]);

    $response->assertRedirect(route('admin.dashboard'));
    $this->assertAuthenticatedAs($user);
    expect(session('auth.pending_user_id'))->toBeNull();
    expect($user->refresh()->last_login_at)->not->toBeNull();
});

test('expired OTP is rejected', function () {
    $user = makeUser(['password' => validPassword()]);
    $code = loginToPendingOtp($user->email, validPassword());

    Otp::where('user_id', $user->id)->update(['expires_at' => now()->subMinute()]);

    $this->post(route('otp.verify'), ['code' => $code])->assertSessionHasErrors('code');
    $this->assertGuest();
});

test('wrong code increments attempts and shows a generic error', function () {
    $user = makeUser(['password' => validPassword()]);
    $code = loginToPendingOtp($user->email, validPassword());
    $wrongCode = $code === '000000' ? '000001' : '000000';

    $this->post(route('otp.verify'), ['code' => $wrongCode])->assertSessionHasErrors('code');
    $this->assertGuest();

    expect(Otp::where('user_id', $user->id)->first()->attempts)->toBe(1);
});

test('the 5th wrong attempt invalidates the code and forces restart from login', function () {
    $user = makeUser(['password' => validPassword()]);
    $code = loginToPendingOtp($user->email, validPassword());
    $wrongCode = $code === '000000' ? '000001' : '000000';

    for ($i = 0; $i < 5; $i++) {
        $this->post(route('otp.verify'), ['code' => $wrongCode]);
    }

    // Even the real code no longer works — it's been invalidated.
    $this->post(route('otp.verify'), ['code' => $code])->assertSessionHasErrors('code');
    $this->assertGuest();
});

test('the OTP screen is unreachable without a pending login', function () {
    $this->get(route('otp.show'))->assertRedirect(route('login'));
    $this->post(route('otp.verify'), ['code' => '123456'])->assertRedirect(route('login'));
});
