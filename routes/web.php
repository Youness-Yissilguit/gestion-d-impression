<?php

use Illuminate\Routing\Route as RoutingRoute;
use Illuminate\Support\Facades\Route;
use Symfony\Component\Routing\Route as ComponentRoutingRoute;
use Illuminate\Support\Facades\Auth;
session_start();

// home page
Route::get('/', function () {
    return view('index', [
        //data
    ]);
});
// login page
Route::get('/login', 'App\Http\Controllers\LoginController@loginIndex');
Route::post('/login', 'App\Http\Controllers\LoginController@loginPost');
Route::get('/logout', 'App\Http\Controllers\LoginController@logout');
// Route::get('/home', function () {return view('welcome', []);});

function tickets(){
    //tickets
    Route::get('/tickets', 'App\Http\Controllers\TicketsController@indexTickets');
    Route::get('/ticket_{id}', 'App\Http\Controllers\TicketsController@showTickets');
    Route::get('/ticket', 'App\Http\Controllers\TicketsController@createTicket');
    Route::post('/ticket', 'App\Http\Controllers\TicketsController@storeTicket');
    Route::post('/ticket_{id}', 'App\Http\Controllers\TicketsController@modifyTicket');
    Route::delete('/ticket_{id}', 'App\Http\Controllers\TicketsController@distroyTicket');
}

/**** Admin routes ****/
if(isset($_SESSION['user_id']) && $_SESSION['role'] == 'admin'){
    //admin dashboard
    Route::get('/dashboard','App\Http\Controllers\DashboardController@indexDashboard');
    //users
    Route::get('/administration', 'App\Http\Controllers\UserController@indexUsers');
    Route::get('/user_{id}', 'App\Http\Controllers\UserController@showUser');
    Route::get('/user', 'App\Http\Controllers\UserController@createUser');
    Route::post('/user', 'App\Http\Controllers\UserController@storeUser');
    Route::post('/user_{id}', 'App\Http\Controllers\UserController@modifyUser');
    Route::delete('/user_{id}', 'App\Http\Controllers\UserController@distroyUser');
    //imprimantes
    Route::get('/imprimantes', 'App\Http\Controllers\ImpController@indexImprimantes');
    Route::get('imprimante_{id}', 'App\Http\Controllers\ImpController@showImprimante');
    Route::get('/imprimante', 'App\Http\Controllers\ImpController@createImprimante');
    Route::post('/imprimante', 'App\Http\Controllers\ImpController@storeImprimante');
    Route::post('/imprimante_{id}', 'App\Http\Controllers\ImpController@modifyImprimante');
    Route::delete('/imprimante_{id}', 'App\Http\Controllers\ImpController@distroyImprimante');
    //tickets
    tickets();
    //fournisseurs
    Route::get('/fournisseurs', 'App\Http\Controllers\FournisseurController@indexFourni');
    Route::get('/fournisseur', 'App\Http\Controllers\FournisseurController@createFourni');
    Route::get('/fournisseur_{id}', 'App\Http\Controllers\FournisseurController@showFourni');
    Route::post('/fournisseur', 'App\Http\Controllers\FournisseurController@storeFourni');
    Route::post('/fournisseur_{id}', 'App\Http\Controllers\FournisseurController@modifyFourni');
    Route::delete('/fournisseur_{id}', 'App\Http\Controllers\FournisseurController@distroyFourni');
    //add items
    Route::get('/test', 'App\Http\Controllers\TicketsController@addItems');
    //contrats
    Route::get('/contrats', 'App\Http\Controllers\ContratController@indexContrat');
    Route::get('/contrat', 'App\Http\Controllers\ContratController@createContrat');
    Route::get('/contrat_{id}', 'App\Http\Controllers\ContratController@showContrat');
    Route::post('/contrat', 'App\Http\Controllers\ContratController@storeContrat');
    Route::post('/contrat_{id}', 'App\Http\Controllers\ContratController@modifyContrat');
    Route::delete('/contrat_{id}', 'App\Http\Controllers\ContratController@distroyContrat');
    //trace
    Route::get('/trace', 'App\Http\Controllers\TraceController@indexTrace');
    Route::post('/trace', 'App\Http\Controllers\TraceController@nextTrace');
    //profil
    Route::get('/profil', 'App\Http\Controllers\LoginController@profil');
    Route::post('/profil', 'App\Http\Controllers\LoginController@modifyProfil');

    //compteur trace
    //Route::get('/dynamic_pdf', 'App\Http\Controllers\PdfController@index');
    Route::get('/pdf_{id}', 'App\Http\Controllers\PdfController@pdf');
    Route::get('/csv_{id}', 'App\Http\Controllers\PdfController@exportCsv');
    Route::get('/relver_{id}', 'App\Http\Controllers\PdfController@relverIndex');
    Route::post('/relver_{id}', 'App\Http\Controllers\PdfController@relverIndexSearsh');
    Route::get('/compteur_trace_{id}', 'App\Http\Controllers\PdfController@compteurTrace');
    Route::post('/compteur_trace_{id}', 'App\Http\Controllers\PdfController@compteurTraceSearsh');
}

/** utilisateur routes **/
if (isset($_SESSION['user_id']) && $_SESSION['role'] == 'user') {
    Route::get('/tickets', 'App\Http\Controllers\TicketsController@indexTicketsUser');
    Route::get('/ticket_{id}', 'App\Http\Controllers\TicketsController@showTickets');
    Route::get('/ticket', 'App\Http\Controllers\TicketsController@createTicket');
    Route::post('/ticket', 'App\Http\Controllers\TicketsController@storeTicket');
    Route::post('/ticket_{id}', 'App\Http\Controllers\TicketsController@modifyTicket');
    Route::delete('/ticket_{id}', 'App\Http\Controllers\TicketsController@distroyTicket');
    //user home
    Route::view('/userHome', 'user.userHome');
    //profil
    Route::get('/profil', 'App\Http\Controllers\LoginController@profil');
    Route::post('/profil', 'App\Http\Controllers\LoginController@modifyProfil');
}

/***technicien routes***/
if (isset($_SESSION['user_id']) && $_SESSION['role'] == 'technicien') {
    //users
    Route::get('/administration', 'App\Http\Controllers\UserController@indexUsers');
    Route::get('/user_{id}', 'App\Http\Controllers\UserController@showUser');
    Route::get('/user', 'App\Http\Controllers\UserController@createUser');
    Route::post('/user', 'App\Http\Controllers\UserController@storeUser');
    Route::post('/user_{id}', 'App\Http\Controllers\UserController@modifyUser');
    Route::delete('/user_{id}', 'App\Http\Controllers\UserController@distroyUser');
    //imprimantes
    Route::get('/imprimantes', 'App\Http\Controllers\ImpController@indexImprimantes');
    Route::get('imprimante_{id}', 'App\Http\Controllers\ImpController@showImprimante');
    Route::get('/imprimante', 'App\Http\Controllers\ImpController@createImprimante');
    Route::post('/imprimante', 'App\Http\Controllers\ImpController@storeImprimante');
    Route::post('/imprimante_{id}', 'App\Http\Controllers\ImpController@modifyImprimante');
    Route::delete('/imprimante_{id}', 'App\Http\Controllers\ImpController@distroyImprimante');
    //tickets
    tickets();
    Route::view('/techHome', 'technicien.techHome');
    //profil
    Route::get('/profil', 'App\Http\Controllers\LoginController@profil');
    Route::post('/profil', 'App\Http\Controllers\LoginController@modifyProfil');
}

//to modify or column in a table use:
    //method 1: (if you dont have date in table)
    //php artisan migrate:rollback -> php artisan migrate
    //methode 2: -(safe mrthode if you have date on db)
    //php artisan make:migration add_column_to_tableName_table.php -> php artisan migrate


