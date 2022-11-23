<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UnitType;
use App\Abilities\UnitName;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\v1\UnitTypeResource;

class TestController extends Controller
{
    public function index(Request $request)
    {
        return $this->mipel($request);
        // return $this->nafi();
    }

    // Test sending OTP on email.
    private function mipel($request)
    {
        //$x = Blade::render("{{new App\Abilities\UnitName(['code' => 'ax'])}}");
        $abc = (new UnitName(['code' => 'ax']))();

        dd($abc);

        // dd($x);

        // $otherCompanies = CompanyUser::join('companies', 'companies.id', '=', 'company_users.company_id')
        //     ->where('company_users.user_id', auth()->id())
        //     ->where('companies.status', 'active')
        //     ->select('companies.*')
        //     ->get();
        // dd(Status::array());

        // $otherCompanies = CompanyUser::join('companies', 'companies.id', '=', 'company_users.company_id')
        //     ->where('company_users.user_id', auth()->id())
        //     ->where('companies.status', Status::Active)
        //     ->select('companies.*')
        //     ->get();

        // $authUserCompanies = collect();

        // $ownCompany = Company::where('id', auth()->user()->company_id)
        //     ->where('companies.status', 'active')
        //     ->select('companies.*')
        //     ->get();
        // $ownCompany = Company::where('id', auth()->user()->company_id)
        //     ->where('companies.status', Status::Active)
        //     ->select('companies.*')
        //     ->get();

        // if ($otherCompanies->count()) {
        //     $authUserCompanies = $ownCompany->union($otherCompanies);
        // } else {
        //     $authUserCompanies = $ownCompany;
        // }

        // dd($authUserCompanies->toArray());

        // $data = ['data' => ['otp' => 123456]];

        // return (new OneTimePassword($data))->render();
    }

    private function nafi()
    {
        // $units = Unit::join('unit_types', 'unit_types.id', 'units.unit_type_id')
        //     ->join('districts', 'districts.id', 'units.district_id')
        //     ->join('upazilas', 'upazilas.id', 'units.upazila_id')
        //     ->select(
        //         'units.*',
        //         'unit_types.name as unit_type_name',
        //         'districts.name as district_name',
        //         'upazilas.name as upazila_name'
        //     )
        //     ->where('units.id', 3)
        //     ->get();

        // dump($units);
    }

    private function baten()
    {
    }

    private function mamun()
    {
    }
}
