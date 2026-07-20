<?php

namespace App\Http\Controllers\Api\V1;

use App\Helper\V1\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SendOtpRequest;
use App\Http\Requests\Auth\StoreOtpAuthenticationRequest;
use App\Http\Requests\Auth\UpdateOtpAuthenticationRequest;
use App\Http\Requests\Auth\VerifyOtpRequest;
use App\Models\OtpAuthentication;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;

class OtpAuthenticationController extends Controller
{

    public function __construct(private AuthService $authService)
    {
    }


    /**
     * send email for authentication.
     * Store a newly created email in storage & OTP sent to your email
     * @unauthenticated
     */
    public function store(SendOtpRequest $request): JsonResponse
    {
        $validated = $request->validated();
        try {
            $mailAndOtpExpirationDate = $this->authService->registerOtpEmail($validated['email']);

            return ApiResponse::success($mailAndOtpExpirationDate, 'email stored successfully & OTP sent to your email', 201);
            // return ApiResponse::success(null , 'email stored successfully' , 201);
        } catch (\Exception $e) {
            return ApiResponse::error(null, $e->getMessage(), 500);
        }
    }

    /**
     * verify otp to authenticate user.
     * login or register the user via otp 
     * @unauthenticated
     */
    public function verify(VerifyOtpRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $response = $this->authService->verifyUser($validated['email'], $validated['otp']);
        return ApiResponse::response($response['data'], $response['message'], $response['code']);

    }

}
