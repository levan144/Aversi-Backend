<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class CheckupPlan extends Model
{
    use HasFactory, HasTranslations;

    public $translatable = ['title'];
    
    public function checkupServices()
    {
        return $this->belongsToMany(CheckupService::class)->where('parent_id', null);
    }
}