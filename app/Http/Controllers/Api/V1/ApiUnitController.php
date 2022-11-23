<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\UnitType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\v1\UnitTypeResource;

class ApiUnitController extends Controller
{

    /**
     * @OA\Post(
     *     path="/api/v1/get-unit-types",
     *     summary="Get unit types",
     *     security={{"sanctum": {}}},
     *     tags={"Unit"},
     *       @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  required={"unit_type_id"},
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
     *         response=401,
     *         description="Unauthenticated",
     *          @OA\MediaType(
     *             mediaType="application/json",
     *          )
     *     ),
     * )
     */
    public function getUnitTypes(Request $request)
    {
        if ($request->exists('unit_type_id') && $request->has('unit_type_id')) {
            $unit_types = UnitType::authUnitTypesAllForApi($request->get('unit_type_id'));
        } else {
            $unit_types = UnitType::authUnitTypesAllForApi();
        }

        return UnitTypeResource::collection($unit_types);
    }
}
