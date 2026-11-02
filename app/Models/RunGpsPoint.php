<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RunGpsPoint extends Model
{
    protected $fillable=['run_id','latitude','longitude','altitude','accuracy','recorded_at'];
    protected $casts=['recorded_at'=>'datetime'];
    public function run(){ return $this->belongsTo(Run::class); }
}
