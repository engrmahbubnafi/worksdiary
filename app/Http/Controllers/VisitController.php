<?php

namespace App\Http\Controllers;

use App\Enum\VisitStatus;
use App\Http\Requests\Visit\StoreVisitRequest;
use App\Http\Requests\Visit\UpdateVisitRequest;
use App\Models\Company;
use App\Models\CompanyUnit;
use App\Models\EmptyObj;
use App\Models\Form;
use App\Models\User;
use App\Models\Visit;
use App\Models\VisitObjective;
use App\Models\Zone;
use App\Transformers\VisitTransformer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Throwable;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Column;

class VisitController extends Controller
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
        if ($request->ajax()) {

            if ($request->exists('supervisor')) {
                $supervisor = (int) $request->get('supervisor');
                if ($supervisor) {
                    $request->merge(['supervisor_id' => $request->user()->id]);
                } else {
                    $request->merge(['supervisor_id' => $request->user()->supervisor_id]);
                }
            }

            //dump($request->all('columns'));
            return DataTables::eloquent(
                Visit::getVisitsEloquentObj($request->merge(['company_id' => $companyId]))
                    ->orderBy('visits.date_for')
                    ->orderBy('visits.created_at')
            )
                ->setTransformer(new VisitTransformer(Visit::nonEditableArray()))
                ->filterColumn('date_for', function ($query, $value) {

                    $segments = Str::of($value)->split('/\|/');

                    if (!empty($segments[0]) && !empty($segments[1])) {

                        $min = Carbon::parse($segments[0]);
                        $max = Carbon::parse($segments[1]);

                        $query->whereBetween('visits.date_for', [$min, $max]);
                    }
                })
                ->filterColumn('status', function ($query, $value) {
                    $query->where('visits.status', $value);
                })
                ->toJson();
        }

        // Generate tab for each company.
        $lists = Str::generateCompanyTab(routeName: 'visits.index');

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
                        "sSearch" => VisitStatus::WaitingForApproval->value //4[status]
                    ],
                ],
            ]);

        return view('visits.index', compact('html', 'lists', 'companyId', 'supervisors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param int $companyId
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, int $companyId = null)
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
        $lists = Str::generateCompanyTab(routeName: 'visits.create');

        $currentCompany = $lists->where('id', $companyId)->first();
        $visitObjectives = VisitObjective::getTitles($request->merge(['company_id' => $companyId]))
            ->pluck('title', 'title');

        $zoneObj = Zone::getZones($request, $companyId);
        $zones = $zoneObj->pluck('name', 'id');
        return view('visits.create', compact('lists', 'companyId', 'currentCompany', 'zones', 'visitObjectives'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Visit\StoreVisitRequest $request
     * @param \App\Models\Company $company
     * @return \Illuminate\Http\Response
     */
    public function store(StoreVisitRequest $request, Company $company)
    {
        try {
            // Store validated data into variable.
            $validated = $request->validated();

            $companyUnit = CompanyUnit::where('id', $validated['company_unit_id'])
                ->select('unit_id', 'company_id', 'zone_id')
                ->first();

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

            return redirect()->route('visits.index', auth()->user()->company_id == $company->id ? null : $company->id)
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
     * @param \App\Models\Visit $visit
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $companyId, Visit $visit)
    {
        // Check if user is validated for access.
        $result = $this->checkValidity($companyId);

        // Return unauthorized access message.
        if ($result) {
            return $result;
        }
        if (in_array($visit->status, Visit::nonEditableArray())) {
            return redirect()->back()
                ->with('flash_danger', "You can not edit this visit");
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

        $visitStatus = Arr::except(VisitStatus::array(), Visit::nonEditableArray());

        return view('visits.edit', compact(
            'visit',
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
     * @param \App\Http\Requests\Visit\UpdateVisitRequest $request
     * @param \App\Models\Company $company
     * @param \App\Models\Visit $visit
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateVisitRequest $request, Company $company, Visit $visit)
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
            $visit->update(Arr::except($data, ['objectives']));

            return redirect()->route('visits.index', auth()->user()->company_id == $company->id ? null : $company->id)
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
        $visit = Visit::getVisit($request->merge(['id' => $id]));

        $forms = Form::where('company_id', $visit->company_id)
            ->where('unit_type_id', $visit->unit_type_id)
            ->pluck('name', 'id');

        $formId = $request->get('formId');

        return view('visits.show', compact('companyId', 'visit', 'forms', 'formId'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Company $company
     * @param \App\Models\Visit $visit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company, Visit $visit)
    {
        try {
            // Delete visit from database.
            $visit->delete();

            return redirect()->route('visits.index', auth()->user()->company_id == $company->id ? null : $company->id)
                ->with('flash_success', "Visit deleted successfully!");
        } catch (Throwable $th) {
            return response()->json([
                'message' => 'Something went wrong deleting data!',
                'error' => [$th->getMessage()],
            ]);
        }
    }

    /**
     * Ajax Get unit visitors according to unit.
     *
     * @param int $unitId
     * @return \Illuminate\Support\Collection
     */
    public function getUnitVisitors(Request $request): Collection
    {

        return User::unitVisitors($request);
    }

    /**
     * Ajax Get unit  according to zone.
     *
     * @param int $zone_id
     * @return \Illuminate\Support\Collection
     */
    public function getUnitsByZone(Request $request): Collection
    {
        return CompanyUnit::list($request);
    }
}
