<?php

namespace App\Providers;

use App\Abilities\UnitName;
use App\Enum\Status;
use App\Models\Company;
use App\Models\UnitType;
use App\Models\CompanyUser;
use App\Models\RolePermission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

class CustomCacheServiceProvider extends ServiceProvider
{
    protected $defer = true;
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('premitedMenuArr', function ($app) {
            $controllerArr = [];
            $allIndexes = [];
            if (Auth::check()) {
                $rolePermissionObj = Cache::rememberForever('all_role_pemission_cache', function () {
                    return RolePermission::select(
                        'permission_id',
                        'role_id'
                    )
                        ->with(['permission' => function ($q) {
                            $q->select(
                                'id',
                                'name',
                                'parent_id'
                            );
                        }])
                        ->get()
                        ->groupBy('role_id');
                });
                // dd($rolePermissionObj);
                if ($rolePermissionObj->count()) {
                    $rolePermissions = $rolePermissionObj->get(Auth::user()->role_id);
                    if ($rolePermissions) {
                        foreach ($rolePermissions->toArray() as $key => $value) {
                            if ($value['permission']['parent_id'] == null) {
                                $controllerArr[$value['permission']['id']] = $value['permission']['name'];
                            } else {
                                $allIndexes[] = $controllerArr[$value['permission']['parent_id']] . '@' . $value['permission']['name'];
                            }
                        }
                    } else {
                        $allIndexes = ['DefaultController@index'];
                    }
                }
            }
            // ddd($allIndexes);
            return $allIndexes;
        });

        $this->app->singleton('authOtherCompanies', function ($app) {
            return CompanyUser::join('companies', 'companies.id', '=', 'company_users.company_id')
                ->where('company_users.user_id', auth()->id())
                ->where('company_users.company_id', '<>', auth()->user()->company_id)
                ->where('companies.status', Status::Active)
                ->select('companies.*')
                ->get();
        });

        $this->app->singleton('authCompaniesResources', function ($app) {
            $otherCompanies = CompanyUser::join('companies', 'companies.id', '=', 'company_users.company_id')
                ->where('company_users.user_id', auth()->id())
                ->where('companies.status', Status::Active)
                ->select('companies.*');


            $ownCompany = Company::where('id', auth()->user()->company_id)
                ->where('companies.status', Status::Active)
                ->select('companies.*');

            if ($otherCompanies->count()) {
                return $ownCompany->union($otherCompanies)->get();
            }
            return $ownCompany->get();
        });

        $this->app->singleton('authCompanies', function ($app) {
            $companies = resolve('authCompaniesResources');
            return $companies->pluck('name', 'id');
        });

        /**
         * Only for adding Units
         */
        $this->app->singleton('authUnitTypes', function ($app) {
            $authUnitTypes = collect();
            if (auth()->check()) {
                $authUnitTypes = UnitType::join('department_unit_types', 'department_unit_types.unit_type_id', '=', 'unit_types.id')
                    ->whereNull('parent_id')
                    ->where('department_unit_types.department_id', auth()->user()->department_id)
                    ->pluck('unit_types.name', 'unit_types.id');
            }
            return $authUnitTypes;
        });

        /**
         * Only for adding and viewing visits
         */
        $this->app->singleton('authUnitTypesAll', function ($app) {
            return UnitType::authUnitTypesAll();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
