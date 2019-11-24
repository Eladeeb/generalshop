<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use test\Mockery\ReturnTypeObjectTypeHint;

class Review extends Model
{
    protected $fillable=[
        'user_id','product_id','stars','review'
    ];
    public function customer(){
        return $this->belongsTo(User::class,"user_id","id");
    }
    public function product(){
        Return $this->belongsTo(Product::class);
    }
    public function humanFormattedDate(){
        return Carbon::createFromTimeStamp(strtotime($this->created_at))->diffForHumans() ;
    }
}
