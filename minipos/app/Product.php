<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    //
    public static function loadData(){

        $data = DB::table('products')->leftJoin("categories","products.category_id","=","categories.id")->get();

        $data = DB::table('products')
                ->select(DB::raw("products.*,categories.category_name"))
                ->leftJoin("categories","products.category_id","=","categories.id")
                ->get();

        $dataTable = datatables()->of($data)
                    ->addIndexColumn()
                    ->addColumn('aksi', function($data){
                        $route = route('product.edit',[ 'id' =>$data->id]);
                        $html = "<center>";
                        $html = "<a title='Hapus' href='".$route."' class='edit' data-id='".$data->id."' ><span class='fa fa-edit'></span></a> ";
                        $html .= "<a title='Hapus' href='#' class='hapusItem' data-id='".$data->id."' ><span class='fa fa-trash'></span></a>";
                        $html .= "</center>";
                        return $html;
                    })
                    ->rawColumns(['checkbox', 'aksi'])
                    ->addIndexColumn()
                    ->make(true);

        return $dataTable;
    }
}
