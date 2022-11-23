<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\CompanyUnitResource;
use App\Models\CompanyUnit;
use Illuminate\Http\Request;

class ApiCompanyUnit extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/v1/get-company-units",
     *     summary="Get company list",
     *     security={{"sanctum": {}}},
     *     tags={"Unit"},
     *
     *       @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  required={"company_id"},
     *                  @OA\Property(
     *                     property="company_id",
     *                     type="integer"
     *                  ),
     *                  @OA\Property(
     *                     property="zone_id",
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
     *         response=401,
     *         description="Unauthenticated",
     *          @OA\MediaType(
     *             mediaType="application/json",
     *          )
     *     ),
     * )
     */
    public function getCompanyUnits(Request $request)
    {
        $request->validate([
            'company_id' => 'required|integer|gt:0',
        ]);

        return CompanyUnitResource::collection(CompanyUnit::list($request));
    }
}
