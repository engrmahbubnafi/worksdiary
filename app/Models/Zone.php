<?php

namespace App\Models;

use App\Enum\Status;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Zone extends BaseModel
{
    use HasFactory;

    protected $guarded = ['id'];

    public function scopeGetZones($query, $request, $requestedCompanyId = null)
    {
        $authId = $request->user()->id;
        $authCompanyId = $request->user()->company_id;

        if (!$requestedCompanyId) {
            $requestedCompanyId = $authCompanyId;
        }

        $query->where('zones.company_id', $requestedCompanyId)
            ->where('zones.status', Status::Active)
            ->select('zones.id', 'zones.name');

        if ($requestedCompanyId == $authCompanyId && UserZone::where('user_id', $authId)->exists()) {

            $query->join('user_zones', 'user_zones.zone_id', '=', 'zones.id')
                ->where('user_zones.user_id', $authId);
        }

        return $query->get();
    }
}
