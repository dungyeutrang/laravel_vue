<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductRating;
use App\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller {

    const ALPHA = 0.0002;
    const BETA = 0.02;
    // number step
    const STEPS = 5000;
    // number latent 
    const K = 1;
    const THRESHOLD = 0.01;
    const MAX_DISPLAY = 5;
    const RATING_LIKE = 2.5;

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
            $allProductSuggest = array();
            if (Auth::check()) {
                $listProductRating = ProductRating::getAllRating();
                $listProductId = Product::getAllProductId();
                $listUserId = User::getAllUserId();
                $currentUserId = Auth::user()->id;

                $m = count($listUserId);
                $n = count($listProductId);
                $data = array();
                $currentIndexUserId = 0;
                $listProductRatedByCurrentUser = array();
                for ($i = 0; $i < $m; $i++) {
                    if ($listUserId[$i]->id == $currentUserId) {
                        $currentIndexUserId = $i;
                    }
                    for ($j = 0; $j < $n; $j++) {
                        foreach ($listProductRating as $rating) {
                            if ($rating->product_id == $listProductId[$j]->id && $rating->user_id == $listUserId[$i]->id) {
                                $data[$i][$j] = $rating->rating;
                                if ($currentUserId == $listUserId[$i]->id) {
                                    array_push($listProductRatedByCurrentUser, $rating);
                                }
                            }
                        }
                    }
                }

                $totalRating = 0;
                foreach ($listProductRatedByCurrentUser as $rating) {
                    $totalRating += $rating->rating;
                }
                if (!empty($listProductRatedByCurrentUser)) {
                    $ratingAverage = $totalRating / count($listProductRatedByCurrentUser);

                    $dataPredictRating = $this->predictRating($m, $n, $data);
                    $dataRatingForCurrentUser = $dataPredictRating[$currentIndexUserId];
                    
                    arsort($dataRatingForCurrentUser);
                        $listProductSuggest = array();
                    $j = 0;
                    foreach ($dataRatingForCurrentUser as $index => $ratingPredict) {
                        $isExist = false;
                        foreach ($listProductRatedByCurrentUser as $ratingRated) {
                            if ($listProductId[$index]->id == $ratingRated->product_id) {
                                $isExist = true;
                            }
                        }
                        if ($isExist) {
                            continue;
                        }
                        if ($j < self::MAX_DISPLAY && $ratingPredict >= self::RATING_LIKE) {
                            array_push($listProductSuggest, $listProductId[$index]->id);
                            $j++;
                        }
                    }

                    if (!empty($listProductSuggest)) {
                        $allProductSuggest = Product::getProductByListProductId($listProductSuggest);
                    }
                }
            }

            $products = Product::getAllProduct();
            return view('welcome', ['products' => $products, 'productSuggests' => $allProductSuggest]);
        }

        $productId = $request->get('product_id');
        $rate = $request->get('rate');
        $productRating = ProductRating::firstOrNew(array('product_id' => $productId, 'user_id' => Auth::user()->id));
        $productRating->rating = $rate;
        $productRating->save();
    }

    /**
     * matrix predict rating
     * @param type $m
     * @param type $n
     * @param type $R
     * @return type
     */
    private function predictRating($m, $n, $R = array()) {
        $P = $this->randomMatrix($m, self::K);
        $Q = $this->randomMatrix(self::K, $n);
        return $this->matrixFactorization($m, $n, $R, $P, $Q);
    }

    /**
     * 
     * @param type $m
     * @param type $n
     * @param type $R
     * @param type $P
     * @param type $Q
     * @return type
     */
    private function matrixFactorization($m, $n, $R = array(), $P = array(), $Q = array()) {
        $QTranspose = $this->matrixTranspose($Q, self::K, $n);
        for ($step = 1; $step <= self::STEPS; $step++) {
            for ($i = 0; $i < $m; $i++) {
                for ($j = 0; $j < $n; $j++) {
                    if (isset($R[$i][$j]) && $R[$i][$j] > 0) {
                        // error rating
                        $eij = $R[$i][$j] - $this->vectorMuliple($P[$i], $QTranspose[$j]);
                        for ($k = 0; $k < self::K; $k++) {
                            $P[$i][$k] += self::ALPHA * (2 * $eij * $Q[$k][$j] - self::BETA * $P[$i][$k]);
                            $Q[$k][$j] += self::ALPHA * (2 * $eij * $P[$i][$k] - self::BETA * $Q[$k][$j]);
                        }
                    }
                }
            }

            // caculate error
            $QTranspose = $this->matrixTranspose($Q, self::K, $n);
            $errorAll = 0;
            for ($i = 0; $i < $m; $i++) {
                for ($j = 0; $j < $n; $j++) {
                    if (isset($R[$i][$j]) > 0 && $R[$i][$j] > 0) {
                        $errorAll += pow($R[$i][$j] - $this->vectorMuliple($P[$i], $QTranspose[$j]), 2);
                        for ($k = 0; $k < self::K; $k++) {
                            $errorAll += (self::BETA / 2) * (pow($P[$i][$k], 2) + pow($Q[$k][$j], 2));
                        }
                    }
                }
            }
            if ($errorAll < self::THRESHOLD) {
                break;
            }
        }
        return $this->matrixMultiplication($P, $Q);
    }

    /**
     * random matrix
     * @param type $n
     * @param type $m
     * @return array
     */
    private function randomMatrix($n, $m) {
        $data = array();
        for ($i = 0; $i < $n; $i++) {
            for ($j = 0; $j < $m; $j++) {
                $data[$i][$j] = mt_rand() / mt_getrandmax();
            }
        }
        return $data;
    }

    /**
     * multiple matrix
     * @param type $a
     * @param type $b
     */
    private function vectorMuliple($a, $b) {
        $sum = 0;
        $count = count($a);
        for ($i = 0; $i < $count; $i++) {
            $sum += $a[$i] * $b[$i];
        }
        return $sum;
    }

    /**
     * transpose matrix
     * 
     * @param type $A
     * @param type $m
     * @param type $n
     * @return type
     */
    private function matrixTranspose($A, $m, $n) {
        $B = array();
        for ($i = 0; $i < $n; $i++) {
            for ($j = 0; $j < $m; $j++) {
                $B[$i][$j] = $A[$j][$i];
            }
        }
        return $B;
    }

    private function matrixMultiplication($m1, $m2) {
        $r = count($m1);
        $c = count($m2[0]);
        $p = count($m2);
        $m3 = array();
        for ($i = 0; $i < $r; $i++) {
            for ($j = 0; $j < $c; $j++) {
                $m3[$i][$j] = 0;
                for ($k = 0; $k < $p; $k++) {
                    $m3[$i][$j] += $m1[$i][$k] * $m2[$k][$j];
                }
            }
        }
        return($m3);
    }

}
