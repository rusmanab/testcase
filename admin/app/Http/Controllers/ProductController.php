<?php

namespace App\Http\Controllers;

use App\Product;
use Validator;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //
    public function index(){
        return view('pages.product.index');
    }
    public function add(){
        return view('pages.product.add');
    }
    public function edit(Request $request){
        $id = $request->id;
        $Product = Product::find($id);
        $data['product'] = $Product;

        return view('pages.product.edit', $data);
    }
    public function getTable(Request $request)
    {
        $Product = Product::loadData();

        return $Product;
    }

    public function delete(Request $request){
        $id =$request->id;
        $jenis = Product::find($id);
        if ( $jenis->delete() ){
            $success = true;
            $message = "Hapus Product berhasil";
        }else{
            $success = false;
            $message = "Hapus Product gagal";
        }
        return response()->json([
            'success' => $success,
            'message' => $message
        ], 200);
    }

    public function save(Request $request){

        $validator = Validator::make($request->all(), [
            'product_name' => 'required',
            'price'        => 'required',
            'category_id'        => 'required',
        ]);

        if ($validator->passes()) {

            $id             = $request->id;
            $product_name   = $request->product_name;
            $category_id    = $request->category_id;
            $product_desc   = $request->product_desc;
            $price          = $request->price;

            if (!$id){
                $Product = new Product();
            }else{
                $Product = Product::find($id);
            }
            $Product->product_name       = $product_name;
            $Product->category_id = $category_id;
            $Product->product_desc = $product_desc;
            $Product->price = $price;

            if (!$id){
                if ($Product->save()){
                    return response()->json([
                        'success' => true,
                        'message' => 'Tambah Product berhasil.'
                    ], 200);
                }else{
                    return response()->json([
                        'success' => false,
                        'message' => 'Tambah Product gagal.'
                    ], 200);
                }
            }else{
                if ( $Product->update()){
                    return response()->json([
                        'success' => true,
                        'message' => 'Ubah Product berhasil.'
                    ], 200);
                }else{
                    return response()->json([
                        'success' => false,
                        'message' => 'Ubah Product gagal'
                    ], 200);
                }

            }
        }

        return response()->json([
            'success' => false,
            'message' => $validator->errors()->all()
        ], 200);

    }
}
