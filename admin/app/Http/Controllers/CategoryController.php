<?php

namespace App\Http\Controllers;

use App\Category;
use Validator;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //
    public function index(){
        return view('pages.category.index');
    }

    public function getData(Request $request){
        $id = $request->id;
        $Category = Category::find($id);
        $success = true;

        if ( $Category == NULL ){
            $success = false;
        }

        return response()->json([
            'success'=> $success,
            'data'   => $Category
        ], 200);
    }


    public function getTable(Request $request)
    {
        $Category = Category::loadData();

        return $Category;
    }

    public function delete(Request $request){
        $id =$request->id;
        $jenis = Category::find($id);
        if ( $jenis->delete() ){
            $success = true;
            $message = "Hapus category berhasil";
        }else{
            $success = false;
            $message = "Hapus category gagal";
        }
        return response()->json([
            'success' => $success,
            'message' => $message
        ], 200);
    }

    public function save(Request $request){
        $id         = $request->id;
        $category_name      = $request->category_name;


        if (!$id){
            $validator = Validator::make($request->all(), [
                'category_name' => 'required|unique:categories,category_name',
            ]);

            $Category = new Category();
        }else{
            $Category = Category::find($id);
            if ($Category->category_name != $category_name){
                $validator = Validator::make($request->all(), [
                    'category_name' => 'required|unique:categories,category_name',
                ]);
            }else{
                $validator = Validator::make($request->all(), [
                    'category_name' => 'required',
                ]);
            }
        }

        if ($validator->passes()) {

            $Category->category_name       = $category_name;
            if (!$id){
                if ($Category->save()){
                    return response()->json([
                        'success' => true,
                        'message' => 'Tambah category berhasil.'
                    ], 200);
                }else{
                    return response()->json([
                        'success' => false,
                        'message' => 'Tambah category gagal.'
                    ], 200);
                }
            }else{
                if ( $Category->update()){
                    return response()->json([
                        'success' => true,
                        'message' => 'Ubah category berhasil.'
                    ], 200);
                }else{
                    return response()->json([
                        'success' => false,
                        'message' => 'Ubah category gagal'
                    ], 200);
                }

            }
        }

        return response()->json([
            'success' => false,
            'message' => $validator->errors()->all()
        ], 200);

    }

    public function getByName(Request $request)
    {
        $search = $request->search;
        $members = Category::searchByText($search);


        return response()->json($members,200);
    }
}
