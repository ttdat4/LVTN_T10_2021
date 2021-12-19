<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceDetails extends Model
{
    use HasFactory;
    protected $table = 'invoicedetails';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'price',
        'size',
        'amount',

    ];
    public function invoice(){
        return $this->belongsTo(Invoice::class);
    }
    public function product(){
        return $this->belongsTo(Product::class);
    }
}
