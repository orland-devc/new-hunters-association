<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SecureDataController extends Controller
{
    public function index(Request $request)
    {
        return response()->json([
            'message' => 'Welcome to TrueSight API!',
            'user' => $request->user()
        ]);
    }
}
