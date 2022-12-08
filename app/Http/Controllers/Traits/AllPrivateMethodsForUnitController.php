<?php

namespace App\Http\Controllers\Traits;

use App\Models\CompanyUnit;
use App\Models\DepartmentUnitType;
use App\Models\Unit;
use App\Models\Zone;
use App\Transformers\UnitWithCompanyTransformer;
use App\Transformers\UnitWithoutCompanyTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Column;

trait AllPrivateMethodsForUnitController
{
    //for full text search
    private function returnSearchKeywordsWithPlus($searchText)
    {
        $searchString = '';
        $eliminateArr = ["(", ")", "%", "@", "+", "-"]; //keywords that doesn't support in full-text query
        $replaceArr = ["", "", "", "", "", " "];
        $searchText = trim(str_replace($eliminateArr, $replaceArr, $searchText));
        $criteriaArr = array_filter(explode(" ", $searchText)); //for remove empty value

        /*remove first numeric value*/
        $banArr = ["০", "১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯"];
        $engArr = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"];
        $i = 0;
        if (count($criteriaArr) > 1) {
            foreach ($criteriaArr as $key => $value) {
                $intVal = str_replace($banArr, $engArr, $value);
                if (!is_numeric($intVal)) {
                    if ($i == 0) {
                        $searchString .= $value . '*';
                    } else {
                        $searchString .= ' +' . $value . '*';
                    }
                    $i++;
                }
            }
        } else {
            $mainString = str_replace($banArr, $engArr, $searchText);
            $val = (int) $mainString;
            if ($val) {
                $searchText = trim(substr($mainString, strlen((string) $val)));
            }
            $searchString = strlen((string) $searchText) > 2 ? $searchText . '*' : 'hizibiziworkd';
        }
        return strlen((string) $searchString) > 3 ? $searchString : 'hizibiziword';
    }

    /**
     * Get data without company taging.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    private function getDataWithoutCompanyTaging(): JsonResponse
    {
        $unitTypesIds = DepartmentUnitType::getUserUnitTypesIds();

        $subJoinCompanies = CompanyUnit::join('companies', 'company_units.company_id', 'companies.id')
            ->select(
                DB::raw(
                    'COUNT(company_units.unit_id) as count'
                ),
                'company_units.unit_id',
                DB::raw(
                    'group_concat(companies.name) as name'
                ),
            )
            ->groupBy('company_units.unit_id');

        $units = Unit::select(
            'units.*',
            'unit_types.name as unit_type_name',
            'districts.name as district_name',
            'upazilas.name as upazila_name',
            'company_units.name as compnaies',
            'company_units.count as total_company'
        )
            ->join('unit_types', 'unit_types.id', 'units.unit_type_id')
            ->join('districts', 'districts.id', 'units.district_id')
            ->join('upazilas', 'upazilas.id', 'units.upazila_id')
            ->leftJoinSub($subJoinCompanies, 'company_units', function ($join) {
                $join->on('company_units.unit_id', '=', 'units.id');
            })
            ->whereIn('unit_types.id', $unitTypesIds)
            ->get();

        $authCompaniesTotal = app('authCompaniesResources')->count();

        return DataTables::of($units)
            ->setTransformer(new UnitWithoutCompanyTransformer($authCompaniesTotal))
            ->toJson();
    }

    private function indexWithoutCompanyTag($request, $builder)
    {
        // Get data without company taging if it is an ajax request.
        if ($request->ajax()) {
            return $this->getDataWithoutCompanyTaging();
        }

        $lists = Str::generateCompanyTab(routeName:'units.index', hasInitial:true, firstTabTitle:'Unit Database');

        // Build columns
        $html = $builder
            ->columns([
                Column::make('id')
                    ->visible(false),

                Column::make('code_name_type')
                    ->title('Unit')
                    ->addClass('text-center')
                    ->searchable(true),

                Column::make('owner')
                    ->title('Owner')
                    ->addClass('text-center')
                    ->searchable(true),

                Column::make('address')
                    ->title('Address')
                    ->addClass('text-center')
                    ->searchable(false),

                Column::make('status')
                    ->title('Status')
                    ->addClass('text-center')
                    ->searchable(false),

                Column::make('as_dealer')
                    ->title('Is Dealer')
                    ->addClass('text-center')
                    ->searchable(false),

                Column::make('compnaies')
                    ->title('Tag Companies')
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
                    KTMenu.createInstances();
                    handleSearchDatatable();
                }',
            ]);

        return view('units.index_without_company', compact('html', 'lists'));
    }

    /**
     * Get data with company taging.
     *
     * @param int $companyId
     * @return \Illuminate\Http\JsonResponse
     */
    private function getDataWithCompanyTaging($request, int $companyId): JsonResponse
    {

        $units = CompanyUnit::getDataWithCompanyTaging($request, $companyId);

        return DataTables::of($units)
            ->setTransformer(new UnitWithCompanyTransformer($companyId))
            ->toJson();
    }

    private function indexWithCompanyTag($request, $builder, $companyId)
    {
        // Get data with company taging if it is an ajax data.
        if ($request->ajax()) {
            return $this->getDataWithCompanyTaging($request, $companyId);
        }

        $lists = Str::generateCompanyTab(routeName:'units.index', hasInitial:true, firstTabTitle:'Unit Database');
        $units = Unit::getUnitListBySearchParam($request);
        $zones = Zone::getZones($request, $companyId)->pluck('name', 'id');

        $currentCompany = $lists->where('id', $companyId)->first();

        // Build columns
        $html = $builder
            ->columns([
                Column::make('id')
                    ->visible(false),

                Column::make('code_name_type')
                    ->title('Unit')
                    ->addClass('text-center')
                    ->searchable(true),

                Column::make('owner')
                    ->title('Owner')
                    ->addClass('text-center')
                    ->searchable(true),

                Column::make('dealer')
                    ->title('Dealer')
                    ->addClass('text-center')
                    ->searchable(false),

                Column::make('address')
                    ->title('Address')
                    ->addClass('text-center')
                    ->searchable(false),

                Column::make('location')
                    ->title('Location')
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
                //'search.search' => "jkfhjkdf",//for default search value
                'drawCallback' => 'function() {
                    KTMenu.createInstances();
                    handleSearchDatatable();
                }',
            ]);

        return view('units.index_with_company', compact('html', 'lists', 'units', 'zones', 'currentCompany'));
    }
}
