<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\CompanyResource;

class ApiCompanyController extends Controller
{
/**
 * @OA\Post(
 *     path="/api/v1/get-companies",
 *     summary="Get companies list",
 *     security={{"sanctum": {}}},
 *     tags={"Company"},
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
    public function getCompanies()
    {
        return CompanyResource::collection(resolve('authCompaniesResources'));
    }
}
