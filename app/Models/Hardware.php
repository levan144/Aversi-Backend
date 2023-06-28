<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
class Hardware extends Model implements HasMedia
{
    use HasFactory, HasTranslations, InteractsWithMedia;
    protected $table = 'hardwares';
    public $translatable = ['title', 'description'];

    public function images() {
        return $this->hasMany(Media::class, 'model_id')->where('model_type', 'App\Models\Gallery');
    }
}
