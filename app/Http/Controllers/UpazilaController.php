<?php

namespace App\Http\Controllers;

use App\Models\Upazila;

class UpazilaController extends Controller
{
    /**
     * Ajax get-upazila-by-district
     *
     * @param [type] $districtId
     * @return void
     */
    public function getUpazilaByDistrict($districtId = null)
    {
        return Upazila::getByDistrict($districtId);
    }
}
