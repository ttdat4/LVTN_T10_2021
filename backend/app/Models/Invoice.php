<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $table = 'invoice';
    protected $primaryKey = 'id';
    protected $attributes = [
        'status' => "Chưa xử lý",
    ];
    protected $fillable = [
        'name',
        'numberphone',
        'address',
        'create_by',
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function invoicedetails(){
        return $this->hasMany(InvoiceDetails::class);
    }
}
