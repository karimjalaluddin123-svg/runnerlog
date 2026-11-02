<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GpsRunController extends Controller
{
    public function tracker() { return view('gps-tracker'); }

    public function save(Request $request)
    {
        $data=$request->validate([
            'distance_km'=>['required','numeric','min:0'], 'duration_seconds'=>['required','integer','min:1'],
            'run_type'=>['required','string'], 'shoe_id'=>['nullable','exists:shoes,id'], 'notes'=>['nullable','string'],
            'started_at'=>['nullable','date'], 'points'=>['nullable','array','max:5000'],
            'points.*.latitude'=>['required_with:points','numeric','between:-90,90'], 'points.*.longitude'=>['required_with:points','numeric','between:-180,180'],
        ]);
        $shoeId=$data['shoe_id'] ? auth()->user()->shoes()->whereKey($data['shoe_id'])->value('id') : null;
        $run=auth()->user()->runs()->create([
            'run_date'=>now()->toDateString(), 'distance_km'=>$data['distance_km'], 'duration_seconds'=>$data['duration_seconds'],
            'elevation_gain_m'=>$request->integer('elevation_gain_m'), 'run_type'=>$data['run_type'], 'shoe_id'=>$shoeId,
            'notes'=>$data['notes'] ?? null, 'tracking_mode'=>'gps', 'average_speed_kmh'=>($data['distance_km'] / ($data['duration_seconds']/3600)),
            'started_at'=>$data['started_at'] ?? now()->subSeconds($data['duration_seconds']), 'finished_at'=>now(),
        ]);
        foreach(array_slice($data['points'] ?? [],0,5000) as $point) $run->gpsPoints()->create(['latitude'=>$point['latitude'],'longitude'=>$point['longitude'],'altitude'=>$point['altitude']??null,'accuracy'=>$point['accuracy']??null,'recorded_at'=>$point['recorded_at'] ?? now()]);
        foreach(auth()->user()->shoes()->get() as $shoe) $shoe->update(['mileage_km'=>$shoe->runs()->sum('distance_km')]);
        return response()->json(['ok'=>true,'run_id'=>$run->id]);
    }
}
