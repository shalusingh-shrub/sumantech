<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeeCategory extends Model
{
    protected $fillable = ['name', 'description', 'amount', 'is_active'];

    public function studentFees()
    {
        return $this->hasMany(StudentFee::class);
    }
}
