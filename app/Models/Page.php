<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'title',
        'path',
        'content',
        'tags'
    ];
    
    public function getTagsArrayAttribute()
    {
        return array_filter(array_map('trim', explode(',', $this->tags ?? '')));
    }
}