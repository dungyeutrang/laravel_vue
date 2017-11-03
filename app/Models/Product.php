<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model {

    protected $table = 'products';
    
    static public function getAllProduct() {
        return self::all();
    }

}
