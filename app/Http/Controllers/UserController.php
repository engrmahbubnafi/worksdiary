<?php

namespace App\Http\Controllers;

use App\Enum\Status;
use App\Http\Controllers\Traits\AllPrivateMethodsForUserController;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\Company;
use App\Models\CompanyUser;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Role;
use App\Models\User;
use App\Models\UserZone;
use App\Models\Zone;
use App\Transformers\UserTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Throwable;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Column;

class UserController extends Controller
{
    use AllPrivateMethodsForUserController;

    /**
     * Display a listing of the resource.
     *
     * @param int $companyId
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder, User $user, $companyId = null)
    {

        if (!$companyId) {
            $companyId = auth()->user()->company_id;
        }

        $result = $this->checkValidity($companyId);

        if ($result) {
            return $result;
        }

        // Get user data if it's an ajax request
        if (request()->ajax()) {
            $users = $this->getUserData($companyId);

            return DataTables::of($users)
                ->setTransformer(new UserTransformer)
                ->toJson();
        }
        $lists = Str::generateCompanyTab(routeName:'users.index');

        $companies = Company::where('status', Status::Active)
            ->pluck('name', 'id');

        // Build columns
        $html = $builder
            ->columns([
                Column::make('name_mobile_email')
                    ->title('User')
                    ->addClass('text-center'),

                Column::make('role')
                    ->title('Role')
                    ->addClass('text-center')
                    ->orderable(false),

                Column::make('company_department')
                    ->title('Company (Department)')
                    ->addClass('text-center')
                    ->orderable(false),

                Column::make('zones')
                    ->title('Zone')
                    ->addClass('text-center')
                    ->orderable(false),

                Column::make('status')
                    ->title('Status')
                    ->addClass('text-center'),

                Column::make('action')
                    ->title('Action')
                    ->addClass('text-center')
                    ->orderable(false)
                    ->searchable(false)
                    ->responsivePriority(2),
            ])
            ->parameters([
                'pageLength' => 25,
                'drawCallback' => 'function() {
                    KTMenu.createInstances();
                    handleSearchDatatable();
                }',
            ]);

        return view('users.index', compact('html', 'companies', 'lists'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $companyId = null)
    {

        if (!$companyId) {
            $companyId = $request->user()->company_id;
        }

        $result = $this->checkValidity($companyId);

        if ($result) {
            return $result;
        }

        // Show all roles only if the user creating the new user is an administrator
        // Otherwise show only those roles which are not editable and deletable
        if ($request->user()->isAdministrator()) {
            $roles = Role::pluck('name', 'id');
        } else {
            $roles = Role::where('is_deletable', '<>', 0)
                ->where('is_editable', '<>', 0)
                ->pluck('name', 'id');
        }

        // Get other companies except the selected company which are linked to this user
        $companiesObj = app('authCompanies');

        $currentCompany = $companiesObj->get($companyId);
        $otherCompanies = $companiesObj->except($companyId);

        //dd($otherCompanies);

        // Get the departments of selected company
        $departments = Department::where('company_id', $companyId)
            ->where('status', Status::Active)
            ->pluck('name', 'id');

        // Get supervisors of selected company
        $supervisors = $this->generateSupervisorTree(companyId:$companyId);

        // Get all designations
        $designations = Designation::pluck('name', 'id');

        // Get zones
        $zones = Zone::where('status', Status::Active)
            ->where('company_id', $companyId)
            ->pluck('name', 'id');

        $lists = Str::generateCompanyTab(routeName:'users.create');

        return view(
            'users.create',
            compact(
                'companyId',
                'roles',
                'otherCompanies',
                'departments',
                'designations',
                'supervisors',
                'currentCompany',
                'zones',
                'lists'
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\User\StoreUserRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request, Company $company)
    {
        // dd($request);
        // Hash the password
        $validated['password'] = Hash::make($request->password);

        // Store validated data into variable
        $data = $request->validated();

        // Set this company ID
        $data['company_id'] = $company->id;

        $companyIds = [];
        if ($request->has('company_ids')) {
            $companyIds = array_merge($companyIds, $request->get('company_ids'));
            unset($data['company_ids']);
        }

        // Zone
        $zoneIds = [];
        if ($request->has('zone_ids')) {
            $zoneIds = $request->get('zone_ids');
            unset($data['zone_ids']);
        }

        // Create the user if successful, otherwise throw error(s)
        DB::beginTransaction();

        try {
            $user = User::create($data);

            if ($user) {
                $user->companies()->sync($companyIds);
                $user->zones()->sync($zoneIds);
            }

            // Process the avatar if user is created in the database and avatar is uploaded
            if ($user && $request->has('avatar')) {
                $uploadedAvatar = $request->file('avatar');

                $imgName = Str::uuid() . '.' . $uploadedAvatar->getClientOriginalExtension();

                $imageDir = 'avatar' . DIRECTORY_SEPARATOR . $user->id;
                $imagePath = $imageDir . DIRECTORY_SEPARATOR . $imgName;

                Storage::makeDirectory($imageDir);

                $storagePathIntervImg = storage_path('app' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR);

                Image::make($uploadedAvatar)
                    ->resize(300, 300, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })
                    ->resizeCanvas(300, 300, 'center', false, null)
                    ->save($storagePathIntervImg . $imagePath);

                // Update the database with processed avatar
                $user->update(['avatar' => $imagePath]);
            }

            DB::commit();

            return redirect()
                ->route('users.index', auth()->user()->company_id == $company->id ? null : $company->id)
                ->with('flash_success', "User created successfully!");
        } catch (Throwable $th) {
            DB::rollBack();

            return response()->json([
                'message' => 'Something went wrong storing data!',
                'errors' => [$th->getMessage()],
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @param int $companyId
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company, User $user)
    {
        $result = $this->checkValidity($company->id);

        if ($result) {
            return $result;
        }
        // Show all roles only if the user creating the new user is an administrator
        // Otherwise show only those roles which are not editable and deletable
        if ($user->isAdministrator()) {
            $roles = Role::pluck('name', 'id');
        } else {
            $roles = Role::where('is_deletable', '<>', 0)
                ->where('is_editable', '<>', 0)
                ->pluck('name', 'id');
        }

        // Get other companies except the selected company which are linked to this user
        $companiesObj = app()->make('authCompanies');

        $currentCompany = $companiesObj->get($company->id);
        $otherCompanies = $companiesObj->except($company->id);

        //
        $selectedOtherCompaniesForUser = CompanyUser::where('company_id', '<>', $company->id)
            ->where('user_id', $user->id)
            ->pluck('company_id', 'company_id'); //check by key not value

        // Departments of selected company
        $departments = Department::where('company_id', $company->id)
            ->where('status', Status::Active)
            ->pluck('name', 'id');

        // Get supervisors of selected company
        $supervisors = $this->generateSupervisorTree(companyId:$company->id, excludeUserId:$user->id);

        // Get all designations
        $designations = Designation::pluck('name', 'id');

        // Get zones
        $zones = Zone::where('status', Status::Active)
            ->where('company_id', $company->id)
            ->pluck('name', 'id');

        // Get user zones
        $selectedUserZonesIds = UserZone::where('user_zones.user_id', $user->id)
            ->pluck('zone_id');

        //dd($selectedUserZonesIds);

        return view(
            'users.edit',
            compact(
                'user',
                'roles',
                'departments',
                'otherCompanies',
                'selectedOtherCompaniesForUser',
                'designations',
                'supervisors',
                'currentCompany',
                'zones',
                'selectedUserZonesIds',
            )
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\User\UpdateUserRequest $request
     * @param  User $user
     * @param int $companyId
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, Company $company, User $user)
    {

        // Store validated data into variable
        $data = $request->validated();

        //block for security purpose
        //$data['company_id'] = $companyId;

        // Get selected company ID
        $companyIds = [];

        if ($request->has('company_ids')) {
            $companyIds = array_merge($companyIds, $request->get('company_ids'));
            unset($data['company_ids']);
        }

        // Zone
        $zoneIds = [];
        if ($request->has('zone_ids')) {
            $zoneIds = $request->get('zone_ids');
            unset($data['zone_ids']);
        }

        DB::beginTransaction();
        try {
            $user->update($data);

            if ($user) {
                $user->companies()->sync($companyIds);
                $user->zones()->sync($zoneIds);
            }

            // Process the avatar if user is created in the database and avatar is uploaded
            if ($user && $request->has('avatar')) {
                $uploadedAvatar = $request->file('avatar');

                $imgName = Str::uuid() . '.' . $uploadedAvatar->getClientOriginalExtension();

                $imageDir = 'avatar' . DIRECTORY_SEPARATOR . $user->id;
                $imagePath = $imageDir . DIRECTORY_SEPARATOR . $imgName;

                Storage::makeDirectory($imageDir);

                $storagePathIntervImg = storage_path('app' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR);

                Image::make($uploadedAvatar)
                    ->resize(300, 300, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })
                    ->resizeCanvas(300, 300, 'center', false, null)
                    ->save($storagePathIntervImg . $imagePath);

                // Update database with processed avatar
                $user->update(['avatar' => $imagePath]);
            }

            DB::commit();

            return redirect()->route('users.index', auth()->user()->company_id == $company->id ? null : $company->id)
                ->with('flash_success', "User updated successfully!");
        } catch (Throwable $th) {
            DB::rollBack();

            return response()->json([
                'message' => 'Something went wrong updating data!',
                'error' => [$th->getMessage()],
            ]);
        }
    }

    /**
     * Delete the specified resource in storage.
     *
     * @param  User $user
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company, User $user)
    {
        try {
            // Delete this user
            $user->delete();

            return redirect()->route("users.index", auth()->user()->company_id == $company->id ? null : $company->id)
                ->with('flash_success', "User deleted successfully!");
        } catch (Throwable $th) {
            return response()->json([
                'message' => 'Something went wrong deleting data!',
                'error' => [$th->getMessage()],
            ]);
        }
    }

    /**
     * Show the form to select company.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function selectCompany(Request $request, $routTo)
    {
        if (!$routTo) {
            return redirect()->back()->with('flash_danger', 'Invalid route paramiter');
        }

        $routeName = Str::replace('-', '.', $routTo);

        if (!Route::has($routeName)) {
            return redirect()->back()->with('flash_danger', 'Invalid route paramiter');
        }

        // Get companies which are linked to this user
        $companies = app()->make('authCompanies');

        // Redirect user to create form directly if user is not linked to more than 1 company
        // Otherwise, show company selection form
        if ($companies->count() && $companies->count() < 2) {
            return redirect()->route($routeName, auth()->user()->company_id);
        } else {
            return view('users.user-company-select', compact('companies', 'routeName'));
        }
    }

    /**
     * Transfer an user to another company.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function userTransfer(Request $request)
    {
        // Validate user's input
        $validator = Validator::make($request->all(), [
            'company_id' => 'required',
            'user_id' => 'required',
        ]);

        // If validation fails, redirect user to specified route with error message
        if ($validator->fails()) {
            return redirect()
                ->route('users.index')
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Replace company to which the user is transfered
            (int) $companyId = $request->company_id;
            (int) $userId = $request->user_id;

            User::where('id', $userId)->update(['company_id' => $companyId]);
            CompanyUser::where('user_id', $userId)->update(['company_id' => $companyId]);

            return back()->with('flash_success', "User is transfered successfully!");
        } catch (Throwable $th) {
            return response()->json([
                'message' => 'Something went wrong transfering the user to another company!',
                'error' => [$th->getMessage()],
            ]);
        }
    }

    /**
     * Filter user list by company.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function companyFilter(Request $request, $companyId): JsonResponse
    {
        $users = $this->getUserData($companyId);

        (int) $companyId = $request->company_id;

        return DataTables::eloquent($users)
            ->filterColumn('company_id', function ($query, int $companyId) {
                (string) $sql = 'users.company_id like ' . $companyId;
                $query->whereRaw($sql, $companyId);
            })
            ->make(true);
    }
}
