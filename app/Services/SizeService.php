<?php
namespace App\Services;

use App\Models\Size;

class SizeService {
    public function getListSize(){
        return Size::latest()->get();
    }
}