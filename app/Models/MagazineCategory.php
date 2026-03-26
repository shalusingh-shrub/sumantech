<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class MagazineCategory extends Model {
    protected $fillable = ['name', 'slug', 'is_active'];
    protected $casts = ['is_active' => 'boolean'];

    public function magazines() {
        return $this->hasMany(Magazine::class, 'magazine_category_id');
    }
    protected static function boot() {
        parent::boot();
        static::creating(function ($cat) {
            if (empty($cat->slug)) $cat->slug = Str::slug($cat->name);
        });
    }
}
