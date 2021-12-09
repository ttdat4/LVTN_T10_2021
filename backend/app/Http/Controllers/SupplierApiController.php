<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupplierRequest;
use App\Models\Supplier;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SupplierApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Supplier::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SupplierRequest $request)
    {
        try{
            DB::beginTransaction();
            $newSupplier = new Supplier();
            $newSupplier-> name = $request->name;
            $newSupplier-> address = $request->address;
            $newSupplier-> phonenumber = $request->phonenumber;
            $newSupplier-> url = Str::slug($request->name);
            $newSupplier->save();
            DB::commit();
            return response()->json(['message' => 'Thêm nhà cung cấp thành công' ],201);

        }
        catch (Exception $e){
            DB::rollBack();
            return response()->json(['message' => 'Thêm nhà cung cấp thất bại','error'=> $e->getMessage()],400 );

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
        $find = Supplier::find($id);
        if (!$find) {
            return response()->json(['message' => 'Không tìm thấy nhà cung cấp cần tìm!'], 404);
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
    public function update(SupplierRequest $request, $id)
    {
        $supplier = Supplier::find($id);
        if ($supplier) {
            $supplier->name = $request->name;
            $supplier-> address = $request->address;
            $supplier-> phonenumber = $request->phonenumber;
            $supplier->url = Str::slug($request->name);
            $supplier->save();

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
            $supplier = Supplier::find($id);
            if ($supplier) {
                $supplier->delete();
                return response()->json(['message' => "Xóa thành công!"], 200);
            }

        } catch (Exception $e) {
            return response()->json(['message' => "false", 'error' => $e->getMessage(),], 400);

        }
    }
}
