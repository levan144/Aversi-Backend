<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Job extends Model
{
    use HasFactory, HasTranslations;

    public $translatable = ['title', 'slug', 'content','position','location'];
    protected $casts = [
    'finish_date' => 'date',
    'start_date' => 'date'
    ];
    public function searchType()
    {
        return 'Vacancy';
    }
  
}
