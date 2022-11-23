<?php

namespace App\Http\Controllers;

use Throwable;
use App\Enum\Status;
use App\Models\Company;
use App\Models\UnitType;
use App\Models\Department;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Column;
use App\Models\DepartmentUnitType;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Facades\DataTables;
use App\Transformers\DepartmentTransformer;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Requests\Department\StoreDepartmentRequest;
use App\Http\Requests\Department\UpdateDepartmentRequest;

class DepartmentController extends Controller
{

    /**
     * Get departments
     *
     * @param int $companyId
     * @return object
     */
    private function getDepartmentData($companyId): object
    {
        $sub = DepartmentUnitType::select(
            'department_id',
            DB::raw('GROUP_CONCAT(unit_types.name) as unit_types')
        )
            ->join('unit_types', 'unit_types.id', 'department_unit_types.unit_type_id')
            ->groupBy('department_id');


        $departments = Department::join('companies', 'companies.id', '=', 'departments.company_id')
            ->leftJoinSub($sub, 'department_unit_types', function ($join) {
                $join->on('department_unit_types.department_id', '=', 'departments.id');
            })
            ->select(
                'departments.*',
                'department_unit_types.unit_types',
                'companies.name as company'
            )
            ->where('departments.company_id', $companyId)
            ->get();

        return DataTables::of($departments)
            ->setTransformer(new DepartmentTransformer)
            ->toJson();
    }

    public function index(Builder $builder, $companyId = null)
    {

        if (!$companyId) {
            $companyId = auth()->user()->company_id;
        }

        $result = $this->checkValidity($companyId);

        if ($result) {
            return $result;
        }

        if (request()->ajax()) {
            return $this->getDepartmentData($companyId);
        }

        $lists = Str::generateCompanyTab(routeName: 'departments.index');

        $html = $builder
            ->columns([
                Column::make('id')
                    ->title('Id')
                    ->addClass('text-center'),

                Column::make('name')
                    ->title('Name')
                    ->addClass('text-center'),

                Column::make('code')
                    ->title('Code')
                    ->addClass('text-center'),

                Column::make('unit_types')
                    ->title('Unit Types')
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

        return view('departments.index', compact('html', 'lists'));
    }

    public function create($companyId = null)
    {
        if (!$companyId) {
            $companyId = auth()->user()->company_id;
        }

        $result = $this->checkValidity($companyId);

        if ($result) {
            return $result;
        }

        $lists = Str::generateCompanyTab(routeName: 'departments.create');

        $currentCompany = $lists->where('id', $companyId)->first();

        $unitTypes = UnitType::authUnitTypes();

        return view('departments.create', compact('lists', 'companyId', 'currentCompany', 'unitTypes'));
    }

    public function store(StoreDepartmentRequest $request, Company $company)
    {
        try {
            // Store validated data into variable
            $data = $request->safe()->except(['type_ids']);
            $typeIds = $request->get('type_ids');

            // Set this company ID
            $data['company_id'] = $company->id;

            $department = Department::create($data);

            $department->unitTypes()->sync($typeIds);

            return redirect()
                ->route('departments.index', auth()->user()->company_id == $company->id ? null : $company->id)
                ->with('flash_success', "Department created successfully!");
        } catch (Throwable $th) {

            return response()->json([
                'message' => 'Something went wrong storing data!',
                'error' => [$th->getMessage()],
            ]);
        }
    }

    public function edit($companyId, Department $department)
    {

        $result = $this->checkValidity($companyId);

        if ($result) {
            return $result;
        }

        $selectedUnitTypes = DepartmentUnitType::where('department_id', $department->id)
            ->pluck('unit_type_id', 'unit_type_id');

        $companiesObj = app('authCompanies');

        $currentCompany = $companiesObj->get($companyId);

        $unitTypes = UnitType::authUnitTypes();

        return view('departments.edit', compact('department', 'companyId', 'currentCompany', 'unitTypes', 'selectedUnitTypes'));
    }

    public function update(UpdateDepartmentRequest $request, Company $company, Department $department)
    {
        try {
            $data = $request->safe()->except(['type_ids']);
            $typeIds = $request->get('type_ids');

            $data['company_id'] = $company->id;

            // Update validated request data.
            $department->update($data);

            $department->unitTypes()->sync($typeIds);

            return redirect()->route('departments.index', auth()->user()->company_id == $company->id ? null : $company->id)
                ->with('flash_success', "Department updated successfully!");
        } catch (Throwable $th) {
            return response()->json([
                'message' => 'Something went wrong updating data!',
                'error' => [$th->getMessage()],
            ]);
        }
    }

    public function destroy(Company $company, Department $department)
    {
        try {
            $department->delete();

            return redirect()->route("departments.index", auth()->user()->company_id == $company->id ? null : $company->id)
                ->with('flash_success', "Department deleted successfully!");
        } catch (Throwable $th) {
            return response()->json([
                'message' => 'Something went wrong deleting data!',
                'error' => [$th->getMessage()],
            ]);
        }
    }

    /**
     * Ajax (for dropdown)
     *
     * @param Int $companyId
     * @return Collection
     */
    public function getDepartmentsByCompany(Int $companyId): Collection
    {
        return Department::where('company_id', $companyId)
            ->where('status', Status::Active)
            ->select('id', 'name')
            ->get();
    }
}
