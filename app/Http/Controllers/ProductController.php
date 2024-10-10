<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{

    public function get_products(Request $request){

        $keyword = $request->input('keyword');
        $tier = $request->input('tier');
        $productCategory = $request->input('product_category');

        $query = Product::query();

        if(!empty($keyword) || !empty($tier) || !empty($productCategory))
        {
            // 
        }

        $query = $query->paginate();

        return response()->json([
            'success' => true,
            'message' => 'Data produk ditemukan!',
            'data' => [
                'data' => $query->getCollection(),
                'page' => $query->currentPage(),
                'total' => $query->total(),
                'limit' => $query->perPage()
              ]
        ]);

    }

    public function get_by_id($id){

        if(empty($id))
        {
            return response()->json([
                'success' => false,
                'message' => 'Id tidak boleh kosong!',
                'data' => (object)[]
            ]);
        }

        $query = Product::with('Price.PriceDetail')->where('Id','=',$id)->first();

        if($query)
        {
            return response()->json([
                'success' => true,
                'message' => 'Data produk ditemukan!',
                'data' => $query
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data produk tidak ditemukan!',
                'data' => (object)[]
            ]);
        }
    }

    public function add(Request $request){

        $name = $request->input('Name');
        $productCategory = $request->input('Product_Category');
        $description = $request->input('Description');

        if(empty($name))
        {
            return response()->json([
                'success' => false,
                'message' => 'Name tidak boleh kosong!',
                'data' => (object)[]
            ]);
        }
        if(empty($productCategory))
        {
            return response()->json([
                'success' => false,
                'message' => 'Product_Category tidak boleh kosong!',
                'data' => (object)[]
            ]);
        }
        if(empty($description))
        {
            return response()->json([
                'success' => false,
                'message' => 'Description tidak boleh kosong!',
                'data' => (object)[]
            ]);
        }

        $query = new Product();

        $query->Name = $name;
        $query->Product_Category = $productCategory;
        $query->Description = $description;

        if($query->save())
        {
            return response()->json([
                'success' => true,
                'message' => 'Berhasil menambah data produk',
                'data' => $query
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambah data produk!!',
                'data' => (object)[]
            ]);
        }
    }

    public function update(Request $request){

        $id = $request->input('Id');
        $name = $request->input('Name');
        $productCategory = $request->input('Product_Category');
        $description = $request->input('Description');

        if(empty($id))
        {
            return response()->json([
                'success' => false,
                'message' => 'Id tidak boleh kosong!',
                'data' => (object)[]
            ]);
        }
        if(empty($name))
        {
            return response()->json([
                'success' => false,
                'message' => 'Name tidak boleh kosong!',
                'data' => (object)[]
            ]);
        }
        if(empty($productCategory))
        {
            return response()->json([
                'success' => false,
                'message' => 'Product_Category tidak boleh kosong!',
                'data' => (object)[]
            ]);
        }
        if(empty($description))
        {
            return response()->json([
                'success' => false,
                'message' => 'Description tidak boleh kosong!',
                'data' => (object)[]
            ]);
        }

        $query = Product::find($id);

        if(!$query)
        {
            return response()->json([
                'success' => false,
                'message' => 'Gagal produk tidak ditemukan!',
                'data' => (object)[]
            ]);
        }

        $updateProduct = Product::where('Id','=',$id)->update([
            "Name" => $name,
            "Product_Category" => $productCategory,
            "Description" => $description
        ]);   

        if($updateProduct)
        {

            $updatedProduct = Product::find($id);

            return response()->json([
                'success' => true,
                'message' => 'Berhasil mengubah data produk',
                'data' => $updatedProduct
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengubah data produk!!',
                'data' => (object)[]
            ]);
        }
    }

    public function delete(Request $request){
        $id = $request->input('Id');

        if(empty($id))
        {
            return response()->json([
                'success' => false,
                'message' => 'Id tidak boleh kosong!',
                'data' => (object)[]
            ]);
        }

        $query = Product::find($id);

        if(!$query)
        {
            return response()->json([
                'success' => false,
                'message' => 'Gagal produk tidak ditemukan!',
                'data' => (object)[]
            ]);
        }

        Product::where('Id','=',$id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil dihapus',
            'data' => (object)[]
        ]);

    }

}