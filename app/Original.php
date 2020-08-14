<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Original extends Model
{
    use SoftDeletes;
    protected $table = 'originals';
    protected $dates = ['deleted_at'];

}
