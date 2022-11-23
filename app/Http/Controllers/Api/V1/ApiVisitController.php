<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use App\Models\Visit;
use App\Models\CompanyUnit;
use Illuminate\Http\Request;
use App\Models\VisitObjective;
use App\Http\Controllers\Controller;
use App\Http\Resources\v1\VisitResource;
use App\Http\Resources\v1\VisitorResource;
use App\Http\Resources\v1\VisitObjectiveResource;

class ApiVisitController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/v1/get-visitors",
     *     summary="Get visitors list",
     *     security={{"sanctum": {}}},
     *     tags={"Visit"},
     *
     *       @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  required={"company_unit_id"},
     *                  @OA\Property(
     *                     property="company_unit_id",
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
    public function getVisitors(Request $request)
    {
        $request->validate([
            'company_unit_id' => 'required|integer|gt:0',
        ]);

        return VisitorResource::collection(User::unitVisitors($request));
    }


    /**
     * @OA\Post(
     *     path="/api/v1/get-visits",
     *     summary="Get visit list",
     *     security={{"sanctum": {}}},
     *     tags={"Visit"},
     *
     *       @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  required={"date_for"},
     *                  @OA\Property(
     *                     property="date_for",
     *                     type="date"
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
    public function getVisits(Request $request)
    {
        $request->validate([
            'date_for' => 'required|date_format:"Y-m-d"',
        ]);

        return VisitResource::collection(Visit::getVisits($request));
    }

    /**
     * @OA\Post(
     *     path="/api/v1/visit-details",
     *     summary="Get visit details",
     *     security={{"sanctum": {}}},
     *     tags={"Visit"},
     *
     *       @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  required={"id"},
     *                  @OA\Property(
     *                     property="id",
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
    public function visitDetails(Request $request)
    {
        $request->validate([
            'date_for' => 'required|integer|gt:0',
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/visit-objectives",
     *     summary="Get visit objectives",
     *     security={{"sanctum": {}}},
     *     tags={"Visit"},
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
    public function visitObjectives(Request $request)
    {
        $request->validate([
            'company_id' => 'required|integer|gt:0',
        ]);

        return VisitObjectiveResource::collection(VisitObjective::getTitles($request));
    }
}
