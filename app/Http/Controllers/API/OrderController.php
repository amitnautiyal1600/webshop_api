<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller; 

use Auth;  
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
   /**
    * Function to place order
    */
    public function placeOrder(Request $request) { 
        $response = array();
        $cart_data = Cart::with('product')->where('user_id', Auth::user()->id)->get()->toArray();   

        if(count($cart_data) <= 0){ 
            $response['status'] = 'error';
            $response['message'] = 'No Product Found In cart.';
            return $response;
        } 

        $cart_product_total = 0;  

        foreach ($cart_data as $key => $value) { 
            $cart_product_total += $value['product']['product_price']; 
        }
        
        $order_id = Order::create([
            'user_id' => Auth::user()->id,   
            'order_amount' => $cart_product_total,
            'payment_status' => 'paid',     
        ])->id; 

        foreach($cart_data as $key => $value) {  
            $order_product_id = OrderProduct::create([
                'order_id' => $order_id,    
                'product_id' => $value['product_id'],    
                'product_price' => $value['product']['product_price'],  
                'product_quantity' => $value['quantity'],   
            ])->id; 
        }

        $product_data = Cart::where('user_id', Auth::user()->id)->delete();
        $response['status'] = 'success';
        $response['order_id'] = $order_id;
        $response['message'] = 'Order Place Successfully.';
        
        return $response;
    }

    /**
    * Function to fetch Orders
    */
    public function getOrderData(Request $request) { 
         $order_data = Order::with('user', 'order_product.products')->get()->toArray();  
         return $order_data;
    }

}
