<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\Size;
use App\Models\Image;
use App\Models\Supplier;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = Product::all();
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

        return response()->json(['product' => $product], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {

        try {
            DB::beginTransaction();
            $product = json_decode($request->product); // từ form chuyển về json xl
            $newProduct = new Product();
            $newProduct->name = $product->name;
            $newProduct->price = $product->price;
            $newProduct->description =  $product->description;
            $newProduct->url = Str::slug($product->name);

            $category = Category::find($product->category);
            if (!$category) {
                return response()->json(['message' => "false"], 404);
            }
            $newProduct->category_id = $category->id;
            $supplier = Supplier::find($product->supplier);
            if (!$supplier) {
                return response()->json(['message' => "false"], 404);
            }
            $supplier->product()->save($newProduct);

            foreach ($product->size as $index => $size) {
                $newSize = new Size();
                $newSize->name = $size->name;
                $newSize->amount = $size->amount;
                $newProduct->size()->save($newSize);
            }

            if ($request->hasFile('image')) {
                foreach ($request->image as $indexImg => $img) {
                    $newImg = new Image();
                    $file = $img;
                    $extension =  $file->getClientOriginalExtension();
                    $filename = Str::slug($product->name) . rand(1, 1000) . '.' . $extension;
                    $file->move('image/product', $filename);
                    $newImg->urlimg = 'http://' . request()->getHost() . ':8000/image/product/' . $filename;
                    $newProduct->image()->save($newImg);
                }
            }


            DB::commit();
            return response()->json(['message' => "Successful!"], 201);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => "Failure!", "error" => $e->getMessage()], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $find =  Product::find($id);
        if ($find) {
            $find->category;
            $find->supplier;
            foreach ($find->size as $value1) {
                $value1->size;
            }
            foreach ($find->image as $value2) {
                $value2->image;
            }
            return response()->json(['product' => $find], 200);
        }

        return response()->json(['message' => "Not found!"], 404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {

            DB::beginTransaction();

            $product = $request['product'];
            if(empty($product) )
            {
                return response()->json(['message' => "false"], 400);
            }
            $updateProduct = Product::find($id);
            if (isset($product['name'])) {
                $updateProduct->name = $product['name'];
                $updateProduct->url = Str::slug($product['name']);
            }
            if (isset($product['price'])) {
                $updateProduct->price = $product['price'];
            }
            if (isset($product['status'])) {
                $updateProduct->status = $product['status'];
            }
            if (isset($product['description'])) {
                $updateProduct->description = $product['description'];
            }
            if (isset($product['category_id'])) {
                $category = Category::find($product['category_id']);
                if (!$category) {
                    return response()->json(['message' => "false"], 404);
                }
                $updateProduct->category_id = $category->id;
            }
            if (isset($product['supplier_id'])) {
                $supplier = Supplier::find($product['supplier_id']);

                if (!$supplier) {
                    return response()->json(['message' => "false"], 404);
                }
                $supplier->product()->save($updateProduct);
            }

            DB::commit();
            return response()->json(['message' => "true"], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => "false", 'error' => $e->getMessage()], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // try {
        //     $product = Product::find($id);
        //     if ($product) {
        //         $color = Color::where("product_id", "=", $id)->get();
        //         if($color){
        //             foreach($color as $item){
        //                 $size = Size::where("color_id", "=", $item['id']);
        //                 if($size){
        //                     $size->delete();
        //                 }
        //             }
        //         }
        //         $color = Color::where("product_id", "=", $id);
        //         if($color){
        //             $color->delete();
        //         }
        //         $product->delete();
        //         return response()->json(['message' => "true"], 200);
        //     }
        //     else{
        //         return response()->json(['message' => "false"], 404);
        //     }
        // } catch (Exception $e) {
        //     return response()->json(['message' => "false", 'error' => $e->getMessage(),], 400);
        // }
    }

}
