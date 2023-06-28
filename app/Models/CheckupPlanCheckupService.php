<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckupPlanCheckupService extends Model
{
    use HasFactory;
    protected $table = 'checkup_plan_checkup_service';
    
    public function plan()
    {
        return $this->belongsTo(CheckupPlan::class);
    }

    public function service()
    {
        return $this->belongsTo(CheckupService::class);
    }
}
