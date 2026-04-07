<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'invoice_number', 'total_amount', 'paid_amount',
        'discount', 'course_name', 'month', 'description', 'status', 'due_date'
    ];

    protected $casts = [
        'due_date'     => 'date',
        'total_amount' => 'decimal:2',
        'paid_amount'  => 'decimal:2',
        'discount'     => 'decimal:2',
    ];

    protected $dates = ['deleted_at'];

    public function student()
    {
        return $this->belongsTo(Student::class, 'user_id');
    }

    public function payments()
    {
        return $this->hasMany(InvoicePayment::class);
    }

    public function getBalanceAttribute()
    {
        return $this->total_amount - $this->paid_amount - $this->discount;
    }

    public static function generateNumber()
    {
        $prefix = 'INV-' . date('Ym') . '-';
        $last = self::where('invoice_number', 'like', $prefix . '%')->orderBy('id', 'desc')->first();
        $num = $last ? (int) substr($last->invoice_number, strlen($prefix)) + 1 : 1;
        return $prefix . str_pad($num, 4, '0', STR_PAD_LEFT);
    }

    public function updateStatus()
    {
        $balance = $this->total_amount - $this->paid_amount - $this->discount;
        if ($balance <= 0) {
            $this->status = 'paid';
        } elseif ($this->paid_amount > 0) {
            $this->status = 'partial';
        } else {
            $this->status = 'unpaid';
        }
        $this->save();
    }
}
