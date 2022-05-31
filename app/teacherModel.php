<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class teacherModel extends Model
{
    public $table='teashers';
    public $primaryKey='id';
    public $incrementing=true;
    public $keyType='int';
    public $timestamps=false;
}
