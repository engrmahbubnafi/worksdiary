<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permission extends BaseModel
{
    use HasFactory;

    public $timestamps = false;

    protected $guarded = ['id'];

    public function parent()
    {
        return $this->belongsTo(Permission::class, 'parent_id');
    }

    //each category might have multiple children
    public function children()
    {
        return $this->hasMany(Permission::class, 'parent_id');
    }
}
