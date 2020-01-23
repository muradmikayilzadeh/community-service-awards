<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserService extends Model
{
    public function getServiceName(){
        return $this->belongsTo("App\CommunityService","service_id");
    }

    public function getUserName(){
        return $this->belongsTo("App\User","user_id");
    }
}  
