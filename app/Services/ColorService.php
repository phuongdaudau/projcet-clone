<?php
namespace App\Services;

use App\Models\Color;

class ColorService {
    public function getListColor(){
        return Color::latest()->get();
    }
}