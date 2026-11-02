<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function edit() { return view('profile'); }
    public function update(Request $request)
    {
        $user=$request->user();
        $data=$request->validate(['name'=>['required','string','max:255'],'email'=>['required','email','max:255',Rule::unique('users')->ignore($user->id)],'password'=>['nullable','current_password'],'new_password'=>['nullable','string','min:8','confirmed']]);
        $user->name=$data['name']; $user->email=$data['email'];
        if (!empty($data['new_password'])) $user->password=Hash::make($data['new_password']);
        $user->save(); return back()->with('success','Profile updated.');
    }
}
