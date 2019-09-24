<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class MsgUser extends Model
{
    use AsSource;
    //
    protected $guarded = [];


    /*
    public function card()
    {
        return $this->hasMany('App\DiscountCard', 'discount_id');
    }
    */


}
