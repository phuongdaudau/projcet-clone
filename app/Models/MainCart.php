<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainCart extends Model
{
    use HasFactory;

    protected $table = 'carts';

    protected $fillable = [
        'product_id',
        'member_id',
        'color',
        'size',
        'quantity'
    ];

    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }
}
