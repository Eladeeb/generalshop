<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table = 'countries';
    protected $primaryKey= 'id';

    public function city(){
        return $this->hasMany(City::class,'country_id','id');
    }

    public function state(){
        return $this->hasMany(City::class,'country_id','id');
    }
}
