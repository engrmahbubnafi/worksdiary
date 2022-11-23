<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class AjaxController extends Controller
{
    public function getUpazilaData($district_id = null)
    {
        $upazilas = DB::table('upazilas');
        if ($district_id) {
            $upazilas->where('district_id', $district_id);
        }
        return $upazilas->get();
    }
}
