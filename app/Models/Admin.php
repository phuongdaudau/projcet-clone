<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'image',
    ];

    public function products()
    {
        return $this->hasMany('App\Models\Product');
    }

}
 