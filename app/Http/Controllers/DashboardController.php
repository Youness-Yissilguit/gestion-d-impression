<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tickets;
use App\Models\Imprimante;
use App\Models\Users;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function indexDashboard(){
        $sum_u = Users::count();
        $sum_imp = Imprimante::count();
        $fourni_sum = DB::table('fournisseur')->count();
        $ticket_sum = Tickets::count();
        $sum_cnt = DB::table('contrat')->count();
        $ticket_r = Tickets::where('statue', 'resolut')->count();
        return view('admin.dashboard', [
            'sum' => $ticket_sum,
            'sum_r' => $ticket_r,
            'sum_nr' => ($ticket_sum - $ticket_r),
            'sum_u' => $sum_u,
            'sum_imp' => $sum_imp,
            'fourni_sum' => $fourni_sum,
            'sum_cnt' => $sum_cnt,
        ]);
    }
}
