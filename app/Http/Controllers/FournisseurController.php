<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\fournisseur;
use App\Models\Contrats;
use Illuminate\Support\Facades\DB;

class FournisseurController extends Controller
{
    //all fournisseur
    public function indexFourni(){
        $fournisseurs = fournisseur::all();
        return view('admin.fournisseurIndex', [
            'fournisseurs'=> $fournisseurs
        ]);
    }
    //show fournisseur
    public function showFourni($id){
        $fournisseur = fournisseur::where('f_id', $id)->get();
        $contrats = Contrats::where('id_fournisseur', $id)->get();
        return view('admin.fournisseurShow', [
            'fournisseur' => $fournisseur,
            'contrats' =>$contrats
        ]);
    }
    //new fournisseur
    public function createFourni(){
        return view('admin.fournisseurShow', [
        ]);
    }

    public function storeFourni(){
        $fournisseur = new fournisseur();
        $fournisseur->nome = request('nome');
        $fournisseur->prenom = request('prenom');
        $fournisseur->fax = request('fax');
        $fournisseur->ville = request('ville');
        $fournisseur->adresse = request('adresse');
        $fournisseur->code_postal = request('code_postal');
        $fournisseur->save();
        DB::table('tracabilite')->insert([
            'source' => "Fournisseur",
            'service' => "Gestion",
            'message' => $_SESSION['role'] . " " .$_SESSION['user_name'] . " a ajouter l'élément " . request('nome'),
            'id_ele' => $fournisseur->f_id
        ]);
        return redirect('/fournisseurs')->with('message', 'Fournisseur creer: ' . request('nome'));
    }

    //modify contrat
    public function modifyFourni($id){
        DB::update('update fournisseur set nome=?, prenom=?,fax=?,ville=?,adresse=?,code_postal=?
                    where f_id = ?',
            [request('nome'),request('prenom'),request('fax'), request('ville'), request('adresse'), request('code_postal'), $id]
        );
        DB::table('tracabilite')->insert([
            'source' => "Fournisseur",
            'service' => "Gestion",
            'message' => $_SESSION['role'] . " " .$_SESSION['user_name'] . " mise à jour l'élément " . request('nome'),
            'id_ele' => $id
        ]);
        return redirect('/fournisseur_'.$id)->with('message', 'Fournisseur modifier: ' . request('nome'));
    }

    //delete contrat
    public function distroyFourni($id){
        DB::delete('delete from fournisseur where f_id = ?',[$id]);
        DB::table('tracabilite')->insert([
            'source' => "Fournisseur",
            'service' => "Gestion",
            'message' => $_SESSION['role'] . " " .$_SESSION['user_name'] . " a supprimer l'élément " . $id,
        ]);
        return redirect('/fournisseurs')->with('message', 'Fournisseur a éte supprimer');
    }
}
