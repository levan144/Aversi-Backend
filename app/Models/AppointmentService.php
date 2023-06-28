<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class AppointmentService extends Model
{
    use HasFactory, HasTranslations;
    public $translatable = ['name'];
    public function category() {
        return $this->belongsTo(AppointmentServiceCategory::class, 'category_id');
    }
    
}
