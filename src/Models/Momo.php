<?php

namespace Delgont\MtnMomo\Models;


use Illuminate\Database\Eloquent\Model;


class Momo extends Model
{
    protected $table = 'momo';


    public static function scopeCollection($query)
    {
        return $query->whereProduct('collection');
    }



    public function options() 
    {
         return $this->hasMany('Delgont\LMomo\Models\Option');
    }




}
