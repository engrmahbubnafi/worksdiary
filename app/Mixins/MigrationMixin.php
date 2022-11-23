<?php
namespace App\Mixins;

class MigrationMixin
{

    public function authors()
    {
        return function () {
            $this->integer('created_by')->nullable();
            $this->integer('updated_by')->nullable();
        };
    }
}
