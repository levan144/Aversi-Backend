<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class CheckupService extends Model
{
    use HasFactory, HasTranslations;

    public $translatable = ['title'];
    public function plans()
    {
        return $this->belongsToMany(CheckupPlan::class);
    }
    
    public function parent()
    {
        return $this->belongsTo(CheckupService::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(CheckupService::class, 'parent_id');
    }
}