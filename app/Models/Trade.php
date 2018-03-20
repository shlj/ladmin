<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trade extends Model
{
    protected $connection = 'bitcoin';
    protected $table = 'trade';
    //
    const CREATED_AT = 'create_time';
    const UPDATED_AT = 'update_time';

    public function dictType()
    {
        return $this->hasOne(DictType::class);
    }

}
