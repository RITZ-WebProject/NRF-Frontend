<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;

class ShopController extends Controller
{
    public function index(Request $request) {
        	$currentTime = now();

        $productList = Product::where('visable_time','<=',$currentTime)->where('status', '=', 'active')->paginate(9);
        if($request->filled('category')) {
            $searchvalue = $request->category;
            $productList = DB::table('products')
                            ->join('categories','categories.id','=','products.category_id')
                            ->select('products.*', 'categories.name')
                            ->where('categories.name','=',$searchvalue)
            				->where('products.visable_time', '<=', $currentTime)
							->where('products.status', '=', 'active')
                            ->paginate(9);
        }
        $categoryList = Category::get();
        return view('shop.shop',compact('productList','categoryList'));
    }
}
