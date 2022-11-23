<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\AllPrivateMethodsForUnitController;
use App\Http\Requests\Unit\StoreUnitRequest;
use App\Http\Requests\Unit\UpdateUnitRequest;
use App\Http\Resources\UnitResource;
use App\Models\Unit;
use Illuminate\Http\Request;
use Throwable;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class UnitController extends Controller
{
    use AllPrivateMethodsForUnitController;

    /**
     * Display a listing of the resource.
     *
     * @param Yajra\DataTables\Html\Builder $builder
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Builder $builder, $companyId = null)
    {
        // dump(request()->get('name'));
        $result = $this->checkValidity($companyId);

        if ($result) {
            return $result;
        }

        if ($companyId) {
            return $this->indexWithCompanyTag($request, $builder, $companyId);
        } else {
            return $this->indexWithoutCompanyTag($request, $builder);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param int $companyId
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('units.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\Unit\StoreUnitRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUnitRequest $request)
    {
        try {
            // Save validated data
            Unit::create($request->validated());

            return redirect()->route('units.index')
                ->with('flash_success', 'Unit created successfully!');
        } catch (Throwable $th) {
            return response()->json([
                'message' => 'Something went wrong storing data!',
                'errors' => [$th->getMessage()],
            ]);
        }
    }

    /**
     * Show unit details.
     *
     * @param int $unitId
     */
    public function show(int $unitId)
    {
        $unit = Unit::join('unit_types', 'unit_types.id', 'units.unit_type_id')
            ->join('districts', 'districts.id', 'units.district_id')
            ->join('upazilas', 'upazilas.id', 'units.upazila_id')
            ->select(
                'units.id',
                'units.name',
                'units.code',
                'units.owner',
                'units.as_dealer',
                'units.mobile',
                'units.address',
                'units.latitude',
                'units.longitude',
                'units.status',
                'unit_types.name as unit_type_name',
                'districts.name as district_name',
                'upazilas.name as upazila_name'
            )
            ->where('units.id', $unitId)
            ->first();

        return new UnitResource($unit);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Unit $unit
     * @return \Illuminate\Http\Response
     */
    public function edit(Unit $unit)
    {
        return view('units.edit', compact('unit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\Unit\UpdateUnitRequest $request
     * @param  Unit $unit
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUnitRequest $request, Unit $unit)
    {
        try {
            $validatedData = $request->validated();

            if (!$request->exists('as_dealer')) {
                $validatedData['as_dealer'] = 0;
            }

            // Update validated data
            $unit->update($validatedData);

            return redirect()->route('units.index')
                ->with('flash_success', 'Unit updated successfully!');
        } catch (Throwable $th) {
            return response()->json([
                'message' => 'Something went wrong with updating unit!',
                'errors' => [$th->getMessage()],
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Unit $unit)
    {
        try {
            // Delete this unit
            $unit->delete();

            return redirect()->route('units.index')
                ->with('flash_success', 'Unit deleted successfully!');
        } catch (Throwable $th) {
            return response()->json([
                'message' => 'Something went wrong with deleting unit!',
                'errors' => [$th->getMessage()],
            ]);
        }
    }

    /**
     *  Ajax: get unit by mobile no and unit type and companyId
     *
     * @param Request $request
     * @return void
     */
    public function getAndChecckUnit(Request $request)
    {
        return collect();
        if ($request->exists('mobile') && $request->exists('unit_type_id')) {
        }
    }

    /**
     * Ajax: get unit list by search params
     *
     * @return void
     */
    public function getSearchUnitList(Request $request)
    {
        if ($request->has('search_text')) {
            $searchText = addslashes(strtolower(trim($request['search_text'])));
            $request['search_text'] = $searchText;
            // $request['full_text_string'] = $this->returnSearchKeywordsWithPlus($searchText);
        }

        $request['unit_types'] = [];

        if ($request->exists('by_unit_id') && $request->has('by_unit_id')) {
            $request['by_unit_id'] = $request->get('by_unit_id');
            $request['unit_types'] = [Unit::where('id', $request['by_unit_id'])->value('unit_type_id')];
        } else {
            $request['unit_types'] = app('authUnitTypes')->keys()->all();
        }

        if ($request->exists('district_id') && $request->has('district_id')) {
            $request['district_id'] = $request->get('district_id');
        }

        if ($request->exists('company_id') && $request->has('company_id')) {
            $request['company_id'] = $request->get('company_id');
        }

        return Unit::getUnitListBySearchParam($request);
    }

    /**
     * Ajax: get unit list by company id or unit details by unit id
     *
     * @return void
     */
    public function getSearchCompanyUnits(Request $request)
    {
        return Unit::getUnitsByCompanyOrId($request);
    }
}
