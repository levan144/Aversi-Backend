<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class StaticPage extends Model
{
    use HasFactory, HasTranslations;

    public $translatable = ['title','content'];

    protected $casts = [
        'content' => 'array'
    ];

     public function delete()
    {
    
    return false;
    }
}
