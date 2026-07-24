<?php

use App\Mail\WelcomeMail;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;

uses(RefreshDatabase::class);

test('super admin can create a new user with a company email, triggering full onboarding', function () {
    Mail::fake();
    $admin = makeSuperAdmin();

    $response = $this->actingAs($admin)->post(route('admin.users.store'), [
        'first_name' => 'New',
        'last_name' => 'Hire',
        'email' => 'new.hire@abitaofficedesign.com',
        'password' => validPassword(),
        'password_confirmation' => validPassword(),
        'role' => 'user',
    ]);

    $response->assertRedirect(route('admin.users.index'));

    $user = User::where('email', 'new.hire@abitaofficedesign.com')->first();
    expect($user)->not->toBeNull();
    expect($user->must_change_password)->toBeTrue();
    expect($user->status->value)->toBe('active');

    Mail::assertSent(WelcomeMail::class, fn ($mail) => $mail->user->id === $user->id);
});

test('a non-company email is rejected when creating a user', function () {
    $admin = makeSuperAdmin();

    $this->actingAs($admin)->post(route('admin.users.store'), [
        'first_name' => 'New',
        'last_name' => 'Hire',
        'email' => 'outsider@gmail.com',
        'password' => validPassword(),
        'password_confirmation' => validPassword(),
        'role' => 'user',
    ])->assertSessionHasErrors('email');

    expect(User::where('email', 'outsider@gmail.com')->exists())->toBeFalse();
});

test('super admin can update a user', function () {
    $admin = makeSuperAdmin();
    $target = makeUser();

    $this->actingAs($admin)->put(route('admin.users.update', $target), [
        'first_name' => 'Updated',
        'last_name' => $target->last_name,
        'email' => $target->email,
        'role' => 'user',
    ])->assertRedirect(route('admin.users.index'));

    expect($target->refresh()->first_name)->toBe('Updated');
});

test('the user list supports search', function () {
    $admin = makeSuperAdmin();
    makeUser(['first_name' => 'Findme', 'email' => 'findme@abitaofficedesign.com']);
    makeUser(['first_name' => 'Other']);

    $response = $this->actingAs($admin)->get(route('admin.users.index', ['q' => 'Findme']));

    $response->assertOk();
    $response->assertSee('Findme');
    $response->assertDontSee('Other');
});

test('the user list supports role and status filters', function () {
    $admin = makeSuperAdmin();
    makeUser(['first_name' => 'ActiveUser', 'status' => 'active']);
    makeUser(['first_name' => 'SuspendedUser', 'status' => 'suspended']);

    $response = $this->actingAs($admin)->get(route('admin.users.index', ['status' => 'suspended']));

    $response->assertSee('SuspendedUser');
    $response->assertDontSee('ActiveUser');
});

test('a regular user is forbidden from every user-management route', function () {
    $user = makeUser();
    $target = makeUser();

    $this->actingAs($user)->get(route('admin.users.index'))->assertForbidden();
    $this->actingAs($user)->get(route('admin.users.create'))->assertForbidden();
    $this->actingAs($user)->post(route('admin.users.store'), [])->assertForbidden();
    $this->actingAs($user)->get(route('admin.users.edit', $target))->assertForbidden();
});
