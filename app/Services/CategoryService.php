<?php
namespace App\Services;

use App\Models\Category;

class CategoryService {
    public function getListCategory(){
        return Category::latest()->get();
    }
}