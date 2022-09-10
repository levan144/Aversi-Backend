<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use App\Models\Branch;
use App\Models\Service;
class Service extends Model implements HasMedia
{
    use HasFactory, HasTranslations, InteractsWithMedia;

    public $translatable = ['title','content'];

    public function branches() {
        return $this->hasMany(Branch::class, 'id')->select('id', 'type', 'title', 'description', 'address','email','region_id','working_time');
    }

    public function author() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function parentModel(){
      return $this->belongsTo(Service::class, 'parent' ,'id' );
    }

    public function children(){
      return $this->hasMany(Service::class, 'parent', 'id' );
    }

    public function newQuery($excludeDeleted = true) {
      return parent::newQuery($excludeDeleted)
          ->where('status', '=', 1);
  }

    
}
