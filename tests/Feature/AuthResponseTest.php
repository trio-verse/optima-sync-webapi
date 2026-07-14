<?php

use App\Mail\OtpMail;
use App\Models\OtpAuthentication;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;

uses(RefreshDatabase::class);

test('register email queues otp and returns 201', function () {

    // Arrange
    Mail::fake();
    $email = 'test@test.com';

    // Act
    $response = $this->postJson('/api/v1/register-email', ['email' => $email]);

    // Assert
    $response->assertStatus(201)
        ->assertJsonStructure([
            'success',
            'message',
            'data' => ['email'],
        ])
        ->assertJson([
            'success' => true,
            'message' => 'email stored successfully & OTP sent to your email',
            'data' => [
                'email' => $email,
            ]
        ]);

    expect($response->json('data.email'))->toBe($email);
    expect(OtpAuthentication::where('email', $email)->exists())->toBeTrue();
});

test('verify otp returns token and login the user', function () {
    Mail::fake();

    $email = 'test@test.com';

    $this->postJson('/api/v1/register-email', ['email' => $email]);

    // capture the OTP directly from the queued OtpMail
    $otp = null;
    Mail::assertQueued(OtpMail::class, function (OtpMail $mail) use (&$otp) {
        $otp = (new ReflectionProperty(OtpMail::class, 'otp'))->getValue($mail);
        return true;
    });

    $response = $this->postJson('/api/v1/verify-otp', [
        'email' => $email,
        'otp' => $otp,
    ]);

    $response->assertStatus(201)
        ->assertJsonStructure([
            'message',
            'data' => ['token'],
        ]);

    $response->assertJsonPath('message', 'User created successfully');
    expect($response->json('data.token'))->not->toBeNull();
});

test('full auth flow registers then verifies and returns a token', function () {
    Mail::fake();

    $email = 'flow@test.com';

    // step 1: request OTP
    $register = $this->postJson('/api/v1/register-email', ['email' => $email]);
    $register->assertStatus(201);

    // extract OTP from the queued OtpMail
    $otp = null;
    Mail::assertQueued(OtpMail::class, function (OtpMail $mail) use (&$otp) {
        $otp = (new ReflectionProperty(OtpMail::class, 'otp'))->getValue($mail);
        return true;
    });

    expect($otp)->not->toBeNull();

    // step 2: verify OTP and obtain login token
    $verify = $this->postJson('/api/v1/verify-otp', [
        'email' => $email,
        'otp' => $otp,
    ]);

    $verify->assertStatus(201)
        ->assertJsonPath('message', 'User created successfully');

    $token = $verify->json('data.token');
    expect($token)->not->toBeNull();

    // the token works for authenticated requests
    $this->withHeader('Authorization', 'Bearer ' . $token)
        ->getJson('/api/user')
        ->assertStatus(200);
});

test('verify otp fails with an invalid code', function () {
    Mail::fake();

    $email = 'invalid@test.com';

    $this->postJson('/api/v1/register-email', ['email' => $email]);

    $response = $this->postJson('/api/v1/verify-otp', [
        'email' => $email,
        'otp' => '000000',
    ]);

    $response->assertStatus(422);
});
