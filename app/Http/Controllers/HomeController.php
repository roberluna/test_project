<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $users = User::where('status',true)
            ->orderBy("created_at","DESC")
            ->paginate(10);
        return $users;
    }

    public function destroy(Request $request)
    {
        $user = User::findOrFail($request->id);
        $user->status = false; 
        $user->save();
        return($user);
    }

     public function store(Request $request)
    {
        $user = new User;
        $user->last_name = $request->last_name;
        $user->first_name = $request->first_name;
        $user->email = $request->email;
        $user->status = true;
        $user->password = '';
        $user->save();
        return $user;
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return $user;
    }

    public function update(Request $request)
    {
        $user = User::findOrFail($request->id);
        $user->last_name = $request->last_name;
        $user->first_name = $request->first_name;
        $user->email = $request->email;
        $user->save();
        return $user;
    }
}
