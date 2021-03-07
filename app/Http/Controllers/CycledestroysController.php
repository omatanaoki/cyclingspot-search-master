<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CycledestroysController extends Controller
{
   public function destroy($id)
    {
        $alert = \App\Cycle::find($id);
      
        $alert->delete();
    
        return redirect('/cycles');
    }
}
