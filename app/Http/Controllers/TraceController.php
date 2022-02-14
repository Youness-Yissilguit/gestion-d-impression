<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TraceController extends Controller
{
    public function indexTrace(){
        $traces = DB::table('tracabilite')->orderBy('created_at', 'desc')->offset(0)->limit(10)->get();
        return view('admin.trace', [
            'traces'=> $traces
        ]);
    }
    public function nextTrace(){
        $traces = DB::table('tracabilite')->orderBy('created_at', 'desc')->offset(0)->limit(request('nbr_trace'))->get();
        return view('admin.trace', [
            'traces'=> $traces
        ]);
    }
}
