<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(title="Work Diary Api", version="1")
 */

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Check if data is used.
     *
     * @param int $id
     * @param int $field
     * @param string $model
     * @param string $message
     *
     * @return \Illuminate\Http\RedirectResponse|void
     */
    protected function checkIfUsed(int $id, int $field, string $model, string $message = "This data is already used in somewhere else!")
    {
        if (is_array($model)) {
            foreach ($model as $val) {
                (string) $namespace = 'App\Models\\' . $val;
                if ($namespace::where($field, $id)->exists()) {
                    return redirect()->back()->with('flash_danger', $message);
                }
            }
        } else {
            (string) $namespace = 'App\Models\\' . $model;
            if ($namespace::where($field, $id)->exists()) {
                return redirect()->back()->with('flash_danger', $message);
            }
        }
    }

    protected function checkValidity($companyId)
    {
        $authCompanies = app('authCompanies');

        if ($companyId && !$authCompanies->has($companyId)) {
            return redirect()
                ->back()
                ->with('flash_warning', 'Unauthorize access');
        }
        return false;
    }
}
