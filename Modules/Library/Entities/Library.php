<?php

namespace Modules\Library\Entities;

use App\Traits\ModelRelations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Catalog\Entities\Language;
use Modules\Catalog\Entities\PostFormat;
use Modules\Catalog\Entities\PostSubject;

class Library extends Model
{
    use ModelRelations;

    protected $table = 'library';
    protected $fillable = ['id', 'name', 'author', 'post_format', 'subject', 'language', 'publication_date', 'file', 'status', 'adder', 'editor', 'created_at', 'updated_at'];

    public function postFormatInfo(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(PostFormat::class, 'post_format', 'id');
    }

    public function subjectInfo(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(PostSubject::class, 'subject', 'id');
    }

    public function languageInfo(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Language::class, 'language', 'id');
    }
}
