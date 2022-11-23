<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Otp extends BaseModel
{
    use HasFactory;

    protected $guarded = ["id"];

    public function scopeToken($query, $token)
    {
        return $query->where('otps.token', $token);
    }

    public function getUsernameByToken(String $token)
    {
        return $this->select(
            'username'
        )
            ->where('token', $token)
            ->first();
    }

    public function refreshOtp(Model $data, Bool $counter = false)
    {

        $changeableArr = [
            'token' => null,
        ];

        if ($data->username_type) {
            $changeableArr['username_type'] = $data->username_type;
        }

        if ($data->otp) {
            $changeableArr['otp'] = $data->otp;
        } else {
            $changeableArr['otp'] = mt_rand(100001, 999999);
        }

        if ($counter) {
            $changeableArr['count'] = DB::raw('count+1');
        }

        return $this->updateOrCreate(
            ['username' => $data->username],
            $changeableArr
        );

    }

    public function tokenGenerete($username)
    {
        $token = Hash::make('otp_token_' . time());

        if ($this->where('username', $username)
            ->update([
                'token' => $token,
            ])) {
            return $token;
        }
        return null;
    }
}
