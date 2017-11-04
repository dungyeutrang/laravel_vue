<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model {

    protected $table = 'products';
    
    static public function getAllProduct() {
        return self::all();
    }
    
    static public function getAllProductId(){
        return self::select(['id'])->get();
    }
    
    static public function getProductByListProductId($listProductId){
        return self::whereIn('id',$listProductId)->get();
    }

}
