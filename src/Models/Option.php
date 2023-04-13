<?php

namespace Delgont\MtnMomo\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $table = 'momo_options';

    protected $fillable = ['key', 'value'];



  
}
