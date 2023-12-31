<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Blog extends Model
{
    use HasFactory, HasTranslations;

    public $translatable = ['title', 'slug' , 'content','meta_title', 'meta_desc'];

    public function author() {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function category() {
        return $this->belongsTo(BlogCategory::class, 'category_id');
    }

}
