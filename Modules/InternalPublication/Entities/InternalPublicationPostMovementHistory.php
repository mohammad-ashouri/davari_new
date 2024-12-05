<?php

namespace Modules\InternalPublication\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\File\Entities\File;

class InternalPublicationPostMovementHistory extends Model
{

    protected $table = "internal_publication_post_movement_histories";
    protected $fillable = [
        'p_id',
        'type',
        'description',
        'adder',
        'created_at',
        'updated_at',
    ];

    public function adderInfo(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'adder', 'id');
    }

    public function editorInfo(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'editor', 'id');
    }

    public function getMovementFiles(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(File::class, 'p_id', 'p_id');
    }
}
