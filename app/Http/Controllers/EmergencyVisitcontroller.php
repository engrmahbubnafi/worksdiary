<?php

namespace App\Http\Controllers;

use Throwable;
use Carbon\Carbon;
use App\Models\Form;
use App\Models\Zone;
use App\Models\Company;
use App\Models\EmptyObj;
use App\Models\CompanyUnit;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\EmergencyVisit;
use App\Models\VisitObjective;
use Yajra\DataTables\Html\Column;
use App\Enum\EmergencyVisitStatus;
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

            if ($request->exists('supervisor')) {
                $supervisor = (int) $request->get('supervisor');
                if ($supervisor) {
                    $request->merge(['supervisor_id' => $request->user()->id]);
                } else {
                    $request->merge(['supervisor_id' => $request->user()->supervisor_id]);
                }
            }

            return DataTables::eloquent(
                EmergencyVisit::getVisitsEloquentObj($request->merge(['company_id' => $companyId]))
                    ->orderBy('emergency_tasks.date_for')
                    ->orderBy('emergency_tasks.created_at')
            )
                ->setTransformer(new EmergencyVisitTransformer(EmergencyVisit::nonEditableArray()))
                ->filterColumn('date_for', function ($query, $value) {

                    $segments = Str::of($value)->split('/\|/');

                    if (!empty($segments[0]) && !empty($segments[1])) {

                        $min = Carbon::parse($segments[0]);
                        $max = Carbon::parse($segments[1]);

                        $query->whereBetween('emergency_tasks.date_for', [$min, $max]);
                    }
                })
                ->filterColumn('status', function ($query, $value) {
                    $query->where('emergency_tasks.status', $value);
                })
                ->toJson();
        }

        // Generate tab for each company.
        $lists = Str::generateCompanyTab(routeName: 'emergency.visits.index');

        $supervisors = [
            '' => 'Select Supervisor',
            '1' => 'Me as a Supervisor',
            '0' => 'My Supervisor'
        ];

        // Build columns.
        $html = $builder
            ->columns([
                Column::make('name')
                    ->title('Visit Objective')
                    ->addClass('text-center')
                    ->searchable(true),

                Column::make('unit')
                    ->name('units.name')
                    ->title('Unit')
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

                Column::make('status')
                    ->title('Status')
                    ->addClass('text-center')
                    ->searchable(true)
                    ->hidden(),

                Column::make('created_at')
                    ->title('Created')
                    ->addClass('text-center')
                    ->searchable(false),

                Column::make('created_by')
                    ->name('created.name')
                    ->title('Created By')
                    ->addClass('text-center')
                    ->searchable(false),

                Column::make('action')
                    ->title('Action')
                    ->addClass('text-center')
                    ->orderable(false)
                    ->searchable(false),
            ])
            ->parameters([
                'pageLength' => 25,
                'order' => [], /* No ordering applied by DataTables during initialisation */
                'drawCallback' => 'function() {
                    tooltipViewerFn();
                    handleSearchDatatable();
                }',
                "aoSearchCols" => [
                    '', //0[name]
                    '', //1[unit]
                    '', //2[assign_to]
                    '', //3[date_for]
                    [
                        "sSearch" => EmergencyVisitStatus::Pending->value //4[status]
                    ],
                ],
            ]);

        return view('emergency-visits.index', compact('html', 'lists', 'companyId', 'supervisors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param int $companyId
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, int | null $companyId = null)
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
            $validated = $request->validated();

            $companyUnit = CompanyUnit::where('id', $validated['company_unit_id'])
                ->select('unit_id', 'company_id', 'zone_id')
                ->first();

            $data = array_merge($validated, $companyUnit->toArray());

            $data['name'] = Arr::join($data['objectives'], ',');
            $data['status'] = EmergencyVisitStatus::Pending->value;

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
            'title' => $currentCompanyName,
        ]);

        $visitObjectives = VisitObjective::getTitles($request->merge(['company_id' => $companyId]))
            ->pluck('title', 'title');

        $zoneObj = Zone::getZones($request, $companyId);
        $zones = $zoneObj->pluck('name', 'id');

        $visitStatus = Arr::except(EmergencyVisitStatus::array(), EmergencyVisit::nonEditableArray());

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
    public function update(UpdateEmergencyVisitRequest $request, Company $company, EmergencyVisit $emergencyvisit)
    {
        try {
            // Store validated data into variable.
            $validated = $request->validated();

            $companyUnit = CompanyUnit::where('id', $validated['company_unit_id'])
                ->select('unit_id', 'company_id', 'zone_id')
                ->first();

            $data = array_merge($validated, $companyUnit->toArray());
            //dd($data);
            $data['name'] = Arr::join($data['objectives'], ',');

            if (empty($data['assign_to'])) {
                $data['assign_to'] = $request->user()->id;
            }
            // Update validated data into database.
            $emergencyvisit->update(Arr::except($data, ['objectives']));

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
     * Display the specified resource.
     *
     * @param Visit $zone
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $companyId, $id)
    {
        // Check if user is validated for access.
        $result = $this->checkValidity($companyId);

        // Return unauthorized access message.
        if ($result) {
            return $result;
        }

        $emergencyVisit = EmergencyVisit::getVisit($request->merge(['id' => $id]));
        $emergencyVisit->load('emergencyTaskImages');
        //dd($emergencyVisit->toArray());

        return view('emergency-visits.show', compact('companyId', 'emergencyVisit'));
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
