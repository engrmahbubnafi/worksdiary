<?php

namespace App\Transformers;

use App\Abilities\Link;
use App\Models\Form;
use Illuminate\Support\Str;
use League\Fractal\TransformerAbstract;

class FormTransformer extends TransformerAbstract
{
    /**
     * @param \App\Models\Form $form
     * @return array
     */
    public function transform(Form $form): array
    {
        // Add new field link
        $newField = Link::customLink(route('forms.fields.create', [$form->id]), 'la la-plus', 'New Field', ['menu-link', 'px-3']);

        // Create fields listing link
        $fields = Link::customLink(
            route('forms.fields.index', [$form->id]),
            'la la-list',
            'Fields',
            ['menu-link', 'px-3']
        );

        $fieldGroups = Link::customLink(route('forms.field-groups.index', [$form->id]), 'la la-list', 'FieldGroups', ['menu-link', 'px-3']);

        // Create show form link
        $showLink = Link::show(
            route('companies.forms.show', [$form->company_id, $form->id]),
            'Form View', ['menu-link', 'px-3']
        );

        // Create edit link
        $editLink = Link::edit(
            route('companies.forms.edit', [$form->company_id, $form->id]), 'Edit', ['menu-link', 'px-3']
        );

        // Create delete link
        $deleteLink = Link::delete(
            route('companies.forms.destroy', [$form->company_id, $form->id]), 'Delete', ['menu-link', 'px-3']
        );

        return [
            'id' => (int) $form->id,
            'name' => (string) $form->name,
            'unit_type' => $form->unit_type,
            'status' => (string) Str::ucfirst($form->status),
            // 'is_skippable' => Link::generate($skippableSwitcher),
            'action' => Link::generateDropdown($newField, $fields, $fieldGroups, $showLink, $editLink, $deleteLink),
        ];
    }
}
