<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WishList extends Model
{
    protected $fillable=[
        'wish_list','user_id'
    ];
    public function customer(){
        return $this->belongsTo(User::class);
    }

}
