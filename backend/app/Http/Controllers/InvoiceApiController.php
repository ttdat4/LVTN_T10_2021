<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceRequest;
use App\Models\Invoice;
use App\Models\InvoiceDetails;
use App\Models\Product;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoice = Invoice::all();
        foreach ($invoice as $value) {

            foreach ($value->invoicedetails as $value2) {
                $value2->details;
            }

        }
        return response()->json(['invoice' => $invoice], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InvoiceRequest $request)
    {
        try {
            DB::beginTransaction();
            $invoice = json_decode($request->invoice); // từ form chuyển về json xl
            $newInvoice = new Invoice();
            $newInvoice->name = $invoice->name;
            $newInvoice->address = $invoice->address;
            $newInvoice->email = $invoice->email;
            $newInvoice->phonenumber = $invoice->phonenumber;
            $newInvoice->method_payment = $invoice->method_payment;
            $newInvoice->note = $invoice->note;

            $users = User::find($invoice->user_id);
            if (!$users) {
                return response()->json(['message' => "false"], 404);
            }
            $newInvoice->user_id = $users->id;

            $newInvoice->save();

            foreach ($invoice->invoiceDetails as $index => $value) {
                $newInvoiceDetails = new InvoiceDetails();

                $newInvoiceDetails->amount = $value->amount;
                $newInvoiceDetails->size = $value->size;
                $product = Product::find($value->product_id);
                if (!$product) {
                    return response()->json(['message' => "false"], 404);
                }
                $newInvoiceDetails->product_id = $product->id;
                $newInvoiceDetails->price = $product->price;
                $newInvoiceDetails->name = $product->name;
                $newInvoice->invoicedetails()->save($newInvoiceDetails);

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
        $invoice = Invoice::find($id);
        if ($invoice) {
            $invoice->status = $request->status;
            $user = User::find($request->user_id);
            if($user == null)
            {
                return response()->json(['message' => "Sửa thất bại"], 404);
            }
            $invoice->update_by = $request->user_id;
            $invoice->save();

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
        //
    }
}
