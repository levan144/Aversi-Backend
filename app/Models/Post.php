<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Post extends Model implements HasMedia
{
    use HasFactory, HasTranslations, InteractsWithMedia, LogsActivity;
    
    public $translatable = ['title', 'slug' ,'content'];
    protected static $logAttributes = ['title', 'slug' ,'content'];
    public function author() {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function getActivitylogOptions(): LogOptions {
        return LogOptions::defaults();
    }
    
    public function images() {
        return $this->hasMany(Media::class, 'id')->where('model_type', 'App\Models\Post');
    }
    
    public function searchType()
    {
        return 'News';
    }


    
}
