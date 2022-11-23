<?php

namespace App\Transformers;

use App\Abilities\Link;
use App\Models\Department;
use Illuminate\Support\Str;
use League\Fractal\TransformerAbstract;

class DepartmentTransformer extends TransformerAbstract
{
    /**
     * @param \App\Department $department
     * @return array
     */
    public function transform(Department $department): array
    {
        $editLink = Link::edit(route('companies.departments.edit', [$department->company_id, $department->id]));
        $deleteLink = Link::delete(route('companies.departments.destroy', [$department->company_id, $department->id]), message: 'Are you sure to delete this department?');

        return [
            'id' => (int) $department->id,
            'company' => (string) $department->company,
            'name' => (string) $department->name,
            'code' => (string) $department->code,
            'unit_types' => $department->unit_types,
            'status' => (string) Str::ucfirst($department->status),
            'action' => Link::generate($editLink, $deleteLink),
        ];
    }
}
