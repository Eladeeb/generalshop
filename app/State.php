<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $table = 'states';
    protected $primaryKey= 'id';

    public function city(){
        return $this->hasMany(City::class,'state_id','id');
    }
    public function country(){
        return $this->belongsTo(Country::class,'country_id','id');
    }

}
