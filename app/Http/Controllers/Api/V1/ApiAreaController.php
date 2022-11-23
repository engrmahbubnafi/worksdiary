<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\AreaResource;
use App\Models\Area;
use Illuminate\Http\Request;

class ApiAreaController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/v1/get-areas",
     *     summary="Get Areas",
     *     security={{"sanctum": {}}},
     *     tags={"Area"},
     *
     *      @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  required={"zone_id","unit_type_id"},
     *                  @OA\Property(
     *                     property="zone_id",
     *                     type="integer"
     *                  ),
     *                  @OA\Property(
     *                     property="unit_type_id",
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
    public function getAreas(Request $request)
    {
        $request->validate([
            'zone_id' => 'required|integer|gt:0',
            'unit_type_id' => 'required|integer|gt:0',
        ]);
        $responseData = Area::getAreasByZone($request->zone_id, $request->unit_type_id);
        return AreaResource::collection($responseData);
    }
}
