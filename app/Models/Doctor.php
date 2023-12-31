<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Translatable\HasTranslations;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
class Doctor extends Authenticatable
{
    use HasFactory, HasTranslations, HasApiTokens, Notifiable, HasRoles;
    public $translatable = ['name'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
       
        'remember_token',
        
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'last_login_at'     => 'datetime',
        'birthday'          => 'date',
        'email_verified_at' => 'datetime',
        'languages'         => 'array',
        'additional'        => 'array',
        'specialty'         => 'array'
        
    ];

    public function specialties(){
        return $this->hasMany(Specialty::class, 'id', 'specialty_ids')->select('id', 'title');
    }

    public function attached_branches(){
        return $this->hasMany(Branch::class, 'id', 'branches')->select('id', 'title');
    }

    public function rating(){
        return ($this->hasMany(Review::class, 'doctor_id')->where('published', 1)->sum('rating') ?? 1) / ($this->hasMany(Review::class, 'doctor_id')->where('published', 1)->count() > 0 ? $this->hasMany(Review::class, 'doctor_id')->where('published', 1)->count() : 1 ) ?? '-';
    }
    
    public function rating_quantity(){
        return $this->hasMany(Review::class, 'doctor_id')->where('published', 1)->count();
    }

    public function reviews(){
        return $this->hasMany(Review::class, 'id', 'doctor_id')->where('published', 1);
    }

    public function searchType()
    {
        return 'Doctors';
    }


    
}
