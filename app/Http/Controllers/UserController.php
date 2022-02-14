<?php

namespace App\Http\Controllers;

use App\Models\Tickets;
use Illuminate\Http\Request;
use App\Models\Users;
use Illuminate\Support\Facades\DB;
use App\Models\Imprimante;

class UserController extends Controller
{
        //function to show all users
        public function indexUsers(){
            $users = Users::all();
            return view('admin/usersIndex', [
                'users' => $users
            ]);
        }
        //see single user info
        public function showUser($id){
            $user = Users::where('user_id', $id)->get();
            $tickets = Tickets::where('created_by', $id)
                                ->join('categorie', 'tickets.categorie', '=', 'categorie.cat_id')
                                ->select('categorie.nome as cat_name', 'tickets.*')
                                ->get();
            $imprimantes = Imprimante::where('utilisateur', $id)
                                        ->join('lieu', 'imprimante.lieu_instal', '=', 'lieu.lieu_id')
                                        ->join('type_imp', 'imprimante.type', '=', 'type_imp.type_id_imp')
                                        ->join('modele', 'imprimante.model', '=', 'modele.id')
                                        ->select('lieu.nome as lieu_nome', 'type_imp.nome as type_nome', 'mod_name', 'imprimante.*')
                                        ->get();
            return view('admin/userShow', [
                'user' => $user,
                'tickets'=> $tickets,
                'imprimantes'=> $imprimantes
            ]);
        }
        //create user page
        public function createUser(){
            return view('admin/userShow', []);
        }
        //add new user
        public function storeUser(){
            $user = new Users();
            $user->nome = request('nome');
            $user->prenom = request('prenom');
            $user->telephone = request('telephone');
            $user->telephone_mobile = request('telephone_mobile');
            $user->identifiant = request('identifiant');
            $user->mode_de_pass = request('mode_de_pass');
            $user->role = request('role');
            $user->adress = request('adress');
            $user->email = request('email');
            $user->save();
            DB::table('tracabilite')->insert([
                'source' => "Utilisateur",
                'service' => "Configiration",
                'message' => $_SESSION['role'] . " " .$_SESSION['user_name'] . " a ajoute l'élément " . request('nome'),
                'id_ele' => $user->user_id
            ]);
            return redirect('/administration')->with('message', 'Utilisateur Creer: ' . request('nome'));
        }
        //modify user
        public function modifyUser($id){
            $current_date_time = \Carbon\Carbon::now()->toDateTimeString();
            DB::update('update user set nome=?,prenom=?,telephone=?,telephone_mobile=?,identifiant=?,mode_de_pass=?,role=?,adress=?,email=?,
                updated_at=? where user_id = ?',
                [request('nome'),request('prenom'),request('telephone'),request('telephone_mobile'),
                request('identifiant'),request('mode_de_pass'),request('role'),request('adress'),request('email'), $current_date_time,$id]
            );
            DB::table('tracabilite')->insert([
                'source' => "Utilisateur",
                'service' => "Configiration",
                'message' => $_SESSION['role'] . " " .$_SESSION['user_name'] . " mise à jour l'élément " . request('nome'),
                'id_ele' => $id
            ]);
            return redirect('/user_'.$id)->with('message', 'Utilissateur modifier: ' . request('nome'));
        }
        //delete user
        public function distroyUser($id){
            DB::delete('delete from user where user_id = ?',[$id]);
            DB::table('tracabilite')->insert([
                'source' => "Utilisateur",
                'service' => "Configiration",
                'message' => $_SESSION['role'] . " " .$_SESSION['user_name'] . " a supprimer jour l'élément " . request('nome')
            ]);
            return redirect('/administration')->with('message', 'Utilisateur a éte supprimer: ');
        }
}
