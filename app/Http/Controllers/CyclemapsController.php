<?php

namespace App\Http\Controllers;
use App\Cycle;

use Illuminate\Http\Request;

class CyclemapsController extends Controller
{
     public function index()
    {
        $data = [];
        if (\Auth::check()) {
            $user = \Auth::user();
                $cycles = Cycle::orderBy('created_at', 'desc')->get();
                
                $data = [
                    'user' => $user,
                    'cycles' => $cycles,
                ];
                
                return view('cycles.cyclemaps', $data);
        }
    }
}