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
        'vat_amount',
        'is_sent',
        'paid_at',
        'company_id',
        'branch_id',
        'created_by'
    ];

    protected $casts = [
        'issue_date' => 'date',
        'due_date' => 'date',
        'total_amount' => 'decimal:2',
        'discount' => 'decimal:2',
        'paid' => 'decimal:2',
        'is_sent' => 'boolean',
        'paid_at' => 'datetime',
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

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
    public function company(){
        return $this->belongsTo(Company::class);
    }
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    protected static function booted()
    {
        // When created
        static::created(function ($invoice) {
            \App\Models\ActivityLog::create([
                'user_id'   => auth()->id(),
                'action'    => 'created',
                'model'     => 'Invoice',
                'model_id'  => $invoice->id,
                'old_values' => null,
                'new_values' => $invoice->getAttributes(),
                'branch_id'  => $invoice->branch_id,
                'company_id' => $invoice->company_id,
            ]);
        });

        // When updated
        static::updating(function ($invoice) {
            $old = $invoice->getOriginal();
            $new = $invoice->getDirty(); // changed fields only

            \App\Models\ActivityLog::create([
                'user_id'    => auth()->id(),
                'action'     => 'updated',
                'model'      => 'Invoice',
                'model_id'   => $invoice->id,
                'old_values' => $old,
                'new_values' => $new,
                'branch_id'  => $invoice->branch_id,
                'company_id' => $invoice->company_id,
            ]);
        });

        // When deleted
        static::deleted(function ($invoice) {
            \App\Models\ActivityLog::create([
                'user_id'    => auth()->id(),
                'action'     => 'deleted',
                'model'      => 'Invoice',
                'model_id'   => $invoice->id,
                'old_values' => $invoice->getAttributes(),
                'new_values' => null,
                'branch_id'  => $invoice->branch_id,
                'company_id' => $invoice->company_id,
            ]);
        });
    }
}
