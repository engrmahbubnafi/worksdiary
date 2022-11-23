<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{

    /**
     * @OA\Post(
     *     path="/api/v1/login",
     *     summary="Get bearer token",
     *     description="Api Login",
     *     operationId="Login",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="email",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="device_name",
     *                     type="string"
     *                 ),
     *                 example={"email": "abc@bluebees.ai", "password": "secret", "device_name": "IPhone"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *          )
     *     ),
     *      @OA\Response(
     *         response=422,
     *         description="The provided credentials are incorrect.",
     *          @OA\MediaType(
     *             mediaType="application/json",
     *          )
     *     ),
     * )
     */

    public function login(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $tokenObj = $user->createToken($request->device_name);

        return [
            'error' => 0,
            'version' => config('app.api.version'),
            'id' => $tokenObj->accessToken->id,
            'token' => $tokenObj->plainTextToken,
        ];

    }

    /**
     * @OA\Post(
     *     path="/api/v1/logout",
     *     summary="Logout",
     *     description="Api Logout",
     *     operationId="Logout",
     *     security={{"sanctum": {}}},
     *     tags={"Auth"},
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *          )
     *     ),
     * )
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return [
            'message' => 'Successfully logged out.',
        ];
    }
}
