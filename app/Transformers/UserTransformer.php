<?php

namespace App\Transformers;

use App\Abilities\Link;
use App\Models\User;
use Illuminate\Support\Str;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    public function transform(User $user): array
    {
        $totalOtherCompany = app('authOtherCompanies')->count();

        // Concat name, mobile, email
        $nameMobileEmail = $user->name . '<br>' . $user->mobile . '<br>' . $user->email;

        // Concat company & department
        $companyDepartment = $user->company . ' (' . $user->department . '), <br>' . $user->other_companies;

        //total_other_company

        // Create transfer user link
        if (($user->role_editable || $user->role_deletable) && $totalOtherCompany) {
            $transferUserLink = Link::modal($user->id, '#bb-modal', 'la la-list', 'Transfer', ['menu-link', 'px-3'], 'data-company=' . $user->company_id);
        } else {
            $transferUserLink = '';
        }

        // Create edit link
        $editLink = Link::edit(route('companies.users.edit', [$user->company_id, $user->id]), 'Edit', ['menu-link', 'px-3']);

        // Create delete link
        $deleteLink = Link::delete(route('companies.users.destroy', [$user->company_id, $user->id]), 'Are you sure to delete this user?', ['menu-link', 'px-3']);

        if (!$user->role_deletable) {
            $deleteLink = '';
        }

        return [
            'id' => $user->id,
            'role' => $user->role,
            'name_mobile_email' => $nameMobileEmail,
            'company_department' => $companyDepartment,
            'zones' => $user->zone_names,
            'status' => Str::ucfirst($user->status),
            'action' => Link::generateDropdown($transferUserLink, $editLink, $deleteLink),
        ];
    }

}
