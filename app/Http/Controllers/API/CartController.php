<?php

namespace App\Http\Controllers\API;
 
use App\Http\Controllers\Controller;
use Auth;  
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
     /**
    * Function to fetch products
    */
    public function addToCart(Request $request) {
        
        $product_id = $request->get('product_id');
        $quantity = $request->get('quantity');
        $response = array();

        $rules = [  
            'product_id' => 'required|numeric', 
            'quantity' => 'required|numeric|min:1', 
        ];

        $customMessages = [
            "product_id.required" => "Product Id is required.",
            "product_id.numeric" => "Product Id must be numeric.",
            "quantity.required" => "Quantity is required.",
            "quantity.numeric" => "Quantity must be numeric.",
            "quantity.min" => "Greater Then 0",
        ];

        $validator = Validator::make($request->all(), $rules, $customMessages);


        if ($validator->fails()) {
            $response['status'] = 'error';
            $response['message'] = 'Data validation failed!!';
            $response['errors'] = $validator->getMessageBag()->toArray();
            return $response;
        } 

        $is_in_cart = Cart::where('user_id', Auth::user()->id)->where('product_id', $product_id)->exists();
        if($is_in_cart) {
            $response['message'] = 'Product Already in Cart.';
            $response['cart'] = Cart::select('product_id', 'quantity')->where('user_id', Auth::user()->id)->get()->toArray();
            return $response;
        }
        
        Cart::create([
            'user_id' => Auth::user()->id,   
            'product_id' => $product_id,   
            'quantity' => $quantity,
        ]); 

        $response['message'] = 'Product Added To Cart.';
        $response['cart'] = Cart::select('product_id', 'quantity')->where('user_id', Auth::user()->id)->get()->toArray();
        return $response;
    }

     /**
    * Function to fetch products
    */
    public function UpdateCart(Request $request) {
        $product_id = $request->get('product_id');
        $quantity = $request->get('quantity');
        $response = array();

        $rules = [  
            'product_id' => 'required|numeric', 
            'quantity' => 'required|numeric|min:1', 
        ];

        $customMessages = [
            "product_id.required" => "Product Id is required.",
            "product_id.numeric" => "Product Id must be numeric.",
            "quantity.required" => "Quantity is required.",
            "quantity.numeric" => "Quantity must be numeric.",
            "quantity.min" => "Greater Then 0",
        ];

        $validator = Validator::make($request->all(), $rules, $customMessages);


        if ($validator->fails()) {
            $response['status'] = 'error';
            $response['message'] = 'Data validation failed!!';
            $response['errors'] = $validator->getMessageBag()->toArray();
            return $response;
        }  

        $is_in_cart = Cart::where('user_id', Auth::user()->id)->where('product_id', $product_id)->exists();
        if(!$is_in_cart) {
            $response['message'] = 'Product Not Found in Cart.';
            $response['cart'] = Cart::select('product_id', 'quantity')->where('user_id', Auth::user()->id)->get()->toArray();
            return $response;
        }

        Cart::where('user_id', Auth::user()->id)->where('product_id', $product_id)->update(['quantity' => $quantity]);

        $response['message'] = 'Product Update In Cart.';
        $response['cart'] = Cart::select('product_id', 'quantity')->where('user_id', Auth::user()->id)->get()->toArray();
        return $response;
    }

     /**
    * Function to fetch products
    */
    public function deleteCart(Request $request) {
        $product_id = $request->get('product_id');
        $response = array();

        $is_in_cart = Cart::where('user_id', Auth::user()->id)->where('product_id', $product_id)->exists();
        if(!$is_in_cart) {
            $response['message'] = 'Product Not Found in Cart.';
            $response['cart'] = Cart::select('product_id', 'quantity')->where('user_id', Auth::user()->id)->get()->toArray();
            return $response;
        }

        $product_data =  Cart::where('user_id', Auth::user()->id)
              ->where('product_id', $product_id)
              ->delete();
        $response['message'] = 'Product Deleted From Cart.';
        $response['cart'] = Cart::select('product_id', 'quantity')->where('user_id', Auth::user()->id)->get()->toArray();
        return $response;
    }

     /**
    * Function to fetch products
    */
    public function getCartData(Request $request) {
        $cart_data= Cart::select('product_id', 'quantity')->where('user_id', Auth::user()->id)->get()->toArray();
        return $cart_data;
    }
}
