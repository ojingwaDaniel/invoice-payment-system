<?php

// app/Http/Requests/StoreInvoiceRequest.php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'customer_id' => ['required', 'exists:customers,id'],
            'issue_date'  => ['required', 'date'],
            'due_date'    => ['nullable', 'date', 'after_or_equal:issue_date'],
            'currency'    => ['required', 'string'],
            'items'       => ['required', 'array', 'min:1'],
            'items.*.quantity'  => ['required', 'numeric', 'min:0.01'],
            'items.*.rate'      => ['required', 'numeric', 'min:0'],
            'items.*.tax_percent' => ['nullable', 'numeric', 'min:0'],
            'items.*.discount'  => ['nullable', 'numeric', 'min:0'],
        ];
    }
}
