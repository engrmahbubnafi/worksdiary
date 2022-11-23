<?php

namespace App\Models;

use App\Models\BaseModel;
use App\Models\FieldGroup;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Field extends BaseModel
{
    use HasFactory;

    protected $guarded = ['id'];

    /**
     * Fetch children who has parent(s).
     */
    public function children()
    {
        return $this->hasMany(Field::class, 'parent_id');
    }

    /**
     * Fetch the fields which are labels and has parent(s).
     */
    public function labelFields()
    {
        return $this->join('field_types', 'field_types.id', 'fields.field_type_id')
            ->whereNotNull('parent_id')
            ->where('input_type', 'label')
            ->get();
    }

    public function group()
    {
        return $this->belongsTo(FieldGroup::class, 'field_group_id');
    }
}
