<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sqlserver extends Model
{
    protected $connection = "sqlsrv";
    protected $table = 'dbo.NGAC_USERINFO';
    
}
