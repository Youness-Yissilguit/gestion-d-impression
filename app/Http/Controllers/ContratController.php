<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contrats;
use Illuminate\Support\Facades\DB;

class ContratController extends Controller
{
    // public function __construct(){
    //     $this->middleware('auth');
    // }

    public function indexContrat(){
        $contrats = Contrats::join('type_cntr', 'contrat.type', '=', 'type_cntr.type_id')
                            ->get();
        return view('admin.contratIndex', [
            'contrats'=> $contrats
        ]);
    }
    public function showContrat($id){
        $contrat = Contrats::where('id', $id)->get();
        $type  = DB::select('select * from type_cntr');
        $imprimantes = DB::select('select id_imprt, nome from imprimante');
        $fournisseurs = DB::select('select f_id, nome, prenom from fournisseur');
        return view('admin.contratShow', [
            'contrat' => $contrat,
            'types' => $type,
            'imprimantes' => $imprimantes,
            'fournisseurs' => $fournisseurs
        ]);
    }
    public function createContrat(){
        $type  = DB::select('select * from type_cntr');
        $imprimantes = DB::select('select id_imprt, nome from imprimante');
        $fournisseurs = DB::select('select f_id, nome, prenom from fournisseur');
        return view('admin.contratShow', [
            'types' => $type,
            'imprimantes' => $imprimantes,
            'fournisseurs' => $fournisseurs
        ]);
    }
    //nouveau contrat
    public function storeContrat(){
        $contrat = new Contrats();
        $contrat->nome = request('nome');
        $contrat->date_debut = request('date_d');
        $contrat->duree = request('duree');
        $contrat->perio_facturation = request('perio_fac');
        $contrat->cout_c = request('cout_c');
        $contrat->cout_nb = request('cout_nb');
        $contrat->id_imprimante  = request('imprimante');
        $contrat->id_fournisseur = request('fournisseur');
        $contrat->type = request('type');
        $contrat->numero = request('numero');
        $contrat->save();
        DB::table('tracabilite')->insert([
            'source' => "Contrat",
            'service' => "Gestion",
            'message' => $_SESSION['role'] . " " .$_SESSION['user_name'] . " a ajoute l'élément " . request('nome'),
            'id_ele' => $contrat->id
        ]);
        return redirect('/contrats')->with('message', 'Contrat creer: ' . request('titre'));
    }
    //delete contrat
    public function distroyContrat($id){
        DB::delete('delete from contrat where id = ?',[$id]);
        DB::table('tracabilite')->insert([
            'source' => "Contrat",
            'service' => "Gestion",
            'message' => $_SESSION['role'] . " " .$_SESSION['user_name'] . " a supprimer l'élément " . $id
        ]);
        return redirect('/contrats')->with('message', 'Contrat a éte supprimer');
    }

    //modify contrat
    public function modifyContrat($id){
        DB::update('update contrat set nome=?, date_debut=?, duree=?,perio_facturation=?,cout_c=?,cout_nb=?, id_imprimante=?,id_fournisseur=?,type=?,numero=?
                    where id = ?',
            [request('nome'),request('date_d'),request('duree'), request('perio_fac'), request('cout_c'), request('cout_nb'),request('imprimante'),
            request('fournisseur'), request('type'),request('numero'), $id]
        );
        DB::table('tracabilite')->insert([
            'source' => "Contrat",
            'service' => "Gestion",
            'message' => $_SESSION['role'] . " " .$_SESSION['user_name'] . " mise à jour l'élément " . request('nome'),
            'id_ele' => $id
        ]);
        return redirect('/contrat_'.$id)->with('message', 'Contrat modifier: ' . request('nome'));
    }
}
