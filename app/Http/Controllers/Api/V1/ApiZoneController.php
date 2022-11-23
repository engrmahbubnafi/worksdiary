<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\ZoneResource;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ApiZoneController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/v1/get-zones",
     *     summary="Get Zones",
     *     security={{"sanctum": {}}},
     *     tags={"Zone"},
     *
     *      @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  required={"company_id"},
     *                  @OA\Property(
     *                     property="company_id",
     *                     type="integer"
     *                  ),
     *             ),
     *         ),
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *          @OA\MediaType(
     *             mediaType="application/json",
     *          )
     *     ),
     *      @OA\Response(
     *         response=422,
     *         description="Unprocessable Content",
     *          @OA\MediaType(
     *             mediaType="application/json",
     *          )
     *     ),
     * )
     */
    public function getZones(Request $request)
    {

        $company_id = null;

        if ($request->exists('company_id') && $request->has('company_id')) {

            $company_id = $request->get('company_id');

            $authCompanies = app('authCompanies');

            $request->validate([
                'numeric',
                'company_id' => [function ($attribute, $value, $fail) use ($authCompanies) {
                    if (!$authCompanies->has($value)) {
                        $fail("Unauthorize access.");
                    }
                }],
            ]);
        }

        $responseData = Zone::getZones($request, $company_id);

        return ZoneResource::collection($responseData);

    }
}
