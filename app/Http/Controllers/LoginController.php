<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\Users;

class LoginController extends Controller
{
    public function loginIndex(){
        return view('login', [

        ]);
    }
    public function loginPost(){
        $log_user = DB::select('select * from user where identifiant = ? and mode_de_pass=?',
                                [request('identifiant'), request('password')]);
        if(!empty($log_user)){
            $_SESSION['role'] = $log_user[0]->role;
            $_SESSION['user_id'] =  $log_user[0]->user_id;
            $_SESSION['user_name'] =  $log_user[0]->identifiant;
            if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } else {
                $ip = $_SERVER['REMOTE_ADDR'];
            }
            DB::table('tracabilite')->insert([
                'source' => "Système",
                'service' => "Connextion",
                'message' => $_SESSION['role'] . " " .$_SESSION['user_name'] . " se connecter depuis " .$ip
            ]);
            if($_SESSION['role'] == 'admin'){
                return redirect('dashboard');
            } else if ($_SESSION['role'] == 'technicien'){
                return redirect('techHome');
            } else {
                return redirect('userHome');
            }

        }else{
            return redirect()->back()->with('error', 'user not found');
        }
    }

    //profil
    public function profil(){
        $user = Users::where('user_id', $_SESSION['user_id'])->get();
        return view('profil', [
            'user' => $user
        ]);
    }
    //modify user
    public function modifyProfil(){
        $current_date_time = \Carbon\Carbon::now()->toDateTimeString();
        DB::update('update user set nome=?,prenom=?,telephone=?,telephone_mobile=?,mode_de_pass=?,adress=?,email=?,
            updated_at=? where user_id = ?',
            [request('nome'),request('prenom'),request('telephone'),request('telephone_mobile'),
            request('mode_de_pass'),request('adress'),request('email'), $current_date_time, $_SESSION['user_id']]
        );
        DB::table('tracabilite')->insert([
            'source' => "Utilisateur",
            'service' => "Configiration",
            'message' => $_SESSION['role'] . " " .$_SESSION['user_name'] . " mise à jour son profil",
            'id_ele' => $_SESSION['user_id']
        ]);
        return redirect('/profil')->with('message', 'profil modifier: ' . request('nome'));
    }
    //logout
    public function logout(){
        if(isset($_SESSION['user_id']) ){
            session_unset(); // removes all session data
            return redirect('login');
        } else{
            return redirect('login');
        }
    }
}
