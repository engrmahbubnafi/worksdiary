<?php

namespace App\Http\Controllers\Api\V1;

use Throwable;
use App\Enum\VisitStatus;
use App\Models\CompanyUnit;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Models\EmergencyVisit;
use App\Enum\EmergencyVisitStatus;
use App\Models\EmergencyTaskImage;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\StatusResources;
use App\Http\Resources\v1\EmergencyTaskResourceCollection;

class ApiEmergencyVisitController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/v1/emergency-task-create",
     *     summary="Emergency Task Create",
     *     security={{"sanctum": {}}},
     *     tags={"Emergency Task"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  required={"objectives[]","unit_type_id","company_unit_id","date_for","assign_to"},
     *                  @OA\Property(
     *                      property="objectives[]",
     *                      description="Task Objective",
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
     *                     property="task_note",
     *                      description="Task Note",
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
    public function emergencyTaskCreate(Request $request)
    {
        $validated = $request->validate([
            'objectives' => 'required|array',
            'unit_type_id' => 'required|integer|exists:unit_types,id',
            'company_unit_id' => 'required|integer|exists:company_units,id',
            'date_for' => 'required|date',
            'assign_to' => 'required|integer',
        ]);

        $companyUnit = CompanyUnit::where('id', $validated['company_unit_id'])
            ->select('unit_id', 'company_id', 'zone_id')
            ->first();

        try {
            $data = array_merge($validated, $companyUnit->toArray());

            $data['name'] = Arr::join($data['objectives'], ',');
            $data['status'] = VisitStatus::WaitingForApproval->value;
            EmergencyVisit::create(Arr::except($data, ['objectives']));

            //return new VisitResource(EmergencyVisit::getVisit($request->merge(['id' => $visit->id])));
            return response()->json([
                'message' => 'Emergency task created successfully',

            ]);
        } catch (Throwable $th) {

            return response()->json([
                'message' => 'Something went wrong creating data!',
                'error' => [$th->getMessage()],
            ]);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/v1/get-emergency-tasks",
     *     summary="Get Emergency Tasks list",
     *     security={{"sanctum": {}}},
     *     tags={"Emergency Task"},
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
     *                     example="pending"
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
    public function getEmergencyTasks(Request $request)
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

        $response = new EmergencyTaskResourceCollection(
            EmergencyVisit::getVisitsEloquentObj($request)
                ->paginate(config('conf.api_pagination_limit'))
        );

        $onging = null;
        $summery = collect();

        if ($pageNo < 2) {
            $onlyDateForRequest =  clone $request;

            $summery =  EmergencyVisit::getVisitsEloquentObjWithOutSelect($onlyDateForRequest->replace(['status' => null]))
                ->select(
                    'emergency_tasks.status',
                    DB::raw('COUNT(emergency_tasks.id) as total')
                )
                ->groupBy('emergency_tasks.status')
                ->get();
        }

        if ($pageNo < 2) {
            $response->additional(
                [
                    'summery' => [
                        'total' => $summery->sum('total'),
                        'data' => StatusResources::collection($summery)
                    ]
                ]
            );
        }

        return $response;
    }
}
