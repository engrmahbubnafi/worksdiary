<?php

namespace App\Http\Controllers;

use App\Http\Requests\Company\StoreCompanyRequest;
use App\Http\Requests\Company\UpdateCompanyRequest;
use App\Models\Company;
use App\Models\CompanyUnit;
use App\Transformers\CompanyTransformer;
use Throwable;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Column;

class CompanyController extends Controller
{
    public function index(Builder $builder)
    {
        if (request()->ajax()) {
            return DataTables::eloquent(Company::query())
                ->setTransformer(new CompanyTransformer)
                ->toJson();
        }

        $html = $builder
            ->columns([
                Column::make('id')
                    ->visible(false),

                Column::make('name')
                    ->title('Name')
                    ->addClass('text-center'),

                Column::make('code')
                    ->title('Code')
                    ->addClass('text-center'),

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
                    tooltipViewerFn();
                    handleSearchDatatable();
                }',
            ]);

        return view('companies.index', compact('html'));
    }

    public function create()
    {
        return view('companies.create');
    }

    public function store(StoreCompanyRequest $request)
    {
        try {
            // Insert data into database.
            Company::create($request->validated());

            return redirect()
                ->route('companies.index')
                ->with('flash_success', "Company created successfully!");
        } catch (Throwable $th) {
            return response()->json([
                'message' => 'Something went wrong storing data!',
                'error' => [$th->getMessage()],
            ]);
        }
    }

    public function edit($id)
    {
        $company = Company::findOrFail($id);

        return view('companies.edit', compact('company'));
    }

    public function update(UpdateCompanyRequest $request, Company $company)
    {
        try {

            // Update data.
            $company->update($request->validated());

            return redirect()->route('companies.index')
                ->with('flash_success', "Company updated successfully!");
        } catch (Throwable $th) {
            return response()->json([
                'message' => 'Something went wrong updating data!',
                'error' => [$th->getMessage()],
            ]);
        }
    }

    public function destroy($id)
    {
        try {
            $company = Company::findOrFail($id);

            $company->delete();

            return redirect()->route("companies.index")
                ->with('flash_success', "Company deleted successfully!");
        } catch (Throwable $th) {
            return response()->json([
                'message' => 'Something went wrong deleting data!',
                'error' => [$th->getMessage()],
            ]);
        }
    }

    /**
     * Ajax Get untagged companies.
     *
     * @param int $unitId
     * @return object
     */
    public function getUnTaggeedCompanies(int $unitId = 0)
    {
        // Authenticated companies for the user.
        $authCompanies = app('authCompanies');

        // Get which companies are already tagged with the unit.
        $alreadyTaggedCompany = CompanyUnit::where('unit_id', $unitId)
            ->pluck('company_id', 'company_id');

        // Remove already tagged companies from the dropdown.
        if ($alreadyTaggedCompany->count()) {
            $companies = $authCompanies->diffKeys($alreadyTaggedCompany);
        } else {
            $companies = $authCompanies;
        }

        return $companies;
    }
}
