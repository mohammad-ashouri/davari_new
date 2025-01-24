<?php

namespace Modules\Catalog\Entities;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Language extends Model
{
    use ModelRelations;
    protected $table = 'languages';
    protected $fillable = ['id', 'name', 'adder', 'editor', 'created_at', 'updated_at'];
}
