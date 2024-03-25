<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class ProductController extends Controller
{
    public function detail($id, Request $request) {
		$currentTime = Carbon::now();
    	$product = Product::where('id',$id)->first();
		if($product){
    		if ($currentTime < $product->visable_time) {
        		return view('info.waitingpage');
    		}
        }
        if(filled($request->size)) {
            $size = $request->size.'_quantity';
        }
        else {
            $size = 'small_quantity';
        }
    	$ordered = DB::table('ordered_products')->where('ordered_products.product_id','=',$id)->where('ordered_products.customer_id','=',session('customer_uniquekey'))->first();
    	
        $products = DB::table('products')
            ->leftJoin('categories', 'categories.id', '=', 'products.category_id')
            ->where('products.id','=',$id)
            ->select('products.*', 'categories.name')
            ->first();
        $size_category = ['small','medium','large','xlarge'];
        return view('products.product-details',compact('products','size','size_category','ordered'));
    }


}
