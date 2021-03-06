<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductRating extends Model {

    protected $table = 'product_rating';
    public $timestamps = false;
    protected $fillable = [
           'id', 'product_id', 'user_id', 'rating'
    ];
    
    public static function getAllRating(){
        return self::select(['user_id','product_id','rating'])->get();
    }
}
