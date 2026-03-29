<?php
// File: app/Models/Suggestion.php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Suggestion extends Model {
    protected $fillable = ['name', 'email', 'phone', 'type', 'message', 'is_read'];
    protected $casts = ['is_read' => 'boolean'];
}
