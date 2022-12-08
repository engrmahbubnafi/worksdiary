<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Throwable;

class ApiUserController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/v1/user/details",
     *     summary="Get current user information",
     *     security={{"sanctum": {}}},
     *     tags={"User"},
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *          @OA\MediaType(
     *             mediaType="application/json",
     *          )
     *     ),
     *      @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *          @OA\MediaType(
     *             mediaType="application/json",
     *          )
     *     ),
     * )
     */
    public function details(Request $request)
    {
        if ($request->exists('user_id') && $request->has('user_id')) {
            $user = User::findOrFail($request->get('user_id'));
        } else {
            $user = $request->user();
        }

        $user->load('company');

        return new UserResource($user);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/users/edit/mobile",
     *     summary="Updates user mobile",
     *     security={{"sanctum": {}}},
     *     tags={"User"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  required={"mobile"},
     *                  @OA\Property(
     *                     property="mobile",
     *                     type="string",
     *                  ),
     *              ),
     *          ),
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\MediaType(
     *            mediaType="application/json",
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *         @OA\MediaType(
     *            mediaType="application/json",
     *         )
     *     )
     * )
     */
    public function mobileEdit(Request $request)
    {
        $validated = $request->validate([
            'mobile' => 'required|numeric|digits:11',
        ]);

        // Get requested user
        $user = $request->user();


        try {
            // Update mobile
            $user->update(['mobile' => $validated['mobile']]);

            return new UserResource($user);
        } catch (Throwable $th) {

            return response()->json([
                'message' => 'Something went wrong updating data!',
                'error' => [$th->getMessage()],
            ]);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/v1/users/edit/avatar",
     *     summary="Updates user avatar",
     *     security={{"sanctum": {}}},
     *     tags={"User"},
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                  required={"avatar"},
     *                  @OA\Property(
     *                     description="Avatar file to upload",
     *                     property="file",
     *                     type="file",
     *                  ),
     *              ),
     *          ),
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\MediaType(
     *            mediaType="application/json",
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *         @OA\MediaType(
     *            mediaType="application/json",
     *         )
     *     )
     * )
     */
    public function avatarEdit(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image',
        ]);

        // Get requested user
        $user = $request->user();

        try {
            // Process the avatar if avatar is uploaded
            $uploadedAvatar = $request->file('avatar');
            $imageName = Str::uuid() . '.' . $uploadedAvatar->getClientOriginalExtension();
            $imageDirectory = 'avatar' . DIRECTORY_SEPARATOR . $user->id;
            $imagePath = $imageDirectory . DIRECTORY_SEPARATOR . $imageName;
            $storagePathIntervImg = storage_path('app' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR);
            $fullPath = $storagePathIntervImg . $imagePath;

            // Delete existing avatar.
            if (file_exists($storagePathIntervImg . $user->avatar)) {
                File::delete($storagePathIntervImg . $user->avatar);
            }

            Storage::makeDirectory($imageDirectory);

            Image::make($uploadedAvatar)
                ->resize(300, 300, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->resizeCanvas(300, 300, 'center', false, null)
                ->save($fullPath);

            // Update database with processed avatar
            $user->update(['avatar' => $imagePath]);

            return new UserResource($user);
        } catch (Throwable $th) {

            return response()->json([
                'message' => 'Something went wrong updating data!',
                'error' => [$th->getMessage()],
            ]);
        }
    }
}
