<?php

namespace Modules\File\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class File extends Model
{
    use SoftDeletes;

    protected $table = "files";
    protected $fillable = [
        'module',
        'part',
        'title',
        'p_id',
        'm_id',
        'src',
        'adder',
        'editor',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function adderInfo(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'adder', 'id');
    }

    public function editorInfo(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'editor', 'id');
    }
}
