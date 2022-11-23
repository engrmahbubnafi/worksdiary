<?php

namespace App\Models;

use App\Enum\Status;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [
        'id',
        'remember_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function supervisor()
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }

    public function supervisors()
    {
        return $this->hasMany(User::class, 'supervisor_id');
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function companies()
    {
        return $this->belongsToMany(Company::class, 'company_users', 'user_id', 'company_id');
    }

    public function zones()
    {
        return $this->belongsToMany(Zone::class, 'user_zones', 'user_id', 'zone_id');
    }

    public function isAdministrator()
    {
        return $this->role()
            ->where('is_editable', false)
            ->where('is_deletable', false)
            ->exists();
    }

    public function roleName()
    {
        return $this->role()->value('name');
    }

    public function scopeEmailVerified($query)
    {
        return $query->whereNotNull('users.email_verified_at');
    }

    public function scopeEmailUnverified($query)
    {
        return $query->whereNull('users.email_verified_at');
    }

    public function scopeActive($query)
    {
        return $query->emailVerified()->where('users.status', Status::Active);
    }

    public function scopeInactive($query)
    {
        return $query->emailVerified()->where('users.status', '<>', Status::Active);
    }

    public function isMobileVerified()
    {
        return $this->mobile_verified_at;
    }

    public function isSuperAdmin()
    {
        return $this->role()
            ->where('is_editable', true)
            ->where('is_deletable', false)
            ->exists();
    }

    public function scopeSuperAdmins($query)
    {
        //use table prefix in select statement for avoiding ambgious issue
        return $query->join('roles', 'roles.id', '=', 'users.role_id')
            ->where('roles.is_editable', true)
            ->where('roles.is_deletable', false);
    }

    public function scopeDeleted($query)
    {
        return $query->onlyTrashed();
    }

    public function scopeAll($query)
    {
        return $query->active();
    }

    public function scopeUnitVisitors($query, $request)
    {
        $companuUnit = CompanyUnit::findOrFail($request->get('company_unit_id'));
        // $unitTypeId = $companuUnit->unit_type_id;
        $zoneId = $companuUnit->zone_id;
        $companyId = $companuUnit->company_id;

        return $query->join('user_zones', 'user_zones.user_id', 'users.id')
            ->join('departments', 'departments.id', 'users.department_id')
            ->join('companies', 'companies.id', 'users.company_id')
            ->join('roles', 'roles.id', 'users.role_id')
            ->join('designations', 'designations.id', 'users.designation_id')
            ->select(
                'users.*',
                'departments.name as department_name',
                'companies.name as company_name',
                'designations.name as designation_name',
                'roles.name as role_name'
            )
            ->active()
            //->where('users.supervisor_id', '<>', null)
            ->where('users.company_id', $companyId)
            ->where('user_zones.zone_id', $zoneId)
            ->get();
    }
}
