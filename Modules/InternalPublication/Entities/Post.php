<?php

namespace Modules\InternalPublication\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Catalog\Entities\PostFormat;
use Modules\Catalog\Entities\ScientificGroup;

class Post extends Model
{
    use SoftDeletes;

    protected $table = "posts";
    protected $fillable = [
        'title',
        'author',
        'scientific_group',
        'post_format',
        'adder',
        'editor',
        'created_at',
        'updated_at',
        'deleted_at',
    ];


    public function scientificGroup(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ScientificGroup::class, 'scientific_group', 'id');
    }

    public function postFormat(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(PostFormat::class, 'post_format', 'id');
    }

    public function authorInfo(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'author', 'id');
    }

    public function adderInfo(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'adder', 'id');
    }

    public function editorInfo(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'editor', 'id');
    }
}
