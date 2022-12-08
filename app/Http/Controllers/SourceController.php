<?php

namespace App\Http\Controllers;

use App\Http\Requests\Source\StoreSourceRequest;
use App\Http\Requests\Source\UpdateSourceRequest;
use App\Models\Company;
use App\Models\Source;
use App\Models\UnitType;
use App\Transformers\SourceTransformer;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use Throwable;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Column;

class SourceController extends Controller
{
    /**
     * Get sources.
     *
     * @param int $companyId
     * @return object
     */
    private function getSources(int $companyId): object
    {
        $sources = Source::join('companies', 'companies.id', 'sources.company_id')
            ->select(
                'sources.*',
                'companies.name as company'
            )
            ->where('sources.company_id', $companyId)
            ->get();

        return DataTables::of($sources)
            ->setTransformer(new SourceTransformer)
            ->toJson();
    }

    /**
     * Display a listing of the resource.
     *
     * @param Builder $builder
     * @param int $companyId
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder, int $companyId = null)
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

        // Get sources if it is an ajax request.
        if (request()->ajax()) {
            return $this->getSources($companyId);
        }

        // Generate tab for each company.
        $lists = Str::generateCompanyTab(routeName:'sources.index');

        // Build columns
        $html = $builder
            ->columns([
                Column::make('id')
                    ->visible(false),

                Column::make('name')
                    ->title('Name')
                    ->addClass('text-center')
                    ->searchable(true),

                Column::make('unit_type')
                    ->title('Unit Type')
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

        return view('sources.index', compact('html', 'lists', 'companyId'));
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
        $lists = Str::generateCompanyTab(routeName:'sources.create');

        $currentCompany = $lists->where('id', $companyId)->first();

        // Get all unit types for dropdown.
        $unitTypes = UnitType::pluck('name', 'id');

        return view('sources.create', compact('lists', 'companyId', 'currentCompany', 'unitTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Source\StoreSourceRequest  $request
     * @param \App\Models\Company $company
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSourceRequest $request, Company $company)
    {
        try {
            // Store validated data into variable.
            $data = $request->validated();

            // Set this company ID.
            $data['company_id'] = $company->id;

            // Save validated data into database.
            Source::create($data);

            return redirect()
                ->route('sources.index', auth()->user()->company_id == $company->id ? null : $company->id)
                ->with('flash_success', "Source created successfully!");
        } catch (Throwable $th) {
            return response()->json([
                'message' => 'Something went wrong storing data!',
                'error' => [$th->getMessage()],
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $companyId
     * @param  Source $source
     * @return \Illuminate\Http\Response
     */
    public function edit($companyId, Source $source)
    {
        // Check if user is validated for access.
        $result = $this->checkValidity($companyId);

        // Return unauthorized access message.
        if ($result) {
            return $result;
        }

        // Get only the companies the user has access to.
        $companiesObj = app('authCompanies');

        // Get selected company's ID.
        $currentCompany = $companiesObj->get($companyId);

        // Get all unit types
        $unitTypes = UnitType::pluck('name', 'id');

        return view('sources.edit', compact('source', 'companyId', 'currentCompany', 'unitTypes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\Source\UpdateSourceRequest  $request
     * @param \App\Models\Company $company
     * @param Source $source
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSourceRequest $request, Company $company, Source $source)
    {
        try {
            $data = $request->validated();

            $data['company_id'] = $company->id;

            // Update validated data into database.
            $source->update($data);

            return redirect()->route('sources.index', auth()->user()->company_id == $company->id ? null : $company->id)
                ->with('flash_success', "Source updated successfully!");
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
     * @param Source $source
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company, Source $source)
    {
        try {
            // Delete source from database.
            $source->delete();

            return redirect()->route('sources.index', auth()->user()->company_id == $company->id ? null : $company->id)
                ->with('flash_success', "Source deleted successfully!");
        } catch (Throwable $th) {
            return response()->json([
                'message' => 'Something went wrong deleting data!',
                'error' => [$th->getMessage()],
            ]);
        }
    }
}
