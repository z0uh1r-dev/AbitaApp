<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('client can create a contact message via api', function () {
    $payload = [
        'fullName' => 'John Doe',
        'companyName' => 'Acme Inc',
        'phone' => '+1 555 123 456',
        'email' => 'john@example.com',
        'message' => 'Hello, I need more information about your services.',
    ];

    $response = $this->postJson('/api/v1/contact-messages', $payload);

    $response
        ->assertCreated()
        ->assertJsonPath('message', 'Contact message created successfully.')
        ->assertJsonPath('data.fullName', 'John Doe')
        ->assertJsonPath('data.companyName', 'Acme Inc')
        ->assertJsonPath('data.email', 'john@example.com');

    $this->assertDatabaseHas('contact_messages', [
        'fullName' => 'John Doe',
        'companyName' => 'Acme Inc',
        'phone' => '+1 555 123 456',
        'email' => 'john@example.com',
    ]);
});

test('contact message api validates required fields', function () {
    $response = $this->postJson('/api/v1/contact-messages', []);

    $response
        ->assertUnprocessable()
        ->assertJsonValidationErrors([
            'fullName',
            'companyName',
            'phone',
            'email',
            'message',
        ]);
});
