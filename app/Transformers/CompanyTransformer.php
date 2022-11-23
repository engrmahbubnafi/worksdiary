<?php

namespace App\Transformers;

use App\Abilities\Link;
use App\Models\Company;
use Illuminate\Support\Str;
use League\Fractal\TransformerAbstract;

class CompanyTransformer extends TransformerAbstract
{
    public function transform(Company $company): array
    {
        $editLink = Link::edit(route('companies.edit', [$company->id]));
        $deleteLink = Link::delete(route('companies.destroy', [$company->id]), message:'Are you sure to delete this company?');

        return [
            'id' => (int) $company->id,
            'name' => (string) $company->name,
            'code' => (string) $company->code,
            'status' => (string) Str::ucfirst($company->status),
            'action' => Link::generate($editLink, $deleteLink),
        ];
    }
}
