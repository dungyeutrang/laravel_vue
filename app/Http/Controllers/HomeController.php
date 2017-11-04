<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductRating;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        if ($request->isMethod('GET')) {
            $products = Product::getAllProduct();
            return view('welcome', ['products' => $products]);
        }
        $productId = $request->get('product_id');
        $rate = $request->get('rate');
        $productRating = ProductRating::firstOrNew(array('product_id' => $productId, 'user_id' => Auth::user()->id));
        $productRating->rating = $rate;
        $productRating->save();
    }

}
