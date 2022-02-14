<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tickets;
use App\Models\Categorie;
use Illuminate\Support\Facades\DB;

class TicketsController extends Controller
{
    //function to show all tickets
    public function indexTickets(){
        $tickets = Tickets::orderBy('created_at')
                            ->join('categorie', 'tickets.categorie', '=', 'categorie.cat_id')
                            ->join('user', 'user.user_id', '=', 'tickets.created_by')
                            ->select('categorie.nome as cat_name', 'user.nome as username', 'tickets.*')
                            ->get();
        $ticket_sum = Tickets::count();
        $ticket_r = Tickets::where('statue', 'resolut')->count();
        return view('admin/ticketsIndex', [
            'tickets' => $tickets,
            'sum' => $ticket_sum,
            'sum_r' => $ticket_r,
            'sum_nr' => ($ticket_sum - $ticket_r)
        ]);
    }
    public function indexTicketsUser(){
        $tickets = Tickets::orderBy('created_at')
                            ->join('categorie', 'tickets.categorie', '=', 'categorie.cat_id')
                            ->join('user', 'user.user_id', '=', 'tickets.created_by')
                            ->where('tickets.created_by', $_SESSION['user_id'])
                            ->select('categorie.nome as cat_name', 'user.nome as username', 'tickets.*')
                            ->get();
        $ticket_sum = Tickets::where('tickets.created_by', $_SESSION['user_id'])->count();
        $ticket_r = Tickets::where('statue', 'resolut')->where('tickets.created_by', $_SESSION['user_id'])->count();
        return view('admin/ticketsIndex', [
            'tickets' => $tickets,
            'sum' => $ticket_sum,
            'sum_r' => $ticket_r,
            'sum_nr' => ($ticket_sum - $ticket_r)
        ]);
    }
    //see single ticket info
    public function showTickets($id){
        $categorie = Categorie::all();
        $users = DB::select('select nome, prenom, user_id from user');
        $techs = DB::select('select nome, prenom, user_id from user where role =?', ['technicien']);
        $ticket = Tickets::where('ticket_id', $id)->get();
        if( $_SESSION['role'] == 'user' && $_SESSION['user_id'] != $ticket[0]->created_by){
            return abort(404);
        }
        return view('admin/ticketShow', [
           'ticket_id' => $id,
           'ticket' => $ticket,
           'categorie' => $categorie,
           'users' => $users,
           'techs' => $techs
        ]);
    }
    //modify ticket
    public function modifyTicket($id){
        DB::table('tracabilite')->insert([
            'source' => "Tickets",
            'service' => "Ticket",
            'message' => $_SESSION['role'] . " " .$_SESSION['user_name'] . " met à jour un élément",
            'id_ele' => $id
        ]);
        $current_date_time = \Carbon\Carbon::now()->toDateTimeString();
        $demandeur = (request('demandeur') == '') ? $_SESSION['user_id'] : request('demandeur');
        DB::update('update tickets set date_ouvert=?,date_limit=?,titre=?,description=?,statue=?,priorite=?,type=?,categorie=?,attribu_to=?,created_by=?
            ,updated_at=? where ticket_id = ?',
            [request('date_ouvert'),request('date_limit'),request('titre'),request('description'),
            request('statue'),request('priorite'),request('type'),request('categorie'),request('atri_to'),$demandeur, $current_date_time ,$id]
        );
        return redirect('/ticket_'.$id)->with('message', 'Ticket modifer: ' . request('titre'));
    }
    //new ticket
    public function createTicket(){
        $categorie = Categorie::all();
        $users = DB::select('select nome, prenom, user_id from user');
        $techs = DB::select('select nome, prenom, user_id from user where role =?', ['technicien']);
        return view('admin/ticketShow', [
            'categorie' => $categorie,
            'users' => $users,
            'techs' => $techs
        ]);
    }
    //add new ticket
    public function storeTicket(){
        $ticket = new Tickets();
        $ticket->date_ouvert = request('date_ouvert');
        $ticket->date_limit = request('date_limit');
        $ticket->statue = request('statue');
        $ticket->priorite = request('priorite');
        $ticket->type = request('type');
        $ticket->categorie = request('categorie');
        $ticket->attribu_to = request('atri_to');
        $ticket->created_by = (request('demandeur') == '') ? $_SESSION['user_id'] : request('demandeur');
        $ticket->titre = request('titre');
        $ticket->description = request('description');
        $ticket->save();
        DB::table('tracabilite')->insert([
            'source' => "Tickets",
            'service' => "Ticket",
            'message' => $_SESSION['role'] . " " .$_SESSION['user_name'] . " a creer un élément",
            'id_ele' => $ticket->ticket_id
        ]);
        return redirect('/tickets')->with('message', 'Ticket creer: ' . request('titre'));
    }
    //delete tickets
    public function distroyTicket($id){
        DB::delete('delete from tickets where ticket_id = ?',[$id]);
        DB::table('tracabilite')->insert([
            'source' => "Tickets",
            'service' => "Ticket",
            'message' => $_SESSION['role'] . " " .$_SESSION['user_name'] . " a suuprimer un élément",
        ]);
        return redirect('/tickets')->with('message', 'Ticket éte supprimé');
    }

    //handel events add categorie'
    public function addItems(){
        if(request('categorie') != null){
            $categori = new Categorie();
            $categori->nome = request('categorie');
            $categori->save();
            DB::table('tracabilite')->insert([
                'source' => "Catégorie ITIL",
                'service' => "Configuration",
                'message' => $_SESSION['role'] . " " .$_SESSION['user_name'] . " ajoute l'élément " . request('categorie')
            ]);
            return redirect()->back();
        }
        else if(request('reseau') != null){
            DB::insert('insert into reseau (adress) values (?)', [request('reseau')]);
            DB::table('tracabilite')->insert([
                'source' => "reseau",
                'service' => "Configuration",
                'message' => $_SESSION['role'] . " " .$_SESSION['user_name'] . " ajoute l'élément " . request('reseau')
            ]);
            return redirect()->back();
        }
        else if (request('type') != null) {
            DB::insert('insert into type_imp (nome) values (?)', [request('type')]);
            DB::table('tracabilite')->insert([
                'source' => "Statut des éléments",
                'service' => "Configuration",
                'message' => $_SESSION['role'] . " " .$_SESSION['user_name'] . " ajoute l'élément " . request('type')
            ]);
            return redirect()->back();
        }
        else if (request('model') != null) {
            DB::insert('insert into modele (mod_name) values (?)', [request('model')]);
            DB::table('tracabilite')->insert([
                'source' => "Statut des éléments",
                'service' => "Configuration",
                'message' => $_SESSION['role'] . " " .$_SESSION['user_name'] . " ajoute l'élément " . request('model')
            ]);
            return redirect()->back();
        }
        else if (request('lieu_name') != null) {
            DB::insert('insert into lieu (nome, adress, code_postal, ville, payer) values (?, ?, ?, ?, ?)',
                        [request('lieu_name'), request('adress'), request('code_postal'), request('ville'), request('payer')]
                      );
            DB::table('tracabilite')->insert([
                'source' => "Lieu",
                'service' => "Configuration",
                'message' => $_SESSION['role'] . " " .$_SESSION['user_name'] . " ajoute l'élément " . request('lieu_name')
            ]);
            return redirect()->back();
        }
        else if (request('contrat_type') != null) {
            DB::insert('insert into type_cntr (name) values (?)',
                        [request('contrat_type')]
                );
            DB::table('tracabilite')->insert([
                    'source' => "Type de contrat",
                    'service' => "Configuration",
                    'message' => $_SESSION['role'] . " " .$_SESSION['user_name'] . " ajoute l'élément " . request('contrat_type')
            ]);
            return redirect()->back();
        }
        else {
            return abort(404);
        }
    }
}
