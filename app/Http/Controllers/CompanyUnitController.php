<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\CompanyUnit;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Throwable;

class CompanyUnitController extends Controller
{
    public function tag(Request $request)
    {
        try {
            // Validate request data.
            $validator = Validator::make(
                $request->all(),
                [
                    'unit_id' => 'required|numeric|gt:0',
                    'company_id' => [
                        'required',
                        'numeric',
                        'gt:0',
                        function ($attribute, $value, $fail) {
                            if (CompanyUnit::where($attribute, $value)
                                ->where('unit_id', request()->get('unit_id'))
                                ->exists()
                            ) {
                                $fail("Unit is already taged under this company.");
                            }
                        },
                    ],
                    'zone_id' => 'required|numeric|gt:0',
                    'area_id' => 'nullable|numeric|gt:0',
                    'dealer_id' => 'nullable|numeric',
                    'is_dealer' => 'numeric',
                ],
                [
                    'unit_id.gt' => 'No unit is selected',
                    'company_id.gt' => 'No company is selected',
                    'zone_id.gt' => 'No zone is selected',
                    'area_id.gt' => 'Invalid area is selected',
                    'dealer_id.gt' => 'Invalid dealer is selected',
                ]
            );

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator, 'tag')
                    ->withInput();
            }

            //$validated = $validator->safe()->only(['unit_id', 'company_id']);
            $validated = $validator->safe()->except(['is_dealer']);

            //$validated = $validator->validated();

            if (!isset($validated['area_id'])) {
                $validated['area_id'] = null;
            }

            if (!isset($validated['dealer_id'])) {
                $validated['dealer_id'] = null;
            }

            // Save into database.
            CompanyUnit::create($validated);

            // Return response.
            return back()->with('flash_success', 'Tagged!');
        } catch (Throwable $th) {
            // Return error message if there is any.
            return response()
                ->json([
                    'message' => 'Something went wrong!',
                    'error' => [$th->getMessage()],
                ]);
        }
    }

    /**
     * Edit tagging options.
     *
     * @param int $companyId
     * @param int $unitId
     */
    public function edit(int $companyId, int $unitId)
    {
        $companyUnit = CompanyUnit::where('company_id', $companyId)
            ->where('unit_id', $unitId)
            ->first();

        return view('company-units.edit', compact('companyUnit'));
    }

    /**
     * Untag a tagged unit.
     *
     * @param  int  $companyId
     * @param  int  $unitId
     */
    public function untag(int $companyId, int $unitId)
    {
        $companyUnit = CompanyUnit::where('company_id', $companyId)
            ->where('unit_id', $unitId)
            ->first();

        try {
            // Untag this unit
            $companyUnit->delete();

            return redirect()->route('units.index', auth()->user()->company_id == $companyId ? null : $companyId)
                ->with('flash_success', 'Unit untagged successfully!');
        } catch (Throwable $th) {
            return response()->json([
                'message' => 'Something went wrong with untagging unit!',
                'errors' => [$th->getMessage()],
            ]);
        }
    }

    /**
     * Ajax Get units by company.
     */
    public function tagUnit()
    {
        $units = Unit::leftJoin('company_units', 'company_units.unit_id', 'units.id')
            ->where('company_units.unit_id', '<>', 'units.id')
            ->pluck('name', 'id');

        return $units;
    }

    /**
     * Ajax Get units by company.
     *
     * @param int $companyId
     * @return \Illuminate\Support\Collection
     */
    public function getUnitsByCompany(int $companyId)
    {
        $units = CompanyUnit::leftJoin('units', 'units.id', 'company_units.unit_id')
            ->where('company_id', $companyId)
            ->pluck('units.name', 'units.id');

        return $units;
    }
}
