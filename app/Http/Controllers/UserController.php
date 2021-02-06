<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\User;

class UserController extends Controller
{
    public function show(User $user)
    {
        return view('settings', ['user'=>$user]);
    }

    public function update(Request $request, User $user)
    {
        $attributes = request()->validate([
            //'displayname' => ['string', 'required', 'max:30', 'Rule::unique('users'->ignore($user)']
            'name' => ['string', 'required', 'max:255'],
            'email'=> ['string', 'required', 'max:255', Rule::unique('users')->ignore($user)],
            //'password'=> ['string', 'min:8', 'max:255', 'confirmed'],
        ]);

        $user->update($attributes);

        return back();
    }
}
