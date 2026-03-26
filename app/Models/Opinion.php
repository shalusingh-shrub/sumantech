<?php
// File: app/Models/Opinion.php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Opinion extends Model {
    protected $fillable = ['name', 'email', 'district', 'school', 'opinion', 'is_approved'];
    protected $casts = ['is_approved' => 'boolean'];
}
