<?php

namespace App\Http\Controllers\Api\V1;

use App\Events\OtpSendingEvent;
use App\Http\Controllers\Controller;
use App\Models\EmptyObj;
use App\Models\OTP;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ResetPasswordController extends Controller
{
    // Send OTP.

    /**
     * @OA\Post(
     *      path="/api/v1/send-otp",
     *      summary="Send OTP to email or mobile",
     *      tags={"Auth"},
     *      @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="username",
     *                     type="string",
     *                 ),
     *                 example={"username": "abc@bluebees.ai"}
     *             ),
     *         ),
     *     ),
     *      @OA\Response(
     *         response=200,
     *         description="OK",
     *          @OA\MediaType(
     *             mediaType="application/json",
     *          ),
     *      ),
     *      @OA\Response(
     *         response=422,
     *         description="Unprocessable Content",
     *          @OA\MediaType(
     *             mediaType="application/json",
     *          )
     *     ),
     * )
     */

    public function sendOtp(Request $request, Otp $otp)
    {
        $request->validate([
            'username' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    if (!is_numeric($value)
                        &&
                        !filter_var($value, FILTER_VALIDATE_EMAIL)
                    ) {
                        $fail(":attribute should email or mobile");
                    }
                },
                function ($attribute, $value, $fail) {
                    if (!User::where('email', $value)
                        ->orWhere('mobile', $value)
                        ->exists()) {
                        $fail("Your :attribute is not found!");
                    }
                }],
        ]);

        if (filter_var($request['username'], FILTER_VALIDATE_EMAIL)) {
            $usernameType = 'email';
        } else {
            $usernameType = 'mobile';
        }

        try {

            $data = (new EmptyObj)->setRawAttributes([
                'username' => $request['username'],
                'username_type' => $usernameType,
                'otp' => mt_rand(100001, 999999),
            ]);

            $otp->refreshOtp($data, counter:true);

            OtpSendingEvent::dispatch($data);

            return response()->json([
                'message' => 'OTP sent successfully.',
                'errors' => [],
            ]);
        } catch (\Throwable$th) {
            return response()
                ->json([
                    'message' => 'Something wrong with sending OTP.',
                    'errors' => [$th->getMessage()],
                ], 422);
        }
    }

    // Verify OTP.

    /**
     * @OA\Post(
     *      path="/api/v1/verify-otp",
     *      summary="OTP verifing",
     *      tags={"Auth"},
     *      @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *
     *             @OA\Schema(
     *                  @OA\Property(
     *                     property="username",
     *                     type="string",
     *                  ),
     *                  @OA\Property(
     *                     property="otp",
     *                     type="string",
     *                  ),
     *                  example={"username": "abc@bluebees.ai", "otp": "123456"}
     *             ),
     *         ),
     *      ),
     *
     *      @OA\Response(
     *         response=200,
     *         description="OK",
     *          @OA\MediaType(
     *             mediaType="application/json",
     *          ),
     *      ),
     *
     *      @OA\Response(
     *         response=422,
     *         description="Unprocessable Content",
     *          @OA\MediaType(
     *             mediaType="application/json",
     *          ),
     *      ),
     * )
     */

    public function verifyOtp(Request $request, Otp $otp)
    {
        $data = $request->all();

        $request->validate([
            'username' => [
                'required',
                'string',
                // Validate if the username is email or mobile.
                function ($attribute, $value, $fail) {
                    if (!is_numeric($value)
                        &&
                        !filter_var($value, FILTER_VALIDATE_EMAIL)
                    ) {
                        $fail(":attribute should email or mobile");
                    }
                },
                // Validate whether the username is in the database.
                function ($attribute, $value, $fail) {
                    if (!User::where('email', $value)
                        ->orWhere('mobile', $value)
                        ->exists()) {
                        $fail("Your :attribute is not found!");
                    }
                }],
            'otp' => [
                'required',
                'numeric',
                // Validate whether the OTP is valid.
                function ($attribute, $value, $fail) use ($data) {
                    if (
                        !Otp::where($attribute, $value)
                        ->where('username', $data['username'])
                        ->exists()
                    ) {
                        $fail(":attribute is not valid.");
                    }
                },
                // Validate whether the OTP is expired.
                function ($attribute, $value, $fail) use ($data) {
                    if (
                        Otp::where($attribute, $value)
                        ->where('username', $data['username'])
                        ->where('updated_at', '<', now()->subSeconds(config('auth.password_timeout', 10800)))
                        ->exists()
                    ) {
                        $fail(":attribute is expired.");
                    }
                },
            ],
        ]);

        try {
            // Return successful OTP verification message and generate a unique token if there is no other error.
            return response()->json([
                'message' => 'otp is verified.',
                'token' => $otp->tokenGenerete($data['username']),
                'errors' => [],
            ]);
        } catch (\Throwable$th) {
            // Or, return error message.
            return response()->json([
                'message' => 'Something wrong for saving OTP.',
                'errors' => [$th->getMessage()],
            ]);
        }
    }

    // Reset password.

    /**
     * @OA\Post(
     *      path="/api/v1/reset-password",
     *      summary="Password reseting",
     *      tags={"Auth"},
     *      @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *
     *             @OA\Schema(
     *                  @OA\Property(
     *                     property="token",
     *                     type="string",
     *                  ),
     *                  @OA\Property(
     *                     property="password",
     *                     type="string",
     *                  ),
     *                  @OA\Property(
     *                     property="password_confirmation",
     *                     type="string",
     *                  ),
     *              ),
     *          ),
     *      ),
     *
     *      @OA\Response(
     *         response=200,
     *         description="OK",
     *
     *          @OA\MediaType(
     *             mediaType="application/json",
     *          ),
     *      ),
     *
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Content",
     *
     *          @OA\MediaType(
     *             mediaType="application/json",
     *          ),
     *      ),
     * )
     */

    public function resetPassword(Request $request, Otp $otp)
    {
        $validated = $request->validate([
            'token' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (
                        !Otp::where($attribute, $value)
                        ->exists()
                    ) {
                        $fail(":attribute is not valid.");
                    }
                },
            ],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        try {
            $otpObj = $otp->getUsernameByToken($validated['token']);

            User::where('email', $otpObj->username)
                ->update([
                    'password' => Hash::make($validated['password']),
                ]);

            $otp->refreshOtp($otpObj);

            return response()->json([
                'message' => 'password updated successfully.',
                'errors' => [],
            ]);

        } catch (\Throwable$th) {
            return response()->json([
                'message' => 'Something wrong for updating password.',
                'errors' => [$th->getMessage()],
            ]);
        }
    }
}
