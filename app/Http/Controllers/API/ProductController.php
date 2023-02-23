<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use App\Imports\ProductImport; 
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    /**
    * Function to import products from csv
    */
    public function importProduct(Request $request) {

        $product_data = public_path().'/import-data/products.csv';  

        $data_imported = Excel::import(new ProductImport, $product_data);  

        return response()->json([   
            'message' => 'Product Imported Successfully',
        ], 200);
    }

    /**
    * Function to fetch products
    */
    public function getProducts(Request $request) {
        $product_data = Product::select('id', 'product_name', 'product_price')->where('status',1)->get()->toArray();

        return response()->json([
                'status' => true,
                'message' => 'Products fetched In Successfully', 
                'data' => $product_data, 
            ], 200);
    }

}
