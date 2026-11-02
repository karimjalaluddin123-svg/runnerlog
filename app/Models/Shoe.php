<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shoe extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'brand', 'model', 'mileage_km', 'mileage_limit_km', 'purchased_on'];

    protected function casts(): array
    {
        return ['purchased_on' => 'date', 'mileage_km' => 'decimal:2', 'mileage_limit_km' => 'decimal:2'];
    }

    public function user() { return $this->belongsTo(User::class); }
    public function runs() { return $this->hasMany(Run::class); }
}
