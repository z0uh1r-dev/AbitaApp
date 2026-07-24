<?php

use App\Services\LoginService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('valid credentials redirect to the OTP screen without authenticating yet', function () {
    $user = makeUser(['password' => 'CorrectHorse!9Battery']);

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'CorrectHorse!9Battery',
    ]);

    $response->assertRedirect(route('otp.show'));
    $this->assertGuest();
    expect(session('auth.pending_user_id'))->toBe($user->id);
});

test('wrong password, unknown email, wrong domain, suspended and deleted accounts all fail identically', function () {
    $active = makeUser(['password' => validPassword()]);
    $suspended = makeUser(['status' => 'suspended']);
    $deleted = makeUser(['status' => 'deleted']);

    $attempts = [
        ['email' => $active->email, 'password' => 'totally-wrong-password'],
        ['email' => 'nobody@abitaofficedesign.com', 'password' => validPassword()],
        ['email' => 'someone@gmail.com', 'password' => validPassword()],
        ['email' => $suspended->email, 'password' => validPassword()],
        ['email' => $deleted->email, 'password' => validPassword()],
    ];

    $messages = [];

    foreach ($attempts as $credentials) {
        $response = $this->post('/login', $credentials);
        $response->assertSessionHasErrors('email');
        $messages[] = session('errors')->get('email')[0];
        $this->assertGuest();
    }

    expect(array_unique($messages))->toHaveCount(1);
    expect($messages[0])->toBe(LoginService::GENERIC_ERROR);
});

test('login requires a well-formed email and a password', function () {
    $this->post('/login', ['email' => 'not-an-email', 'password' => 'x'])
        ->assertSessionHasErrors('email');

    $this->post('/login', ['email' => '', 'password' => ''])
        ->assertSessionHasErrors(['email', 'password']);
});

test('a mail delivery failure while sending the OTP fails clearly instead of crashing or hanging', function () {
    $user = makeUser(['password' => validPassword()]);

    Illuminate\Support\Facades\Mail::shouldReceive('to->send')
        ->once()
        ->andThrow(new Symfony\Component\Mailer\Exception\TransportException('Connection could not be established'));

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => validPassword(),
    ]);

    $response->assertSessionHasErrors('email');
    $this->assertGuest();
});
