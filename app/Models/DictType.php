<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DictType extends Model
{
    protected $connection = 'bitcoin';
    protected $table = 'dict_type';
    //
   const CREATED_AT = 'create_time';
   const UPDATED_AT = 'update_time';
}
