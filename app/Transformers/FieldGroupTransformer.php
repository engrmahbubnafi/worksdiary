<?php

namespace App\Transformers;

use App\Abilities\Link;
use App\Models\FieldGroup;
use Illuminate\Support\Str;
use League\Fractal\TransformerAbstract;

class FieldGroupTransformer extends TransformerAbstract
{
    /**
     * @param \App\Models\FieldGroup $fieldGroup
     * @return array
     */
    public function transform(FieldGroup $fieldGroup): array
    {
        // Create edit link
        $editLink = Link::edit(route('forms.field-groups.edit', [$fieldGroup->form_id, $fieldGroup->id]));

        // Create delete link
        $deleteLink = Link::delete(route('forms.field-groups.destroy', [$fieldGroup->form_id, $fieldGroup->id]));

        return [
            'id' => (int) $fieldGroup->id,
            'name' => (string) $fieldGroup->name,
            'status' => (string) Str::ucfirst($fieldGroup->status),
            'action' => Link::generate($editLink, $deleteLink),
        ];
    }
}
