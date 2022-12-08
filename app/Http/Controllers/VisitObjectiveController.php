<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\VisitObjective;
use App\Transformers\VisitObjectiveTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Throwable;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Column;

class VisitObjectiveController extends Controller
{
    /**
     * Get data of visit objectives.
     *
     * @param int $companyId
     *
     */
    private function getVisitObjectives(int $companyId)
    {
        return VisitObjective::where('company_id', $companyId)->get();
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Yajra\DataTables\Html\Builder $builder
     * @param int $companyId
     * @return  \Illuminate\Http\Response
     */
    public function index(Builder $builder, int $companyId = null)
    {
        // Set user's company ID if $companyId is null.
        if (!$companyId) {
            $companyId = auth()->user()->company_id;
        }

        // Check if the user has access.
        $result = $this->checkValidity($companyId);

        // Return unauthorized access message.
        if ($result) {
            return $result;
        }

        // Get data.
        if (request()->ajax()) {
            $visitObjectives = $this->getVisitObjectives($companyId);

            return DataTables::of($visitObjectives)
                ->setTransformer(new VisitObjectiveTransformer)
                ->toJson();
        }

        // Build columns.
        $html = $builder
            ->columns([
                Column::make('id')
                    ->visible(false),

                Column::make('title')
                    ->title('Objective')
                    ->addClass('text-center'),
                Column::make('status')
                    ->title('Status')
                    ->addClass('text-center'),
            ])
            ->parameters([
                'pageLength' => 25,
                'drawCallback' => 'function() {
                    KTMenu.createInstances();
                    handleSearchDatatable();
                }',
            ]);

        // Generate tab for each company.
        $lists = Str::generateCompanyTab(routeName:'visit-objectives.index');

        return view('visit-objectives.index', compact('html', 'lists', 'companyId'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param int $companyId
     * @return \Illuminate\Http\Response
     */
    public function create(int $companyId = null)
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
        $lists = Str::generateCompanyTab(routeName:'visit-objectives.create');

        // Get selected company name in each tabs.
        $currentCompany = $lists->where('id', $companyId)->first();

        return view('visit-objectives.create', compact('lists', 'currentCompany', 'companyId'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Company $company
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Company $company)
    {
        try {
            $validated = $request->validate([
                'title' => 'required',
                'status' => 'required',
            ]);

            $validated['company_id'] = $company->id;

            VisitObjective::create($validated);

            return redirect()
                ->route('visit-objectives.index', auth()->user()->company_id == $company->id ? null : $company->id)
                ->with('flash_success', "Objective created successfully!");
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
     * @param \App\Models\Company $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Company $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        return view('visit-objectives.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company  $company
     * @param  \App\Models\VisitObjective  $visitObjective
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company, VisitObjective $visitObjective)
    {
        try {
            $validated = $request->validated([
                'title' => 'required',
                'status' => 'required',
            ]);

            $visitObjective->where('company_id', $company)->update($validated);

            return redirect()
                ->route('visit-objectives.index', auth()->user()->company_id == $company->id ? null : $company->id)
                ->with('flash_success', "Objective updated successfully!");
        } catch (Throwable $th) {
            return response()->json([
                'message' => 'Something went wrong updating data!',
                'errors' => [$th->getMessage()],
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company, VisitObjective $visitObjective)
    {
        try {
            $visitObjective->where('company_id', $company)->delete();

            return redirect()
                ->route('visit-objectives.index', auth()->user()->company_id == $company->id ? null : $company->id)
                ->with('flash_success', "Objective updated successfully!");
        } catch (Throwable $th) {
            return response()->json([
                'message' => 'Something went wrong deleting data!',
                'errors' => [$th->getMessage()],
            ]);
        }
    }
}
