@extends('../layout/structure')

@section('title', 'Administration')
@php
    if(isset($user[0]['user_id'])){
        $role = $user[0]['role'];
    }else{
        $role = '';
    }
@endphp
@include('../helpers.functoins')

@section('content')
    @include('../layout/navbar')
    <div class="sub_nav">
        <div class="container">
            <ul>
                <li><a href="dashboard">Tableau de bord /</a></li>
                <li><a href="administration"> Administration/</a></li>
                <li><a href="#" class="active"> Ajouter uilisateur</a></li>
            </ul>
        </div>
    </div>

    <section class="container mt-5">
        <section class="ajout_utl_container">
            @if(isset($user[0]['user_id']))
                <h4>utilisateur - {{ $user[0]['prenom'] }}</h4>
            @else
                <h4>Nouvelle elements - utilisateur</h4>
            @endif
            <hr>
            @if(isset($user[0]['user_id']))
            <ul class="select_list_menu" id="test">
                <li class="active" data-item_to_show='1'>utilisateur</li>
                <li data-item_to_show='2'>Tickets créés</li>
                <li data-item_to_show='3'>Imprimants Utilisés</li>
            </ul>

            <div class="hide" id="2">
                <table class="table table-hover mt-5">
                    <thead>
                      <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Titre</th>
                        <th scope="col">Statue</th>
                        <th scope="col">Date d'ouverture</th>
                        <th scope="col">Priorité</th>
                        <th scope="col">Demandeur</th>
                        <th scope="col">Categorie</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($tickets as $ticket)
                            <tr>
                            <td>{{ $ticket->ticket_id }}</td>
                            <th scope="row">
                                <a href="/public/ticket_<?php echo $ticket->ticket_id;?>">
                                {{ $ticket->titre }}
                            </a>
                            </th>
                            <td class="statut">
                                @if ($ticket->statue == "en cours")
                                <img src="assets/work-in-progress.png" alt="">
                                @elseif($ticket->statue == "resolut")
                                <img src="assets/checked.png" alt="">
                                @else
                                <img src="assets/new.png" alt="">
                                @endif
                                {{ $ticket->statue }}
                            </td>
                            <td>{{ $ticket->date_ouvert }}</td>
                            <td class="<?php
                                if($ticket->priorite == "moyenne")
                                    echo "alert alert-warning";
                                else if($ticket->priorite == "danger")
                                    echo "alert alert-danger";
                                else
                                    echo "alert alert-info";
                                ?>" >
                                {{ $ticket->priorite}}
                            </td>
                            <td>{{ $user[0]['identifiant']  }}</td>
                            <td>{{ $ticket->cat_name}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="hide" id="3">
                <table class="table table-hover mt-5">
                    <thead>
                      <tr>
                        <th scope="col">Nome</th>
                        <th scope="col">Num serie</th>
                        <th scope="col">Lieu</th>
                        <th scope="col">Type</th>
                        <th scope="col">Modele</th>
                        <th scope="col">Compteur Initail</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($imprimantes as $imprimante)
                        <tr>
                            <th scope="row"><a href="/public/imprimante_{{ $imprimante->id_imprt }}">{{ $imprimante->nome }}</a></th>
                            <td>{{ $imprimante->num_serie }}</td>
                            <td>{{ $imprimante->lieu_nome }}</td>
                            <td>{{ $imprimante->type_nome }}</td>
                            <td>{{ $imprimante->mod_name }}</td>
                            <td>{{ $imprimante->cmpt_inc }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                  </table>
            </div>
            @endif
            <div class="hide show" id="1">
                <form class="row g-3 mt-5" method="post">
                    @csrf
                    <div class="col-md-6 mb-3">
                      <label for="Identifiant" class="form-label">Identifiant</label>
                      <input type="text" class="form-control" id="Identifiant" value="{{ $user[0]['identifiant'] ?? ''}}" name="identifiant">
                    </div>
                    <div class="col-md-6 mb-3">
                      <label for="inputPassword" class="form-label">Password</label>
                      <input type="text" class="form-control" id="inputPassword"  value="{{ $user[0]['mode_de_pass']  ?? ''}}" name="mode_de_pass">
                    </div>
                    <div class="col-6 mb-3">
                      <label for="inputnom" class="form-label">Nome</label>
                      <input type="text" class="form-control" id="inputnom" value="{{ $user[0]['nome']  ?? ''}}" name="nome">
                    </div>
                    <div class="col-6 mb-3">
                      <label for="inputprenom" class="form-label">Prenom</label>
                      <input type="text" class="form-control" id="inputprenom" value="{{ $user[0]['prenom']  ?? ''}}" name="prenom">
                    </div>
                    <div class="col-md-6 mb-3">
                      <label for="inputCity" class="form-label">email</label>
                      <input type="text" class="form-control" id="inputCity" value="{{ $user[0]['email']  ?? ''}}" name="email">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="inputCity" class="form-label">Adress</label>
                        <input type="text" class="form-control" id="inputCity" placeholder="Apartment, studio, or floor"  value="{{ $user[0]['adress']  ?? ''}}" name="adress">
                      </div>
                    <div class="col-md-4 mb-3">
                        <label for="inputCity" class="form-label">Telephone</label>
                        <input type="text" class="form-control" id="inputCity" placeholder="" value="{{ $user[0]['telephone']  ?? ''}}" name="telephone">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="inputCity" class="form-label">Telephone mobile</label>
                        <input type="text" class="form-control" id="inputCity" placeholder="" value="{{ $user[0]['telephone_mobile']  ?? ''}}" name="telephone_mobile">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="select" class="form-label d-block">Role</label>
                        <select class="form-select p-1" aria-label="Default select example" id="select" style="width: 100%;" name="role">
                            <option selected>Choisir un profil</option>
                            <option value="admin" <?php selectedInput('admin', $role);?>>Admin</option>
                            <option value="user" <?php selectedInput('user', $role);?>>Utilisateur</option>
                            <option value="technicien" <?php selectedInput('technicien', $role);?>>Technicien</option>
                        </select>
                    </div>
                    @if(isset($user[0]['user_id']))
                        <div class="col-12 text-center mt-5">
                            <input class="btn btn-primary" type="submit" value="sauvgarder">
                        </div>
                    @else
                        <div class="col-12 text-center mt-5">
                            <input class="btn btn-primary" type="submit" value="Ajouter utilisateur">
                        </div>
                    @endif
                  </form>
                  @if (isset($user[0]['user_id']))
                  <form action="/public/user_{{ $user[0]['user_id']}}" class="text-center mt-3" method="POST">
                      @csrf
                      @method('DELETE')
                      <input class="btn btn-danger btn-lg" type="submit" value="Supprimer" name="delet">
                  </form>
                  @endif
            </div>
        </section>
    </section>
    @if (Session::has('message'))
    <div id="message">
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>{{ $_SESSION['user_name'] }}!</strong><br> {{ Session::get('message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
    @endif
@endsection
