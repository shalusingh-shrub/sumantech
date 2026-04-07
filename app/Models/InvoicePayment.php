<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvoicePayment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'invoice_id', 'amount', 'payment_date', 'payment_method',
        'transaction_id', 'note'
    ];

    protected $casts = [
        'payment_date' => 'date',
        'amount'       => 'decimal:2',
    ];

    protected $dates = ['deleted_at'];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
