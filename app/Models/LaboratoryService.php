<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class LaboratoryService extends Model
{
    use HasFactory, HasTranslations;
    public $translatable = ['title','content'];

    public function getCategory() {
        return $this->belongsTo(LaboratoryCategory::class,  'category_id');
    }

    public function newQuery($excludeDeleted = true) {
        return parent::newQuery($excludeDeleted)
            ->where('status', '=', 1);
    }
}
