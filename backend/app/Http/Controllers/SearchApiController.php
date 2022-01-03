<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchApiController extends Controller
{

    public function find($id)
    {
        try{
            $product = Product::where('category_id',$id)->get();
            foreach ($product as $value) {
                $value->category->name;
                $value->supplier->name;
                foreach ($value->image as $value1) {
                    $value1->urlimg;
                }
                foreach ($value->size as $value2) {
                    $value2->name;
                }
            }
            return response()->json(['data' => $product], 200);
        }catch(Exception $e){
            return response()->json(['message' => "false","error"=>$e->getMessage()], 404);
        }
    }
    public function findCategoryHasProduct()
    {
        try{
           $category = DB::table('category')
           -> join ('product','category.id','=','product.category_id')
           -> select('category.id','category.name')
           -> groupBy('category.name')
            -> get();
            return response()->json(['data' => $category], 200);
        }catch(Exception $e){
            return response()->json(['message' => "false","error"=>$e->getMessage()], 404);
        }
    }
    public function sameproduct($id)
    {
        try{
            $find = Product::find($id);
            $product = Product::where('id','<>',$id)->where('category_id', '=',$find->category_id)->get();
            foreach ($product as $value) {
                $value->category->name;
                $value->supplier->name;
                foreach ($value->image as $value1) {
                    $value1->urlimg;
                }
                foreach ($value->size as $value2) {
                    $value2->name;
                }
            }
            return response()->json(['data' => $product], 200);
        }catch(Exception $e){
            return response()->json(['message' => "false","error"=>$e->getMessage()], 404);
        }
    }
}
