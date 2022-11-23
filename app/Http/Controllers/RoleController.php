<?php

namespace App\Http\Controllers;

use App\Http\Requests\Role\StoreRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use App\Models\Company;
use App\Models\Department;
use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermission;
use App\Models\UnitType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->custom_action_arr = ['index' => 'List', 'create' => 'Add Form', 'store' => 'Add', 'edit' => 'Update Form', 'destroy' => 'Delete'];
        view()->share('custom_action_arr', $this->custom_action_arr);
    }

    public function index()
    {
        $roles          = Role::orderBy('is_deletable')->get();
        $roleArr        = Role::pluck('name', 'id');
        $deletableRoles = Role::deletable()->pluck('name', 'id');
        return view('roles.index', compact('roles', 'roleArr', 'deletableRoles'));
    }

    public function create()
    {
        $this->createRolePermission();

        $permission = [];
        $parents    = Permission::where('parent_id', null)
            ->orderBy('name')
            ->pluck('name', 'id')
            ->toArray();
        $childs = Permission::whereIn('parent_id', array_keys($parents))
            ->where('name', '<>', 'systemsRoleUpdate')
            ->get(['name', 'id', 'parent_id']);

        if (count($parents)) {
            foreach ($childs as $ele) {
                $arrr[$ele->parent_id][$ele->id] = $ele->name;
            }

            foreach ($parents as $key => $parent) {
                foreach ($arrr[$key] as $key2 => $child) {
                    $permission[$parent][$key2] = $child;
                }
            }
        }

        return view('roles.create', compact('permission', 'parents'));
    }

    public function store(StoreRoleRequest $request)
    {
        $data = $request->only('name', 'description', 'status', 'is_editable', 'is_deletable');

        if (!$request->exists('is_editable')) {
            $data['is_editable'] = 0;
        }

        if (!$request->exists('is_deletable')) {
            $data['is_deletable'] = 0;
        }

        if (!$request->user()->isAdministrator()) {
            unset($data['is_deletable']);
        }

        $permissions = $request->get('permission_ids');

        $role = Role::create($data);

        if ($role) {
            if ($permissions && count($permissions)) {
                $rolePermissions = $role->permissions()->sync($permissions);
                if ($rolePermissions) {
                    Cache::forget('all_role_pemission_cache');
                    $message = "You have successfully created";
                    return redirect()->route('roles.index')
                        ->with('success', $message);
                } else {
                    $message = "You have successfully created role but no permission set";
                    return redirect()->route('roles.index')
                        ->with('warning', $message);
                }
            } else {
                $message = "You have successfully created role but no permission set";
                return redirect()->route('roles.index')
                    ->with('warning', $message);
            }
        } else {
            $message = "Opps! Something wrong. Please try again.";
            return redirect()->route('roles.create')
                ->with('danger', $message);
        }
    }

    public function edit(Role $role)
    {
        $this->createRolePermission();

        //$role       = Role::findOrFail($id);
        $permission = [];
        $parents    = Permission::where('parent_id', null)
            ->orderBy('name')
            ->pluck('name', 'id')
            ->toArray();
        $childs = Permission::whereIn('parent_id', array_keys($parents))
            ->where('name', '<>', 'systemsRoleUpdate')
            ->get(['name', 'id', 'parent_id']);

        if (count($parents)) {
            foreach ($childs as $ele) {
                $arrr[$ele->parent_id][$ele->id] = $ele->name;
            }

            foreach ($parents as $key => $parent) {
                foreach ($arrr[$key] as $key2 => $child) {
                    $permission[$parent][$key2] = $child;
                }
            }
        }

        return view('roles.edit', compact('permission', 'parents', 'role'));
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {
        $data = $request->only("name", "description", "status", "is_editable", "is_deletable");

        $permissions = request()->get("permissions");

        if (!isset($permissions)) {
            $permissions = [];
        }

        //$role = Role::findOrFail($id);
        $role->fill($data);
        $role->save();
        $permission = $role->permissions()->sync($permissions);

        if ($role) {
            Cache::forget("all_role_pemission_cache");
            $allChanged = array_merge($permission["attached"], $permission["detached"], $permission["updated"]);

            if (!empty($allChanged)) {
                // activity()
                //     ->performedOn($Role)
                //     ->causedBy(auth()->user())
                //     ->withProperties(['role_name' => $Role->name, 'permission_id' => implode(", ", $allChanged)])
                //     ->useLog('Permissions Log')
                //     ->log(':causer.first_name :causer.last_name changed permissions for :subject.name');
            }

            $message = "You have successfully updated";

            return redirect()->route("roles.index")
                ->with('flash_success', $message);
        } else {
            $message = "Opps! Something wrong. Please try again.";

            return redirect()->route("roles.edit", $role->id)
                ->with("flash_danger", $message);
        }
    }

    public function destroy(Request $request, $id)
    {
        if ($countVal = User::where('role_id', $id)->count()) {
            if ($request->has('role_id')) {
                $data = $request->only('role_id');
                User::where('role_id', $id)->update($data);
            } else {
                $message = $countVal . ' ' . Str::plural('user', $countVal) . ' belogings to this role. Assain them another role or delete this user first.';
                return redirect()->route('roles.index')
                    ->with('flash_danger', $message);
            }
        }

        RolePermission::where('role_id', $id)->delete();
        Cache::forget('all_role_pemission_cache');
        $Role = Role::destroy($id);

        if ($Role) {
            $message = "You have successfully deleted";
            return redirect()->route('roles.index')
                ->with('flash_success', $message);
        }
    }

    private function tagsUserToCompanies($users)
    {
        $companies = Company::select('id')
            ->where('id', '<>', auth()->user()->company_id)
            ->get();

        foreach ($users as $user) {
            $user->companies()->sync($companies);
        }
    }

    private function tagsUserDepartmentsToUnitType($users)
    {
        $unitTypes = UnitType::select('id')
            ->whereNull('parent_id')
            ->get();

        foreach ($users as $user) {
            $department = Department::find($user->department_id);
            if ($department) {
                $department->unitTypes()->sync($unitTypes);
            }
        }
    }

    private function permissionToAdministratorAndSuperAdmins()
    {
        $permissions = Permission::pluck('id');
        $roles       = Role::join('users', 'users.role_id', '=', 'roles.id')
            ->where('roles.is_deletable', false)
            ->select('roles.id')
            ->groupBy('roles.id')
            ->get();

        if ($roles->count()) {
            foreach ($roles as $role) {
                $role->permissions()->sync($permissions);

                $users = User::where('role_id', $role->id)
                    ->get();

                if ($users->count()) {
                    $this->tagsUserToCompanies($users);
                    $this->tagsUserDepartmentsToUnitType($users);
                }
            }
        }
    }

    public function systemsRoleUpdate()
    {
        $this->createRolePermission();

        $this->permissionToAdministratorAndSuperAdmins();

        Cache::forget('all_role_pemission_cache');

        App::make('premitedMenuArr');

        $message = "You have successfully added";

        return redirect()->route('dashboard')
            ->with('flash_success', $message);
    }

    private function createRolePermission()
    {
        $allMenuListInserted = App::make('premitedMenuArr');
        $allRoutes           = Route::getRoutes();
        $controllers         = [];

        foreach ($allRoutes as $route) {
            $action = $route->getAction();

            if (is_array($action['middleware']) && in_array('auth.access', $action['middleware'])) {
                $controllerActionName = class_basename($action['controller']);

                if (!in_array($controllerActionName, $allMenuListInserted)) {
                    $controllerAction                                        = explode('@', $controllerActionName);
                    $controllers[$controllerAction[0]][$controllerAction[1]] = $controllerAction[1];
                }
            }
        }

        foreach ($controllers as $key => $controller) {
            $data['name'] = $key;
            $parent       = Permission::firstOrCreate($data);

            if ($parent) {
                $data2['parent_id'] = $parent->id;

                foreach ($controller as $elements) {
                    $data2['name'] = $elements;
                    Permission::firstOrCreate($data2);
                }
            }
        }
    }
}
