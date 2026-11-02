<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Run extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'shoe_id', 'run_date', 'distance_km', 'duration_seconds', 'average_hr', 'max_hr', 'elevation_gain_m', 'run_type', 'notes', 'tracking_mode', 'average_speed_kmh', 'started_at', 'finished_at'];

    protected function casts(): array
    {
        return ['run_date' => 'date', 'distance_km' => 'decimal:2', 'started_at' => 'datetime', 'finished_at' => 'datetime'];
    }

    public function user() { return $this->belongsTo(User::class); }
    public function shoe() { return $this->belongsTo(Shoe::class); }
    public function gpsPoints() { return $this->hasMany(RunGpsPoint::class); }
}
