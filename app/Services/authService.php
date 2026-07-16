<?php

namespace App\Services;

use App\Mail\OtpMail;
use App\Models\OtpAuthentication;
use App\Models\User;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

class AuthService
{

    public string $mail;
    private string $otp;
    public int $expiresMinutes;

    public function __construct(private UserService $userService)
    {
    }


    // public methods
    public function registerOtpEmail(string $email): array
    {
        $this->storeEmail($email);
        return $this->sendOtp($email);
    }

    // public function verifyUser(string $email, string $code): array
    // {
    //     if (!$this->verifyOtp($email, $code))
    //         return [
    //             'code' => 422,
    //             'message' => 'Invalid or expired OTP'
    //         ];

    //     $user = $this->userService->findOrFail($email);

    //     // the user not exists/register in the system before
    //     if (!$user) {
    //         $user = $this->userService->createUser(['email' => $email]);
    //         $token = $user->createToken('erp-auth-token')->plainTextToken;
    //         return [
    //             'code' => 201,
    //             'message' => 'User created successfully',
    //             'data' => [
    //                 // 'user' => $user,
    //                 'token' => $token
    //             ]
    //         ];
    //     }

    //     // the user registered before
    //     $token = $user->createToken('erp-auth-token')->plainTextToken;
    //     return [
    //         'code' => 200,
    //         'message' => 'User verified successfully',
    //         'data' => [
    //             // 'user' => $user,
    //             'token' => $token
    //         ]
    //     ];
    // }



    public function verifyUser(string $email, string $code): array
    {
        $message = '';
        $statusCode = 200;

        if (!$this->verifyOtp($email, $code)) {
            return [
                'code' => 422,
                'message' => 'Invalid or expired OTP',
                'data' => null
            ];
        }

        $user = $this->userService->findOrFail($email);

        // the user not exists/register in the system before
        if (!$user) {
            $user = $this->userService->createUser(['email' => $email]);
            $token = $user->createToken('erp-auth-token')->plainTextToken;
            $message = "User created successfully";
            $statusCode = 201;
        } else {
            // the user registered before
            $user->tokens()->delete();
            $token = $user->createToken('erp-auth-token')->plainTextToken;
            $message = "User verified successfully";
            $statusCode = 200;
        }

        return [
            'code' => $statusCode,
            'message' => $message,
            'data' => [
                // 'user' => $user,
                'token' => $token
            ]
        ];
    }


    // private methods
    private function storeEmail(string $email): void
    {
        $auth = OtpAuthentication::where('email', $email)->first();

        if (!$auth)
            $auth = OtpAuthentication::create(['email' => $email]);
        else {
            // delete the old rows
            OtpAuthentication::where('email', $email)->delete();
            $auth = OtpAuthentication::create(['email' => $email]);
        }
    }

    // send otp to email
    private function sendOtp(string $email): array
    {
        $otp = $this->generateOtp();
        $expiresAt = now()->addMinutes(5);

        $this->saveOtp($email, $otp, 5);

        Mail::to($email)->send(new OtpMail($otp));

        return [
            'email' => $email,
            // 'expires_at' => $expiresAt
        ];
    }


    private function generateOtp(): string
    {
        return (string) rand(100000, 999999);
    }
    private function saveOtp(string $mail, string $otp, int $expiresMinutes): void
    {
        $auth = OtpAuthentication::where('email', $mail)->first();
        $auth->otp = $otp;
        $auth->expires_at = now()->addMinutes($expiresMinutes);
        $auth->save();
    }

    // verify otp
    private function verifyOtp(string $email, string $code): bool
    {
        $otpRecord = OtpAuthentication::where('email', $email)
            ->latest()
            ->first();

        if (!$otpRecord) {
            // throw new Exception('Invalid or expired OTP.', 422);
            return false;
        }

        if (Carbon::now()->isAfter($otpRecord->expires_at)) {
            // throw new Exception('OTP has expired.', 422);
            return false;
        }

        if ($otpRecord->otp !== $code) {
            // throw new Exception('Invalid OTP code.', 422);
            return false;

        }
        return true;
    }

}
