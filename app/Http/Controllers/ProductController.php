<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Price;
use App\Models\PriceDetail;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{

    public function get_products(Request $request){

        $keyword = $request->query('keyword');
        $tier = $request->query('tier');
        $productCategory = $request->query('product_category');
        $paging = $request->input('paging');

        $query = Product::with('Price.PriceDetail');
        // $query = Product::query();
        
        if(!empty($keyword))
        {
            $query = $query->where('Name','LIKE','%'.$keyword.'%');
        }

        if(!empty($tier))
        {
            $query = $query->whereHas('Price.PriceDetail',function($q) use ($tier){
                $q->where('Tier','=',$tier);
            });
        }

        if(!empty($productCategory))
        {
            $query = $query->whereHas('Price',function($q) use ($productCategory){
                $q->where('Product_Category','=',$productCategory);
            });
        }

        $query = $query->paginate($paging);

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
        $productPrices = $request->input('ProductPrices');

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

            if(!empty($productPrices))
            {
                foreach ($productPrices as $key => $value) {
                    $price = new Price();
                    
                    $price->Product_Id = $query->Id;
                    $price->Unit = $value['Unit'];

                    if($price->save())
                    {   
                        foreach ($value['PriceDetails'] as $key => $valPriceDetail) {
                            
                            $priceDetail = new PriceDetail();
    
                            $priceDetail->Price_Id =  $price->Id;
                            $priceDetail->Tier =  $valPriceDetail['Tier'];
                            $priceDetail->Price =  $valPriceDetail['Price'];
    
                            $priceDetail->save();
                        }
                    }
                }
            }

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
        $productPrices = $request->input('ProductPrices');

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

            if(!empty($productPrices))
            {
                foreach ($productPrices as $key => $value) {

                    if(!empty($value['Id'])){
                        $price = Price::where("Id","=",$value['Id'])->update([
                            "Unit" => $value['Unit']
                        ]);
 
                        foreach ($value['PriceDetails'] as $key => $valPriceDetail) {
                            
                            $priceDetail = PriceDetail::where("Id","=",$valPriceDetail["Id"])->update([
                                "Tier" =>  $valPriceDetail['Tier'],
                                "Price" =>  $valPriceDetail['Price']
                            ]);

                        }

                    } else {
                        $price = new Price();
                    
                        $price->Product_Id = $query->Id;
                        $price->Unit = $value['Unit'];
    
                        if($price->save())
                        {   
                            foreach ($value['PriceDetails'] as $key => $valPriceDetail) {
                                
                                $priceDetail = new PriceDetail();
        
                                $priceDetail->Price_Id =  $price->Id;
                                $priceDetail->Tier =  $valPriceDetail['Tier'];
                                $priceDetail->Price =  $valPriceDetail['Price'];
        
                                $priceDetail->save();
                            }
                        }
                    }
                    
                }
            }

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