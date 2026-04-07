<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model {
    protected $fillable = ['name', 'designation', 'phone', 'email', 'image', 'sort_order', 'status'];

    public function getImageUrlAttribute() {
        if ($this->image) return asset('storage/teachers/' . $this->image);
        return asset('images/default-avatar.png');
    }
}