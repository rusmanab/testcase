<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Category extends Model
{
    //
    public static function loadData(){

        $data = DB::table('categories')->get();

        $dataTable = datatables()->of($data)
                    ->addIndexColumn()
                    ->addColumn('aksi', function($data){
                        $route = "";//route('tarif.edit',[ 'id' =>$data->id]);
                        $html = "<center>";
                        $html = "<a title='Hapus' href='#' class='edit' data-id='".$data->id."' ><span class='fa fa-edit'></span></a> ";
                        $html .= "<a title='Hapus' href='#' class='hapusItem' data-id='".$data->id."' ><span class='fa fa-trash'></span></a>";
                        $html .= "</center>";
                        return $html;
                    })
                    ->addColumn('checkbox', function($data){

                    })
                    ->rawColumns(['checkbox', 'aksi'])
                    ->addIndexColumn()
                    ->make(true);

        return $dataTable;
    }

    public static function searchByText(String $search){
        $members = DB::table('categories')
        ->select(DB::raw("id,category_name as text"))
        ->where('category_name', 'LIKE', '%' . $search . '%')
        ->limit(10)->get();

        return $members;
    }
}
