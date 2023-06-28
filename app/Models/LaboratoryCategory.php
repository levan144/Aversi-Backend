<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class LaboratoryCategory extends Model
{
    use HasFactory, HasTranslations;
    public $translatable = ['title'];
    protected $fillable = ['title','status'];
   
    public function services(){
        return $this->hasMany(LaboratoryService::class,'category_id','id' );
    }
}
