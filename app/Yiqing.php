<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Yiqing extends Model
{
    protected $fillable=['id','name','idCard','mobile','areas','beforeLocat','beforeLocatAddr','nowLocat','nowLocatAddr','carNum','companyName'];
}
