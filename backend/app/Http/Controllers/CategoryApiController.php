<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoryApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return DB::table('category')->orderBy('id','DESC')->get();
    }




    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        try{
            DB::beginTransaction();
            $newCategory = new Category();
            $newCategory-> name = $request->name;
            $newCategory-> url = Str::slug($request->name);
            $newCategory->save();
            DB::commit();
            return response()->json(['message' => 'Thêm danh mục thành công' ],201);

        }
        catch (Exception $e){
            DB::rollBack();
            return response()->json(['message' => 'false','error'=> $e->getMessage()],400 );

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
        $find = Category::find($id);
        if (!$find) {
            return response()->json(['message' => 'Không tìm thấy danh mục cần tìm!'], 404);
        }
        return $find;
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request,$id)
    {
        $category = Category::find($id);
        if ($category) {
            $category->name = $request->name;
            $category->url = Str::slug($request->name);
            $category->save();

            return response()->json(['message' => "Sửa thành công!"], 200);
        }
        return response()->json(['message' => "Sửa thất bại"], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $category = Category::find($id);
            if ($category) {
                $category->delete();
                return response()->json(['message' => "Xóa thành công!"], 200);
            }

        } catch (Exception $e) {
            return response()->json(['message' => "false", 'error' => $e->getMessage(),], 400);

        }
    }
}
