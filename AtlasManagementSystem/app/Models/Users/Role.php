<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //Userテーブルとのリレーション定義
    public function user(){
        return $this->belongsToMany(User::class,'role_has_permissions','user_id','role_id');
    }
}
