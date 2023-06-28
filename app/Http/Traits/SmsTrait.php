<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;

trait SmsTrait {

    /**
     * Verify SMS Code
     *
     */
    public function sms_verify($request)
    {
        if($request['sms_code'] == 1234){
            return true;
        } else {
            return false;
        }
        
    }
}