<?php

namespace Modules\Library\Entities;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Library extends Model
{
    use ModelRelations;
    protected $table = 'library';
    protected $fillable = ['id', 'name', 'author', 'post_format', 'subject', 'language', 'publication_date', 'status', 'adder', 'editor', 'created_at', 'updated_at'];
}
