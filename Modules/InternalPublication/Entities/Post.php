<?php

namespace Modules\InternalPublication\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Catalog\Entities\PostFormat;
use Modules\Catalog\Entities\ScientificGroup;
use Modules\File\Entities\File;

class Post extends Model
{
    use SoftDeletes;

    protected $table = "posts";
    protected $fillable = [
        'title',
        'author',
        'scientific_group',
        'post_format',
        'description',
        'status',
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

    public function getInitFile(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(File::class, 'id', 'p_id')
            ->where('module', 'internal_publication')
            ->where('part', 'post')
            ->where('title', 'init');
    }
}
