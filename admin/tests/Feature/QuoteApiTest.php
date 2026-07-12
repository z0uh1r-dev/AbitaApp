<?php

use App\Mail\NewQuoteForAdmin;
use App\Mail\QuoteReceivedConfirmation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;

uses(RefreshDatabase::class);

test('client can create a quote and notifications are sent', function () {
    Mail::fake();

    User::query()->create([
        'name' => 'Admin User',
        'email' => 'admin@example.com',
        'password' => 'password',
        'is_admin' => true,
    ]);

    $payload = [
        'companyName' => 'Acme Inc',
        'contactName' => 'John Doe',
        'email' => 'john@example.com',
        'phone' => '+1 555 123 456',
        'description' => 'Need a quote for office fit-out.',
    ];

    $response = $this->postJson('/api/v1/quotes', $payload);

    $response
        ->assertCreated()
        ->assertJsonPath('message', 'Quote created successfully.')
        ->assertJsonPath('data.companyName', 'Acme Inc')
        ->assertJsonPath('data.contactName', 'John Doe')
        ->assertJsonPath('data.email', 'john@example.com')
        ->assertJsonPath('data.status', 'New');

    $this->assertDatabaseHas('quotes', [
        'companyName' => 'Acme Inc',
        'contactName' => 'John Doe',
        'email' => 'john@example.com',
        'phone' => '+1 555 123 456',
        'status' => 'New',
    ]);

    Mail::assertSent(NewQuoteForAdmin::class, function (NewQuoteForAdmin $mail) {
        return $mail->hasTo('admin@example.com')
            && $mail->quote->email === 'john@example.com';
    });

    Mail::assertSent(QuoteReceivedConfirmation::class, function (QuoteReceivedConfirmation $mail) {
        return $mail->hasTo('john@example.com')
            && $mail->quote->companyName === 'Acme Inc';
    });
});

test('quote api validates required fields', function () {
    Mail::fake();

    $response = $this->postJson('/api/v1/quotes', []);

    $response
        ->assertUnprocessable()
        ->assertJsonValidationErrors([
            'companyName',
            'contactName',
            'email',
            'phone',
            'description',
        ]);

    Mail::assertNothingSent();
});