<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    //
    public static function loadData($limit){
        $url = url("/storage");
        $data = DB::table('products')
            ->select(DB::raw("products.*,REPLACE(products.image,'public/','".$url."/') as image_link,categories.category_name"))
            ->leftJoin("categories","products.category_id","=","categories.id")
            ->orderBy("id","desc")
            ->paginate($limit);

        return $data;
    }

    public static function getData($id){
        $data = DB::table('products')
            ->select(DB::raw("products.*,categories.category_name"))
            ->leftJoin("categories","products.category_id","=","categories.id")
            ->where('products.id',$id)->first();
        return $data;
    }
}
