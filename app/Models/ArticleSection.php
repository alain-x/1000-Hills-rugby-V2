<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArticleSection extends Model
{
    protected $fillable = ['article_id', 'subtitle', 'content', 'images', 'sort_order'];

    protected function casts(): array
    {
        return [
            'images' => 'array',
        ];
    }

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }
}
