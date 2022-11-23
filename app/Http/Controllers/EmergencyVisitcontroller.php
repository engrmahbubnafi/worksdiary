<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\Zone;
use App\Models\Visit;
use App\Models\Company;
use App\Models\EmptyObj;
use App\Enum\VisitStatus;
use App\Models\CompanyUnit;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\EmergencyVisit;
use App\Models\VisitObjective;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Facades\DataTables;
use App\Transformers\EmergencyVisitTransformer;
use App\Http\Requests\EmergencyVisit\StoreEmergencyVisitRequest;
use App\Http\Requests\EmergencyVisit\UpdateEmergencyVisitRequest;

class EmergencyVisitController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @param \Yajra\DataTables\Html\Builder $builder
     * @param int $companyId
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Builder $builder, int $companyId = null)
    {
        // Set user's company ID if $companyId is null.
        if (!$companyId) {
            $companyId = auth()->user()->company_id;
        }

        // Check if user is validated for access.
        $result = $this->checkValidity($companyId);

        // Return unauthorized access message.
        if ($result) {
            return $result;
        }

        // Get visits if it is an ajax request.
        if ($request->ajax()) {
            return DataTables::of(EmergencyVisit::getVisits($request->merge(['company_id' => $companyId])))
                ->setTransformer(new EmergencyVisitTransformer(EmergencyVisit::nonEditableArray()))
                ->toJson();
        }

        // Generate tab for each company.
        $lists = Str::generateCompanyTab(routeName: 'emergency.visits.index');

        // Build columns.
        $html = $builder
            ->columns([
                Column::make('name')
                    ->title('Name')
                    ->addClass('text-center')
                    ->searchable(true),

                Column::make('unit')
                    ->title('Unit')
                    ->addClass('text-center')
                    ->searchable(true),

                Column::make('zone')
                    ->title('Zone')
                    ->addClass('text-center')
                    ->searchable(true),

                Column::make('assign_to')
                    ->title('Assign To')
                    ->name('assaigned.name')
                    ->addClass('text-center')
                    ->searchable(true),

                Column::make('date_for')
                    ->title('Date For')
                    ->addClass('text-center')
                    ->searchable(true),

                Column::make('action')
                    ->title('Action')
                    ->addClass('text-center')
                    ->orderable(false)
                    ->searchable(false),
            ])
            ->parameters([
                'pageLength' => 25,
                'drawCallback' => 'function() {
                    tooltipViewerFn();
                    handleSearchDatatable();
                }',
            ]);

        return view('emergency-visits.index', compact('html', 'lists', 'companyId'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param int $companyId
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, int|null $companyId = null)
    {

        // Set user's company ID if $companyId is null.
        if (!$companyId) {
            $companyId = auth()->user()->company_id;
        }

        // Check if user is validated for access.
        $result = $this->checkValidity($companyId);

        // Return unauthorized access message.
        if ($result) {
            return $result;
        }

        // Generate tab for each company.
        $lists = Str::generateCompanyTab(routeName: 'emergency.visits.create');

        $currentCompany = $lists->where('id', $companyId)->first();
        $visitObjectives = VisitObjective::getTitles($request->merge(['company_id' => $companyId]))
            ->pluck('title', 'title');

        $zoneObj = Zone::getZones($request, $companyId);
        $zones = $zoneObj->pluck('name', 'id');
        return view('emergency-visits.create', compact('lists', 'companyId', 'currentCompany', 'zones', 'visitObjectives'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\EmergencyVisit\StoreEmergencyVisitRequest $request
     * @param \App\Models\Company $company
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEmergencyVisitRequest $request, Company $company)
    {
        try {
            // Store validated data into variable.
            $data = $request->validated();


            // Set this company ID.
            $data['company_id'] = $company->id;

            if (is_array($data['name'])) {
                $data['name'] = Arr::join($data['name'], ',');
            }
            $data['status'] = VisitStatus::WaitingForApproval->value;

            $unit_id = CompanyUnit::where('id', $data['company_unit_id'])->value('unit_id');
            $data['unit_id'] = $unit_id;
            // Save validated data.
            EmergencyVisit::create($data);

            return redirect()->route('emergency.visits.index', auth()->user()->company_id == $company->id ? null : $company->id)
                ->with('flash_success', 'Visit created successfully!');
        } catch (Throwable $th) {
            return response()->json([
                'message' => 'Something went wrong storing data!',
                'errors' => [$th->getMessage()],
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $companyId
     * @param \App\Models\EmergencyVisit $visit
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $companyId, EmergencyVisit $emergencyvisit)
    {
        // Check if user is validated for access.
        $result = $this->checkValidity($companyId);

        // Return unauthorized access message.
        if ($result) {
            return $result;
        }

        if (in_array($emergencyvisit->status, EmergencyVisit::nonEditableArray())) {
            return redirect()->back()
                ->with('flash_danger', "You can not edit this task");
        }

        // Get only the companies the user has access to.
        $companiesObj = app('authCompanies');

        // Get selected company's ID.
        $currentCompanyName = $companiesObj->get($companyId);

        $currentCompany = (new EmptyObj())->setRawAttributes([
            'id' => $companyId,
            'title' => $currentCompanyName
        ]);

        $visitObjectives = VisitObjective::getTitles($request->merge(['company_id' => $companyId]))
            ->pluck('title', 'title');

        $zoneObj = Zone::getZones($request, $companyId);
        $zones = $zoneObj->pluck('name', 'id');

        $visitStatus = Arr::except(VisitStatus::array(), Visit::nonEditableArray());

        return view('emergency-visits.edit', compact(
            'emergencyvisit',
            'companyId',
            'currentCompany',
            'visitObjectives',
            'zones',
            'visitStatus'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\EmergencyVisit\UpdateEmergencyVisitRequest $request
     * @param \App\Models\Company $company
     * @param \App\Models\EmergencyVisit $visit
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEmergencyVisitRequest $request, Company $company, EmergencyVisit $visit)
    {
        try {
            // Store validated data into variable.
            $data = $request->validated();
            //dd($data);
            if (is_array($data['name'])) {
                $data['name'] = Arr::join($data['name'], ',');
            }

            // Update validated data into database.
            $visit->update($data);

            return redirect()->route('emergency.visits.index', auth()->user()->company_id == $company->id ? null : $company->id)
                ->with('flash_success', "Visit updated successfully!");
        } catch (Throwable $th) {
            return response()->json([
                'message' => 'Something went wrong updating data!',
                'error' => [$th->getMessage()],
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Company $company
     * @param \App\Models\Visit $visit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company, EmergencyVisit $visit)
    {
        try {
            // Delete visit from database.
            $visit->delete();

            return redirect()->route('emergency.visits.index', auth()->user()->company_id == $company->id ? null : $company->id)
                ->with('flash_success', "Visit deleted successfully!");
        } catch (Throwable $th) {
            return response()->json([
                'message' => 'Something went wrong deleting data!',
                'error' => [$th->getMessage()],
            ]);
        }
    }
}
