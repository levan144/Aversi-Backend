<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
class Gallery extends Model implements HasMedia
{
    use HasFactory, HasTranslations, InteractsWithMedia;
    public $translatable = ['title'];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'video', 'photo', 'type','status'
       
    ];

    public function images() {
        return $this->hasMany(Media::class, 'model_id')->where('model_type', 'App\Models\Gallery');
    }
    
    public function registerMediaConversions(Media $media = null): void
    {
    $this->addMediaConversion('thumb')
        ->width(130)
        ->height(130);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('gallery');
    }
}
