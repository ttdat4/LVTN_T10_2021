<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'product';
    protected $primaryKey = 'id';
    protected $attributes = [
        'status' => "1",
    ];
    protected $fillable = [
        'name',
        'price',
        'description',
        'url',
    ];
    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function supplier(){
        return $this->belongsTo(Supplier::class);
    }
    public function image(){
        return $this->hasMany(Image::class);
    }
    public function size(){
        return $this->hasMany(Size::class);
    }
    public function invoicedetails(){
        return $this->hasMany(InvoiceDetails::class);
    }
}
