<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    
    Protected $table = 'cuntries';

    Protected $fillable = ['name'];
}
