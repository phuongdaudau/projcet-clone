<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'admin_id',
        'category_id',
        'name',
        'slug',
        'price',
        'quantity',
        'description',
        'images',
    ]; 

    public function admin()
    {
        return $this->belongsTo('App\Models\Admin');
    }
    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }
    public function members()
    {
        return $this->belongsToMany('App\Models\Member')->withTimestamps();
    }
    public function colors()
    {
        return $this->belongsToMany('App\Models\Color')->withTimestamps();
    }
    public function sizes()
    {
        return $this->belongsToMany('App\Models\Size')->withTimestamps();
    }
    public function mainCarts()
    {
        return $this->hasMany('App\Models\MainCart');
    }
}
