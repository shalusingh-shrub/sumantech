<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentFee extends Model
{
    protected $fillable = [
        'user_id', 'fee_category_id', 'amount', 'status',
        'due_date', 'paid_date', 'payment_method',
        'transaction_id', 'receipt_number', 'remarks', 'collected_by'
    ];

    protected $casts = [
        'due_date'  => 'date',
        'paid_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function feeCategory()
    {
        return $this->belongsTo(FeeCategory::class);
    }

    public function collector()
    {
        return $this->belongsTo(User::class, 'collected_by');
    }

    public static function generateReceiptNumber()
    {
        $prefix = 'ST-' . date('Ym') . '-';
        $last = self::where('receipt_number', 'like', $prefix . '%')->orderBy('id', 'desc')->first();
        $number = $last ? (int) substr($last->receipt_number, strlen($prefix)) + 1 : 1;
        return $prefix . str_pad($number, 4, '0', STR_PAD_LEFT);
    }
}
