<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\Models\Service;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
class Branch extends Model implements HasMedia
{
    use HasFactory, HasTranslations, InteractsWithMedia;

    public $translatable = ['title', 'content','description','city','address','gallery'];

    protected $casts = [
        'working_time' => 'array',
        'service_ids' => 'array'
    ];

    public function services(){
        return $this->hasMany(Service::class, 'id')->select('id','title','content','icon');
    }

    public function region(){
        return $this->belongsTo(Region::class, 'region_id', 'id')->select('id', 'title');
    }

    public function images() {
        return $this->hasMany(Media::class, 'model_id')->where('model_type', 'App\Models\Branch');
    }

    protected $hidden = [
     'service_ids',
    ];

    public function searchType()
    {
        return 'Branches';
    }


    

}
