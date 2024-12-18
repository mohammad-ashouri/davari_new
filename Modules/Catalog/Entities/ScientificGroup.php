<?php

namespace Modules\Catalog\Entities;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Model;

class ScientificGroup extends Model
{
    use ModelRelations;
    protected $table = 'scientific_groups';
    protected $fillable = ['id', 'name', 'adder', 'editor', 'created_at', 'updated_at'];

}
