<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Product;
use Validator;
use Illuminate\Http\Request;
use Throwable;

class ProductController extends Controller
{
    //

    public function getAll(Request $request){
        $id = $request->id;
        $Product = Product::loadData(4);

        return response()->json([
            'success' => true,
            'products' => $Product
        ], 200);
    }



}
