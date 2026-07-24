<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('the 6th login attempt within a minute for the same ip+email is throttled', function () {
    $user = makeUser(['password' => validPassword()]);

    for ($i = 0; $i < 5; $i++) {
        $this->post('/login', ['email' => $user->email, 'password' => 'wrong-password']);
    }

    $response = $this->post('/login', ['email' => $user->email, 'password' => 'wrong-password']);

    $response->assertStatus(429);
});

test('OTP verification is throttled after too many attempts within a minute', function () {
    $user = makeUser(['password' => validPassword()]);
    loginToPendingOtp($user->email, validPassword());

    $lastResponse = null;
    for ($i = 0; $i < 11; $i++) {
        $lastResponse = $this->post(route('otp.verify'), ['code' => '000000']);
    }

    $lastResponse->assertStatus(429);
});
