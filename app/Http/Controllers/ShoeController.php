<?php

namespace App\Http\Controllers;

use App\Models\Shoe;
use Illuminate\Http\Request;

class ShoeController extends Controller
{
    private function validateShoe(Request $request): array { return $request->validate(['brand'=>['required','string','max:100'],'model'=>['required','string','max:100'],'mileage_limit_km'=>['required','numeric','min:1'],'purchased_on'=>['nullable','date']]); }
    public function index() { return view('shoes.index',['shoes'=>auth()->user()->shoes()->latest()->get()]); }
    public function store(Request $request) { $data=$this->validateShoe($request); auth()->user()->shoes()->create($data); return back()->with('success','Shoe added.'); }
    public function edit(Shoe $shoe) { abort_unless($shoe->user_id===auth()->id(),403); return view('shoes.edit',compact('shoe')); }
    public function update(Request $request, Shoe $shoe) { abort_unless($shoe->user_id===auth()->id(),403); $shoe->update($this->validateShoe($request)); return redirect()->route('shoes.index')->with('success','Shoe updated.'); }
    public function destroy(Shoe $shoe) { abort_unless($shoe->user_id===auth()->id(),403); $shoe->runs()->update(['shoe_id'=>null]); $shoe->delete(); return back()->with('success','Shoe removed.'); }
}
