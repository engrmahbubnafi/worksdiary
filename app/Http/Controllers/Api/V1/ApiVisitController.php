<?php

namespace App\Http\Controllers\Api\V1;

use Throwable;
use App\Models\User;
use App\Models\Visit;
use App\Enum\VisitStatus;
use App\Models\CompanyUnit;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Models\VisitObjective;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\v1\VisitResource;
use App\Http\Resources\V1\StatusResources;
use App\Http\Resources\v1\VisitorResource;
use App\Http\Requests\Visit\StoreVisitRequest;
use App\Http\Resources\V1\ObjectBuilderResource;
use App\Http\Resources\v1\VisitObjectiveResource;
use App\Http\Resources\v1\VisitResourceCollection;

class ApiVisitController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/v1/get-visit-status",
     *     summary="Get visit status list",
     *     security={{"sanctum": {}}},
     *     tags={"Visit"}, 
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
    public function getVisitStatus(Request $request)
    {
        return ObjectBuilderResource::collection(VisitStatus::cases());
    }

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
     *                     property="company_id",
     *                     type="integer",
     *                  ),
     *                  @OA\Property(
     *                     property="date_for",
     *                     type="string",
     *                     example="2022-11-25|2022-12-01"
     *                  ),
     *                  @OA\Property(
     *                     property="status",
     *                     type="string",
     *                     example="waiting_for_approval"
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

        if (!$request->has('company_id')) {
            $request->merge(['company_id' => $request->user()->company_id]);
        }


        $request->validate([
            'company_id' => 'required|integer|gt:0',
            'date_for' => 'required|string',
            'status' => 'sometimes',
        ]);

        $pageNo = $request->get('page') ?? 0;

        $response = new VisitResourceCollection(
            Visit::getVisitsEloquentObj($request)
                ->orderBy('visits.priority')
                ->paginate(config('conf.api_pagination_limit'))
        );

        $onging = null;
        $summery = collect();

        if ($pageNo < 2) {
            $onlyDateForRequest =  clone $request;

            $summery =  Visit::getVisitsEloquentObjWithOutSelect($onlyDateForRequest->replace(['status' => null]))
                ->select(
                    'visits.status',
                    DB::raw('COUNT(visits.id) as total')
                )
                ->groupBy('visits.status')
                ->get();

            $onging = Visit::getVisitsEloquentObj($onlyDateForRequest)
                ->where('visits.status', VisitStatus::OnGoing->value)
                ->first();
        }

        if ($pageNo < 2) {
            $response->additional(
                [
                    'ongoing' =>  $onging ? new VisitResource($onging) : null,
                    'summery' => [
                        'total' => $summery->sum('total'),
                        'data' => StatusResources::collection($summery)
                    ]
                ]
            );
        }

        return $response;
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

    /**
     * @OA\Post(
     *     path="/api/v1/visit-create",
     *     summary="Visit Create",
     *     security={{"sanctum": {}}},
     *     tags={"Visit"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  required={"objectives","unit_type_id","company_unit_id","date_for","assign_to"},
     *                  @OA\Property(
     *                      property="objectives",
     *                      description="Visit Objective",
     *                      type="array",
     *                      collectionFormat="multi",
     *                      @OA\Items(type="string", format="objective"),
     *                  ),
     *                  @OA\Property(
     *                     property="unit_type_id",
     *                     type="integer",
     *                  ),
     *                  @OA\Property(
     *                     property="company_unit_id",
     *                     type="integer",
     *                  ),
     *                  @OA\Property(
     *                     property="date_for",
     *                     type="date",
     *                  ),
     *                  @OA\Property(
     *                     property="assign_to",
     *                     type="integer",
     *                  ),
     *                  @OA\Property(
     *                     property="visit_note",
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
    public function visitCreate(StoreVisitRequest $request)
    {
        $validated = $request->validated();

        $companyUnit = CompanyUnit::where('id', $validated['company_unit_id'])
            ->select('unit_id', 'company_id', 'zone_id')
            ->first();

        try {
            $data = array_merge($validated, $companyUnit->toArray());

            $data['name'] = Arr::join($data['objectives'], ',');

            if (!empty($data['assign_to'])) {
                $data['status'] = VisitStatus::Approved->value; //Though assine tag is must, so as a supervisor, he is the only approver for that visit
            } else {
                $data['assign_to'] = $request->user()->id;
                if ($request->user()->supervisor_id) {
                    $data['status'] = VisitStatus::WaitingForApproval->value;
                } else {
                    $data['status'] = VisitStatus::Approved->value; //he has no supervisor
                }
            }

            Visit::create(Arr::except($data, ['objectives']));

            // return new VisitResource(Visit::getVisit($request->merge(['id' => $visit->id])));
            return response()->json([
                'message' => 'Visit created successfully'
            ]);
        } catch (Throwable $th) {

            return response()->json([
                'message' => 'Something went wrong creating data!',
                'error' => [$th->getMessage()],
            ]);
        }
    }
}
