<?php
namespace App\Http\Controllers\Traits;

use App\Models\User;
use App\Models\UserZone;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Column;

trait AllPrivateMethodsForUserController
{
    /**
     * Get user data.
     *
     * @return \Illuminate\Http\Response
     */
    private function getUserData($companyId)
    {
        $subJoinZone = UserZone::join('zones', 'user_zones.zone_id', 'zones.id')
            ->select(
                'user_zones.user_id',
                DB::raw('group_concat(zones.name) as name'
                ),
            )
            ->groupBy('user_zones.user_id');

        return User::select(
            'users.*',
            'roles.name as role',
            'roles.is_editable as role_editable',
            'roles.is_deletable as role_deletable',
            'departments.name as department',
            'companies.name as company',
            'user_zones.name as zone_names',
        )
            ->join('companies', 'companies.id', '=', 'users.company_id')
            ->join('departments', 'departments.id', '=', 'users.department_id')
            ->join('roles', 'roles.id', '=', 'users.role_id')
            ->leftJoinSub($subJoinZone, 'user_zones', function ($join) {
                $join->on('user_zones.user_id', '=', 'users.id');
            })
            ->where('users.company_id', $companyId)
            ->get();
    }

    /**
     * Generate supervisor tree in dropdown list.
     *
     * @param  \Illuminate\Contracts\Support\Arrayable<TKey, TValue>|iterable<TKey, TValue>|null  $excludedUserId
     * @return \Illuminate\Support\Collection<TKey, TValue>
     */
    private function generateSupervisorTree($companyId, $excludeUserId = null)
    {
        $supervisorsObj = User::with('supervisors.supervisors')
            ->where('supervisor_id', null)
            ->where('company_id', $companyId);

        if ($excludeUserId) {
            $supervisorsObj->whereNot('id', $excludeUserId);
        }

        $supervisors = $supervisorsObj->get();
        $arr = [];

        foreach ($supervisors as $val) {

            $arr[$val->id] = $val->name;

            if ($val->supervisors->count()) {
                foreach ($val->supervisors as $v) {
                    $arr[$v->id] = '- ' . $v->name;
                    if ($v->supervisors->count()) {
                        foreach ($v->supervisors as $v1) {
                            $arr[$v1->id] = '-- ' . $v1->name;
                        }
                    }
                }
            }
        }

        return collect($arr);
    }
}
