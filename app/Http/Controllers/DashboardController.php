<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Visit;
use App\Models\EmptyObj;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    private $companyId;

    private function getUser()
    {
        $users = User::select(
            'users.status',
            DB::raw('COUNT(users.id) as total')
        )
            ->where('users.company_id', $this->companyId)
            ->groupBy('users.status')
            ->get();
    }

    private function getVisits($request)
    {
        $vists = Visit::where(function ($q) use ($request) {
            $q->where('visits.assign_to', $request->user()->id)
                ->orWhere('visits.created_by', $request->user()->id);
        })
            ->select(
                'visits.status',
                DB::raw('COUNT(visits.id) as total')
            )
            ->where('company_id', $this->companyId)
            ->groupBy('visits.status')
            ->get();
    }

    public function index(Request $request, $companyId = null)
    {
        if (!$companyId) {
            $companyId = $request->user()->company_id;
            $this->companyId = $companyId;
        }

        // Generate tab for each company.
        $lists = Str::generateCompanyTab(routeName: 'dashboard');

        return view('dashboard.index', compact('lists', 'companyId'));
    }
}
