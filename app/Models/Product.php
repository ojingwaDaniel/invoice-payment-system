<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'category',
        'selling_price',
        'purchase_price',
        'quantity',
        'unit',
        'type',
        'image',
    ];
    protected $casts = [
        'price' => 'decimal:2',
        'tax_percent' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function invoiceItems()
    {
        return $this->hasMany(InvoiceItem::class);
    }
}
