<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $users = User::orderBy("created_at","DESC")->limit(10)->get();
        return view('home', compact('users'));
    }
}
