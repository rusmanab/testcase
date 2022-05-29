<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Contracts\Cache\Store;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Throwable;

class ProductController extends Controller
{
    //
    public function index(Request $request){
        $data = Product::loadData(5);
        $page = 1;
        return view('pages.product.index',compact('data','page'))->render();
    }
    public function add(){
        return view('pages.product.add')->render();
    }
    public function edit(Request $request){
        $id = $request->id;
        $Product = Product::getData($id);
        $data['product'] = $Product;

        return view('pages.product.edit', $data)->render();
    }
    public function getTable(Request $request)
    {

        if($request->ajax())
        {
            $page = $request->page;
            $data = Product::loadData(5);
            return view('pages.product.tableajax', compact('data','page'))->render();
        }
    }



    public function delete(Request $request){
        try {
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
        } catch ( Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->errorInfo[2]
            ], 200);
        }
    }

    public function deleteImage(){

    }
    public function uploadImage(Request $request){
        $path_dokument =  Storage::putFile(
            'public/product',
            $request->file('file')
        );

        if ($path_dokument) {

            return response()->json([
                'success' => true,
                'message' => 'Sukses',
                'imagePath' => $path_dokument,
            ],200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'gagal',
            ],200);
        }
    }

    public function save(Request $request){
        try {
            $id             = $request->id;
            $product_name   = $request->product_name;
            $category_id    = $request->category_id;
            $product_desc   = $request->product_desc;
            $price          = $request->price;
            $image          = $request->image;

            if (!$id){
                $validator = Validator::make($request->all(), [
                    'product_name' => 'required|unique:products,product_name',
                    'price'        => 'required|numeric',
                    'category_id'  => 'required',
                ]);

                $Product = new Product();
            }else{
                $Product = Product::find($id);
                if ($Product->product_name != $product_name){
                    $validator = Validator::make($request->all(), [
                        'product_name' => 'required|unique:products,product_name',
                        'price'        => 'required|numeric',
                        'category_id'  => 'required',
                    ]);
                }else{
                    $validator = Validator::make($request->all(), [
                        'price'        => 'required|numeric',
                        'category_id'  => 'required',
                    ]);
                }
            }

            if ($validator->passes()) {


                $Product->product_name  = $product_name;
                $Product->category_id   = $category_id;
                $Product->product_desc  = $product_desc;
                $Product->price         = $price;
                if ($image){
                    $Product->image         = $image;
                }

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
            $notValid = $validator->errors()->all();
            $notValid = implode("<br/>",$notValid);
            return response()->json([
                'success' => false,
                'message' => $notValid
            ], 200);
        } catch ( Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->errorInfo[2]
            ], 200);
        }
    }
}
