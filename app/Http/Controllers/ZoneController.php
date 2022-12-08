<?php

namespace App\Http\Controllers;

use App\Http\Requests\Zone\StoreZoneRequest;
use App\Http\Requests\Zone\UpdateZoneRequest;
use App\Models\Company;
use App\Models\Zone;
use App\Transformers\ZoneTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Throwable;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Column;

class ZoneController extends Controller
{

    /**
     * Get zones
     *
     * @return object
     */
    private function getZoneData($companyId): object
    {
        $zones = Zone::leftJoin('companies', 'zones.company_id', 'companies.id')
            ->select(
                'zones.*',
                'companies.name as company_name',
            )
            ->where('zones.company_id', $companyId)
            ->get();

        return DataTables::of($zones)
            ->setTransformer(new ZoneTransformer)
            ->toJson();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder, $companyId = null)
    {
        if (!$companyId) {
            $companyId = auth()->user()->company_id;
        }

        $result = $this->checkValidity($companyId);

        if ($result) {
            return $result;
        }

        // Get zones if ajax request
        if (request()->ajax()) {
            return $this->getZoneData($companyId);
        }

        $lists = Str::generateCompanyTab(routeName:'zones.index');

        // Build columns
        $html = $builder
            ->columns([
                Column::make('id')
                    ->visible(false),

                Column::make('name')
                    ->title('Name')
                    ->addClass('text-center')
                    ->searchable(true),

                Column::make('status')
                    ->title('Status')
                    ->addClass('text-center'),

                Column::make('action')
                    ->title('Action')
                    ->addClass('text-center')
                    ->orderable(false)
                    ->searchable(false),
            ])
            ->parameters([
                'pageLength' => 25,
                'drawCallback' => 'function() {
                    KTMenu.createInstances();
                    handleSearchDatatable();
                }',
            ]);

        return view('zones.index', compact('html', 'lists', 'companyId'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($companyId = null)
    {
        if (!$companyId) {
            $companyId = auth()->user()->company_id;
        }

        $result = $this->checkValidity($companyId);

        if ($result) {
            return $result;
        }

        $lists = Str::generateCompanyTab(routeName:'zones.create');

        $currentCompany = $lists->where('id', $companyId)->first();

        return view('zones.create', compact('lists', 'companyId', 'currentCompany'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Zone\StoreZoneRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreZoneRequest $request, Company $company)
    {
        try {
            // Store validated data into variable
            $data = $request->validated();

            // Set this company ID
            $data['company_id'] = $company->id;

            // Store validated data
            Zone::create($data);

            return redirect()->route('zones.index', auth()->user()->company_id == $company->id ? null : $company->id)
                ->with('flash_success', "Zone created successfully!");
        } catch (Throwable $th) {
            return response()->json([
                'message' => 'Something went wrong storing data!',
                'errors' => [$th->getMessage()],
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Zone $zone
     * @return \Illuminate\Http\Response
     */
    public function show(Zone $zone)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Zone $zone
     * @return \Illuminate\Http\Response
     */
    public function edit($companyId, Zone $zone)
    {
        $result = $this->checkValidity($companyId);

        if ($result) {
            return $result;
        }

        $companiesObj = app('authCompanies');

        $currentCompany = $companiesObj->get($companyId);

        return view('zones.edit', compact('zone', 'companyId', 'currentCompany'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\Zone\UpdateZoneRequest $request
     * @param Zone $zone
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateZoneRequest $request, Company $company, Zone $zone)
    {
        try {
            $data = $request->validated();

            $data['company_id'] = $company->id;

            // Update validated request data.
            $zone->update($data);

            // Return success message.
            return redirect()->route('zones.index', auth()->user()->company_id == $company->id ? null : $company->id)
                ->with('flash_success', "Zone updated successfully!");
        } catch (Throwable $th) {
            // Return message with errors.
            return response()->json([
                'message' => 'Something went wrong storing data!',
                'errors' => [$th->getMessage()],
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Zone $zone
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company, Zone $zone)
    {
        try {
            // Delete the zone.
            $zone->delete();

            // Return success message.
            return redirect()->route('zones.index', auth()->user()->company_id == $company->id ? null : $company->id)
                ->with('flash_success', "Zone deleted successfully!");
        } catch (Throwable $th) {
            // Return message with errors.
            return response()->json([
                'message' => "Something went wrong!",
                'errors' => [$th->getMessage()],
            ]);
        }
    }

    /**
     * Ajax Get zones by company.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $companyId
     */
    public function getZonesByCompany(Request $request, int $companyId = 0)
    {
        $zones = Zone::getZones($request, $companyId);
        return $zones->pluck('name', 'id');
    }
}
