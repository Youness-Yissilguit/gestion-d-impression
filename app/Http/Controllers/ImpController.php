<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Imprimante;
use Illuminate\Support\Carbon;
use function Ramsey\Uuid\v1;

class ImpController extends Controller
{
    public $compteur = '';
    public function indexImprimantes(){
        $imprimantes = Imprimante::orderBy('imprimante.nome')
                                    ->join('lieu', 'imprimante.lieu_instal', '=', 'lieu.lieu_id')
                                    ->join('type_imp', 'imprimante.type', '=', 'type_imp.type_id_imp')
                                    ->join('modele', 'imprimante.model', '=', 'modele.id')
                                    ->select('lieu.nome as lieu_nome', 'type_imp.nome as type_nome', 'mod_name', 'imprimante.*')
                                    ->get();
        return view('admin.imprimantesIndex', [
            'imprimantes'=> $imprimantes
        ]);
    }

    public function showImprimante($id){
        $imprimante = Imprimante::where('id_imprt', $id)->get();
        $compteur = DB::select('select * from compteur where id_imp = ?', [$id]);
        $reseaux = DB::select('select * from reseau');
        $models = DB::select('select * from modele');
        $lieux = DB::select('select * from lieu');
        $types = DB::select('select * from type_imp');
        $users = DB::select('select user_id,nome,prenom from user where role=?', ['user']);
        $_SESSION['compteur'] = $compteur[0]->nbt_impr ?? '';
        $curr_lieu = DB::select('select * from lieu where lieu_id = ?', [$imprimante[0]->lieu_instal]);
        $_SESSION['lieu'] = $curr_lieu[0]->nome ?? '';
        return view('admin/imprimanteShow', [
            'imprimante' => $imprimante,
            'reseaux' => $reseaux,
            'models' => $models,
            'types' => $types,
            'lieux' => $lieux,
            'users' => $users,
            'compteur' => $compteur
        ]);
    }
    //creer imprimante
    public function createImprimante(){
        $reseaux = DB::select('select * from reseau');
        $models = DB::select('select * from modele');
        $lieux = DB::select('select * from lieu');
        $types = DB::select('select * from type_imp');
        $users = DB::select('select user_id,nome,prenom from user where role=?', ['user']);
        return view('admin/imprimanteShow', [
            'reseaux' => $reseaux,
            'models' => $models,
            'types' => $types,
            'lieux' => $lieux,
            'users' => $users
        ]);
    }
    //modify imprimante
    public function modifyImprimante($id){
        $current_date_time = \Carbon\Carbon::now()->toDateTimeString();
        DB::update('update imprimante set nome=?,num_serie=?,lieu_instal =?,model =?,reseau=?,type =?,utilisateur =?,
            updated_at=? where id_imprt  = ?',
            [request('nome'),request('num_serie'),request('lieu'),request('model'),
            request('reseau'),request('type'),request('user'), $current_date_time,$id]
        );
        DB::table('tracabilite')->insert([
            'source' => "imprimante",
            'service' => "Parc",
            'message' => $_SESSION['role'] . " " .$_SESSION['user_name'] . " mis à jour l'élément " . request('nome'),
            'id_ele' => $id
        ]);
        if(request('compteur') > $_SESSION['compteur']){
            DB::update('update compteur set nbt_impr=? where id_imp=?',[request('compteur'), $id]);
            DB::table('compteur_trace')->insert([
                'id_imp' => $id,
                'compteur' => $_SESSION['compteur'],
                'lieu' => $_SESSION['lieu'],
                'date_relver' => (request('date_relver') == '') ? $current_date_time : date('Y-m-d H:i:s', strtotime(request('date_relver')))
            ]);
        }elseif (request('compteur') < $_SESSION['compteur']){
            return redirect('/imprimante_'.$id)->with('error', 'le compteur ne doit pas avoir une valeur inférieur à l\'ancienne');
        }
        return redirect('/imprimante_'.$id)->with('message', 'Imprimante modifier: ' . request('nome'));
    }
    //add new imprimante
    public function storeImprimante(){
        $imprimant = new Imprimante();
        $imprimant->nome = request('nome');
        $imprimant->num_serie = request('num_serie');
        $imprimant->lieu_instal = request('lieu');
        $imprimant->model = request('model');
        $imprimant->reseau = request('reseau');
        $imprimant->type = request('type');
        $imprimant->utilisateur = request('user');
        $imprimant->cmpt_inc = request('cmpt_inc');
        $imprimant->date_instal = request('date_instal');
        $imprimant->save();
        // DB::table('compteur_trace')->insert([
        //     'id_imp' => $imprimant->id,
        //     'compteur' => request('cmpt_inc'),
        //     'date_relver' => date('Y-m-d H:i:s', strtotime(request('date_instal'))),
        // ]);
        DB::table('compteur')->insert([
            'id_imp' => $imprimant->id,
            'nbt_impr' => request('cmpt_inc'),
        ]);
        DB::table('tracabilite')->insert([
            'source' => "imprimante",
            'service' => "Parc",
            'message' => $_SESSION['role'] . " " .$_SESSION['user_name'] . " ajoute l'élément " . request('nome'),
            'id_ele' => $imprimant->id
        ]);
        return redirect('/imprimantes')->with('message', 'Imprimante creer: ' . request('nome'));
    }
    //delete imprimantes
    public function distroyImprimante($id){
        DB::delete('delete from imprimante where id_imprt = ?',[$id]);
        DB::table('tracabilite')->insert([
            'source' => "imprimante",
            'service' => "Parc",
            'message' => $_SESSION['role'] . " " .$_SESSION['user_name'] . " a supprimé l'élément " . $id
        ]);
        return redirect('/imprimantes')->with('message', 'Imprimante a ete supprimer');
    }
}
