<?php

use App\Http\Controllers\AjaxController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CompanyUnitController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DealerController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\EmergencyVisitController;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\FieldGroupController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SourceController;
use App\Http\Controllers\SourceDetailController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UnitTypeController;
use App\Http\Controllers\UpazilaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VisitController;
use App\Http\Controllers\VisitObjectiveController;
use App\Http\Controllers\ZoneController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/', function () {
    return redirect()->route('dashboard');
})->name("home");

Route::group([
    'middleware' => [
        'auth.access',
        'auth',
        // 'auth.inactive',
        'verified',
    ],
], function () {
    Route::match(['get', 'put'], 'roles/{role}/clone', [RoleController::class, 'clone'])
        ->name('roles.clone');

    Route::resource('roles', RoleController::class)
        ->except(['show']);

    Route::any('/password/change-all/{user}', [UserController::class, 'changeAllPassword'])
        ->name('password.changeAll');

    // Users
    Route::get('users/create/{company?}', [UserController::class, 'create'])
        ->name('users.create');

    Route::get('users/index/{company?}', [UserController::class, 'index'])
        ->name('users.index');

    Route::post('user/transfer', [UserController::class, 'userTransfer'])->name('user.transfer');

    Route::post('users/company-filter', [UserController::class, 'companyFilter'])->name('users.company-filter');

    Route::resource('companies.users', UserController::class)
        ->except(['index', 'create']);

    // Companies
    Route::resource('companies', CompanyController::class);

    // Departments
    Route::get('departments/index/{company?}', [DepartmentController::class, 'index'])
        ->name('departments.index');
    Route::get('departments/create/{company?}', [DepartmentController::class, 'create'])
        ->name('departments.create');
    Route::resource('companies.departments', DepartmentController::class)->except(['index', 'create']);

    // Designations
    Route::resource('designations', DesignationController::class);

    // Zones
    Route::get('zones/index/{company?}', [ZoneController::class, 'index'])
        ->name('zones.index');
    Route::get('zones/create/{company?}', [ZoneController::class, 'create'])
        ->name('zones.create');
    Route::resource('companies.zones', ZoneController::class)->except(['index', 'create']);

    Route::resource('companies.zones.areas', AreaController::class);

    // Dealers
    Route::resource('dealers', DealerController::class);

    // Sources
    Route::get('sources/index/{company?}', [SourceController::class, 'index'])
        ->name('sources.index');
    Route::get('sources/create/{company?}', [SourceController::class, 'create'])
        ->name('sources.create');
    Route::resource('companies.sources', SourceController::class)->except(['index', 'create']);
    Route::resource('sources.source-details', SourceDetailController::class);

    // Unit Types
    Route::resource('unit-types', UnitTypeController::class);

    // Units
    Route::get('units/index/{company?}', [UnitController::class, 'index'])
        ->name('units.index');

    Route::resource('units', UnitController::class)->except('index');

    Route::post('company/units/tag', [CompanyUnitController::class, 'tag'])
        ->name('companies.units.tag');

    Route::post('company/units/unit-tag', [CompanyUnitController::class, 'unitTag'])
        ->name('companies.units.unitTag');

    Route::get('companies/{company}/units/{unit}/edit', [CompanyUnitController::class, 'edit'])
        ->name('companies.units.tag.edit');

    Route::post('companies/{company}/units/{unit}/update', [CompanyUnitController::class, 'update'])
        ->name('companies.units.tag.update');

    Route::delete('companies/{company}/units/{unit}/untag', [CompanyUnitController::class, 'untag'])
        ->name('companies.units.untag');

    // Forms
    Route::get('forms-clone/{forms}', [FormController::class, 'formClone'])
        ->name('forms.clone');
    Route::get('forms/index/{company?}', [FormController::class, 'index'])
        ->name('forms.index');
    Route::get('forms/create/{company?}', [FormController::class, 'create'])
        ->name('forms.create');
    Route::resource('companies.forms', FormController::class)->except(['index', 'create']);
    Route::resource('forms.fields', FieldController::class);
    Route::resource('forms.field-groups', FieldGroupController::class);

    // Visits
    Route::get('visit-objectives/index/{company?}', [VisitObjectiveController::class, 'index'])
        ->name('visit-objectives.index');
    Route::get('visit-objectives/create/{company?}', [VisitObjectiveController::class, 'create'])
        ->name('visit-objectives.create');

    Route::resource('companies.visit-objectives', VisitObjectiveController::class)->except(['index', 'create']);

    Route::get('visits/index/{company?}', [VisitController::class, 'index'])
        ->name('visits.index');
    Route::get('visits/create/{company?}', [VisitController::class, 'create'])
        ->name('visits.create');
    Route::resource('companies.visits', VisitController::class)->except(['index', 'create']);

    // Visits
    Route::get('emergency-visits/index/{company?}', [EmergencyVisitController::class, 'index'])
        ->name('emergency.visits.index');
    Route::get('emergency-visits/create/{company?}', [EmergencyVisitController::class, 'create'])
        ->name('emergency.visits.create');
    Route::resource('companies.emergencyvisits', EmergencyVisitController::class)->except(['index', 'create']);

    // Route::get('visits/create/{visit?}', [VisitController::class, 'create'])
    //     ->name('visits.create');
    // Route::resource('visits', VisitController::class)->except(['create']);
});

Route::group(['middleware' => ['auth', 'verified']], function () {
    //URL::defaults(['dashboardUrl' => 'dashboard']); set to app service provider
    Route::get('/{dashboardUrl}/{company?}', [DashboardController::class, 'index'])
        ->where(['dashboardUrl' => 'dashboard|administrator|admin'])
        ->name('dashboard');

    Route::get('systems-role-update', [RoleController::class, 'systemsRoleUpdate'])
        ->middleware('only.administrator')
        ->name('systems.role.update');

    Route::get('users/company/select/{routeTo}', [UserController::class, 'selectCompany'])
        ->name('users.select_company');

    Route::post('verify-email-as-sys-admin/{user}', [UserController::class, 'verifyEmailAsSysAdmin'])
        ->name('ajax.user.verify_email_as_sys_admin');

    Route::get('get-reference-values/{formId}/{fieldId?}', [FieldController::class, 'getReferenceValues'])
        ->name('ajax.fields.reference');

    Route::get('get-compare-values/{formId}/{fieldId?}', [FieldController::class, 'getCompareValues'])
        ->name('ajax.fields.compare');

    Route::get('departments-list/{company_id}', [DepartmentController::class, 'getDepartmentsByCompany'])
        ->name('ajax.departments.getDepartmentsByCompany');

    Route::get('get-untagged-company-by-unit/{unit_id}', [CompanyController::class, 'getUnTaggeedCompanies'])
        ->name('ajax.companies.getUnTaggeedCompanies');

    Route::get('companies/{company}/zones', [ZoneController::class, 'getZonesByCompany'])
        ->name('ajax.zones.getZonesByCompany');

    Route::get('get-areas-by-zone/{zone_id}', [AreaController::class, 'getAreasByZone'])
        ->name('ajax.areas.getAreasByZone');

    Route::post('get-and-check-unit', [UnitController::class, 'getAndChecckUnit'])
        ->name('ajax.unit.getAndChecckUnit');

    Route::get('units/show/{unitId}', [UnitController::class, 'show'])
        ->name('ajax.unit.show');

    Route::post('tag-unit', [CompanyUnitController::class, 'tagUnit'])
        ->name('ajax.companyUnits.tagUnit');

    Route::get('get-upazila-by-district/{districtId?}', [UpazilaController::class, 'getUpazilaByDistrict'])
        ->name('ajax.upazilas.list');

    Route::get('get-units-by-company/{companyId}', [CompanyUnitController::class, 'getUnitsByCompany'])
        ->name('ajax.visit.getUnitsByCompany');

    Route::post('get-unit-types-by-unit', [UnitTypeController::class, 'getUnitTypesByUnit'])
        ->name('ajax.visit.getUnitTypesByUnit');

    Route::post('get-unit-visitors', [VisitController::class, 'getUnitVisitors'])
        ->name('ajax.visit.getVisitors');

    Route::post('get-units-by-zone', [VisitController::class, 'getUnitsByZone'])
        ->name('ajax.visit.getUnitsByZone');

    Route::post('get-search-unit-list', [UnitController::class, 'getSearchUnitList'])
        ->name('ajax.unitSearch.unitList');

    Route::post('get-search-company-unit-list', [UnitController::class, 'getSearchCompanyUnits'])
        ->name('ajax.unitSearch.companyUnits');

    Route::get('get-upazila/{district_id?}', [AjaxController::class, 'getUpazilaData']);
});

if (app()->isLocal()) {
    require __DIR__ . '/demo.php';
    Route::get('test', [TestController::class, 'index']);
}
require __DIR__ . '/auth.php';
