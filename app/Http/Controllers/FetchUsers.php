<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class FetchUsers extends Controller
{
    public function index()
    {
        return User::with('roles')->get();
    }
}
