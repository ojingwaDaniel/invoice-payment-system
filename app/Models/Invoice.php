<?php
// app/Models/Invoice.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'user_id',
        'customer_id',
        'invoice_number',
        'issue_date',
        'due_date',
        'currency',
        'discount',
        'notes',
        'total_amount',
        'status',
        'paid',
        'payment_method',
    ];

    protected $casts = [
        'issue_date' => 'date',
        'due_date' => 'date',
        'total_amount' => 'decimal:2',
        'discount' => 'decimal:2',
        'paid' => 'decimal:2',
    ];

    public function items()
    {
        return $this->hasMany(InvoiceItem::class)->with("product");
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
