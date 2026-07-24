<?php

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "pest()" function to bind a different classes or traits.
|
*/

pest()->extend(Tests\TestCase::class)
 // ->use(Illuminate\Foundation\Testing\RefreshDatabase::class)
    ->beforeEach(function () {
        // The `array` cache driver persists for the whole test process, so
        // without this, rate limiter state (and anything else cached)
        // would leak between test methods and cause flaky failures.
        \Illuminate\Support\Facades\Cache::flush();
    })
    ->in('Feature');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

function something()
{
    // ..
}

/**
 * A password meeting the app's policy: 12+ chars, upper/lower/number/symbol.
 */
function validPassword(): string
{
    return 'Str0ng!Passw0rd123';
}

function makeUser(array $overrides = []): \App\Models\User
{
    return \App\Models\User::create(array_merge([
        'first_name' => 'Test',
        'last_name' => 'User',
        'email' => 'user-'.uniqid().'@abitaofficedesign.com',
        'password' => validPassword(),
        'role' => 'user',
        'status' => 'active',
        'must_change_password' => false,
    ], $overrides));
}

function makeSuperAdmin(array $overrides = []): \App\Models\User
{
    return makeUser(array_merge(['role' => 'super_admin'], $overrides));
}

/**
 * Completes Step 1 (email + password) and captures the plaintext OTP that
 * was emailed, so tests can drive Step 4 without knowing the hashed value.
 */
function loginToPendingOtp(string $email, string $password): string
{
    \Illuminate\Support\Facades\Mail::fake();

    test()->post('/login', ['email' => $email, 'password' => $password])
        ->assertRedirect(route('otp.show'));

    $code = null;
    \Illuminate\Support\Facades\Mail::assertSent(\App\Mail\OtpMail::class, function ($mail) use (&$code) {
        $code = $mail->code;

        return true;
    });

    return $code;
}
