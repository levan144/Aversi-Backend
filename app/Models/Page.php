<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Page extends Model
{
    use HasFactory, HasTranslations;

    public $translatable = ['title','slug', 'content','meta_desc', 'og_title'];
    
    public function author() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
