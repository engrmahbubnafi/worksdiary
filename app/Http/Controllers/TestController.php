<?php

namespace App\Http\Controllers;

use App\Enum\VisitStatus;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index(Request $request)
    {
        dd(VisitStatus::from('waiting_for_approval')->name);
        // return $this->mipel($request);
        // return $this->nafi();
    }

    // Test sending OTP on email.
    private function mipel($request)
    {

        //$x = Blade::render("{{new App\Abilities\UnitName(['code' => 'ax'])}}");
        // $abc = (new UnitName(['code' => 'ax']))();

        // dd($abc);

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
    }

    private function baten()
    {
    }

    private function mamun()
    {
    }
}
