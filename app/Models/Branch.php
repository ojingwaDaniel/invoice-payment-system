<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'company_id', 'address',"is_head_office"];
    protected $casts = [
        'is_head_office' => 'boolean',
    ];


    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function accountants()
    {
        return $this->hasMany(User::class)->where('role', 'accountant');
    }
}
