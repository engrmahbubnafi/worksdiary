<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\SourceDetailResource;
use App\Models\SourceDetail;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class ApiSourceController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/v1/get-sources",
     *     summary="Get Souces",
     *     security={{"sanctum": {}}},
     *     tags={"Source"},
     *
     *    @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *
     *             @OA\Schema(
     *                  required={"compare_value"},
     *                  @OA\Property(
     *                     property="compare_value",
     *                     type="integer"
     *                  ),
     *                  @OA\Property(
     *                     property="reference_value",
     *                     type="integer"
     *                  )
     *             ),
     *         ),
     *      ),
     *
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
    public function getSources(Request $request)
    {

        $request->validate([
            'compare_value' => 'required|integer|gt:0',
        ]);

        $source_id = $request->get('compare_value');

        $reference_value = null;
        if ($request->exists('reference_value') && $request->has('reference_value')) {
            $reference_value = $request->get('reference_value');
        }

        $responseData = SourceDetail::getSourceDetailsBySourceId($source_id, $reference_value);

        return ($responseData instanceof Collection) ?
            SourceDetailResource::collection($responseData) :
            new SourceDetailResource($responseData);
    }
}
