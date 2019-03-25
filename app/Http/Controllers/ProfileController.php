<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class ProfileController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $data['profile'] = Auth::user(); 
        return view('profile.index');
    }
    public function create()
    {

    }
    public function store()
    {

    }

    public function edit()
    {

    }

    public function update()
    {

    }
    public function delete()
    {

    }
    
}
