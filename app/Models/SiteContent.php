<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteContent extends Model
{
    protected $fillable = ['section_key', 'title', 'subtitle', 'body', 'image_path', 'meta_json'];

    protected function casts(): array
    {
        return ['meta_json' => 'array'];
    }
}
