<?php

namespace App\Http\Controllers;

use App\Http\Requests\UnitType\StoreUnitTypeRequest;
use App\Http\Requests\UnitType\UpdateUnitTypeRequest;
use App\Models\Company;
use App\Models\CompanyUnit;
use App\Models\DepartmentUnitType;
use App\Models\UnitType;
use App\Transformers\UnitTypeTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Throwable;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Column;

class UnitTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {
        /**
         * Fetch all unit type data if it's an ajax request.
         */
        if (request()->ajax()) {
            $subJoin = DepartmentUnitType::join('departments', 'departments.id', 'department_unit_types.department_id')
                ->join('companies', 'companies.id', 'departments.company_id')
                ->select(
                    'department_unit_types.unit_type_id',
                    // DB::raw('group_concat(
                    //     companies.name,"(",departments.name,")"
                    //     ) as department'
                    // ),
                    DB::raw(
                        'group_concat(
                            DISTINCT CONCAT(companies.name,"(",departments.name,")")
                            ORDER BY department_unit_types.unit_type_id
                            SEPARATOR ", "
                        ) as department'
                    )
                )
                ->groupBy('department_unit_types.unit_type_id');

            $unitTypes = UnitType::with('parent')
                ->select('unit_types.*', 'unit_departments.*')
                ->leftJoinSub($subJoin, 'unit_departments', function ($join) {
                    $join->on('unit_departments.unit_type_id', '=', 'unit_types.id');
                })
                ->get();

            return DataTables::of($unitTypes)
                ->setTransformer(new UnitTypeTransformer)
                ->toJson();
        }

        $html = $builder
            ->columns([
                Column::make('id')
                    ->visible(false),

                Column::make('name')
                    ->title('Name')
                    ->addClass('text-center')
                    ->searchable(true),

                Column::make('parent')
                    ->title('Parent')
                    ->addClass('text-center')
                    ->searchable(true),

                Column::make('departments')
                    ->title('Company(Departments)')
                    ->addClass('text-center')
                    ->searchable(true),

                Column::make('is_slot_enabled')
                    ->title('Slot Enabled')
                    ->addClass('text-center')
                    ->searchable(false),

                Column::make('status')
                    ->title('Status')
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
                'drawCallback' => 'function() {
                    tooltipViewerFn();
                    handleSearchDatatable();
                }',
            ]);

        return view('unit-types.index', compact('html'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $authUserCompanies = App::make('authCompanies');
        $companyDepartments = Company::getCompanyWithDepartmentByCompanyId($authUserCompanies->keys());
        $parents = UnitType::whereNull('parent_id')->pluck('name', 'id');
        return view('unit-types.create', compact('companyDepartments', 'parents'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\UnitType\StoreUnitTypeRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUnitTypeRequest $request)
    {
        try {
            // Get department IDs for tagging.
            $departments = $request->get('department_ids');

            // Insert validated data into database.
            $unitType = UnitType::create($request->validated());
            if ($unitType) {
                if ($departments && count($departments)) {
                    $department_unit_type = $unitType->departments()->sync($departments);
                    if ($department_unit_type) {
                        $message = "You have successfully created";
                        return redirect()->route('unit-types.index')
                            ->with('success', $message);
                    } else {
                        $message = "You have successfully created unit type but no department set";
                        return redirect()->route('unit-types.index')
                            ->with('warning', $message);
                    }
                } else {
                    $message = "You have successfully created unit type but no department set";
                    return redirect()->route('unit-types.index')
                        ->with('warning', $message);
                }
            } else {
                $message = "Opps! Something wrong. Please try again.";
                return redirect()->route('unit-types.create')
                    ->with('danger', $message);
            }
        } catch (Throwable $th) {
            /**
             * Return error message and details.
             */
            $message = "Opps! Something wrong. Please try again.";
            return redirect()->route('unit-types.create')
                ->with('danger', $message);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        /**
         * Fetch the specific unit type.
         */
        $unitType = UnitType::findOrFail($id);

        return view('unit-types.show', compact('unitType'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        /**
         * Fetch data of specific unit type.
         */
        $unitType = UnitType::findOrFail($id);
        $authUserCompanies = App::make('authCompanies');
        $companyDepartments = Company::getCompanyWithDepartmentByCompanyId($authUserCompanies->keys());

        $department_unit_types = DepartmentUnitType::whereUnitTypeId($id)->pluck('department_id', 'id');

        $parents = UnitType::whereNull('parent_id')->pluck('name', 'id');

        return view('unit-types.edit', compact('unitType', 'companyDepartments', 'department_unit_types', 'parents'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\UnitType\UpdateUnitTypeRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUnitTypeRequest $request, UnitType $unit_type)
    {
        // Update name field only.
        $data = $request->only("name", 'status', 'is_slot_enabled', 'parent_id');

        // Get department IDs.
        $departmentIds = [];
        if (request()->get("department_ids")) {
            $departmentIds = request()->get("department_ids");
        }

        try {

            if (!request()->has("is_slot_enabled")) {
                $unit_type->is_slot_enabled = false;
            }
            $unit_type->fill($data);
            $unit_type->save();
            $unit_type->departments()->sync($departmentIds);

            if ($unit_type) {
                $message = "You have successfully updated";
                return redirect()->route("unit-types.index")
                    ->with('flash_success', $message);
            } else {
                $message = "Opps! Something wrong. Please try again.";

                return redirect()->route("unit-types.edit", $unit_type->id)
                    ->with("flash_danger", $message);
            }
        } catch (Throwable $th) {
            return redirect()->back()
                ->with('flash_danger', 'Something went wrong with deleting data!');
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        /**
         * Fetch data of specific unit type.
         */
        $unitType = UnitType::findOrFail($id);

        try {
            // Delete Unit Type.
            $unitType->delete();

            // Delete the row for this Unit Type of Department-Unit Type table.
            DepartmentUnitType::whereUnitTypeId($id)->delete();

            return redirect()->route('unit-types.index')
                ->with('flash_success', 'Unit type deleted successfully!');
        } catch (Throwable $th) {
            return redirect()->back()
                ->with('flash_danger', 'Something went wrong with deleting data!');
        }
    }

    /**
     * Ajax Get unit types according to unit.
     *
     * @param int $unitId
     * @return \Illuminate\Support\Collection
     */
    public function getUnitTypesByUnit(Request $request): Collection
    {

        if ($request->exists('unitId') && $request->has('unitId')) {
            $unitObj = CompanyUnit::join('units', 'units.id', '=', 'company_units.unit_id')
                ->select('units.unit_type_id')
                ->find($request->get('unitId'));

            if ($unitObj) {
                return UnitType::authUnitTypesAll((int) $unitObj->unit_type_id);
            }
        }
        return collect();
    }
}
