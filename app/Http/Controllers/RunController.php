<?php

namespace App\Http\Controllers;

use App\Models\Run;
use App\Models\Shoe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RunController extends Controller
{
    private function validateRun(Request $request): array
    {
        return $request->validate([
            'run_date' => ['required', 'date'], 'distance_km' => ['required', 'numeric', 'min:0.01'],
            'hours' => ['nullable', 'integer', 'min:0'], 'minutes' => ['nullable', 'integer', 'min:0', 'max:59'], 'seconds' => ['nullable', 'integer', 'min:0', 'max:59'],
            'average_hr' => ['nullable', 'integer', 'min:1', 'max:250'], 'max_hr' => ['nullable', 'integer', 'min:1', 'max:250'],
            'elevation_gain_m' => ['nullable', 'integer', 'min:0'], 'run_type' => ['required', 'string'], 'shoe_id' => ['nullable', 'integer'], 'notes' => ['nullable', 'string'],
        ]);
    }

    private function duration(array $data): int { return ((int)($data['hours'] ?? 0)*3600)+((int)($data['minutes'] ?? 0)*60)+(int)($data['seconds'] ?? 0); }
    private function syncShoeMileage(): void { foreach (Shoe::where('user_id', auth()->id())->get() as $shoe) $shoe->update(['mileage_km' => $shoe->runs()->sum('distance_km')]); }

    public function index(Request $request)
    {
        $runs = auth()->user()->runs()->with('shoe')->latest('run_date')->when($request->search, fn($q,$s)=>$q->where(function($q) use($s){$q->where('notes','like',"%$s%")->orWhere('run_type','like',"%$s%");}))
            ->when($request->type, fn($q,$t)=>$q->where('run_type',$t))->when($request->date, fn($q,$d)=>$q->whereDate('run_date',$d))->paginate(10)->withQueryString();
        return view('runs.index', compact('runs'));
    }
    public function create() { return view('runs.create', ['shoes'=>auth()->user()->shoes()->latest()->get()]); }
    public function store(Request $request)
    {
        $data=$this->validateRun($request); abort_if($this->duration($data)<1,422,'Duration must be at least one second.');
        $shoe = $data['shoe_id'] ? Shoe::where('user_id',auth()->id())->findOrFail($data['shoe_id']) : null;
        DB::transaction(fn()=>auth()->user()->runs()->create(array_merge($data,['shoe_id'=>$shoe?->id,'duration_seconds'=>$this->duration($data),'elevation_gain_m'=>$data['elevation_gain_m']??0]))); $this->syncShoeMileage();
        return redirect()->route('runs.index')->with('success','Run saved successfully.');
    }
    public function edit(Run $run) { abort_unless($run->user_id===auth()->id(),403); $time=$run->duration_seconds; return view('runs.edit',['run'=>$run,'shoes'=>auth()->user()->shoes()->get(),'hours'=>intdiv($time,3600),'minutes'=>intdiv($time%3600,60),'seconds'=>$time%60]); }
    public function update(Request $request, Run $run)
    {
        abort_unless($run->user_id===auth()->id(),403); $data=$this->validateRun($request); $shoe=$data['shoe_id']?Shoe::where('user_id',auth()->id())->findOrFail($data['shoe_id']):null;
        DB::transaction(fn()=>$run->update(array_merge($data,['shoe_id'=>$shoe?->id,'duration_seconds'=>$this->duration($data),'elevation_gain_m'=>$data['elevation_gain_m']??0]))); $this->syncShoeMileage();
        return redirect()->route('runs.index')->with('success','Run updated.');
    }
    public function destroy(Run $run) { abort_unless($run->user_id===auth()->id(),403); $run->delete(); $this->syncShoeMileage(); return back()->with('success','Run deleted.'); }
    public function progress() { return view('progress', ['runs'=>auth()->user()->runs()->latest('run_date')->get(),'shoes'=>auth()->user()->shoes()->get()]); }
}
