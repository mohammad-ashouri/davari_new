<?php

namespace App\Models\Catalogs;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Model;

class PostFormat extends Model
{
    use ModelRelations;
    protected $table = 'post_formats';
    protected $fillable = ['id', 'name', 'adder', 'editor', 'created_at', 'updated_at'];

}
