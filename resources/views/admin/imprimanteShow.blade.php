@extends('../layout/structure')

@section('title', 'Imprimantes')
@php
    if(isset($imprimante[0]['id_imprt'])){
        $reseau_i = $imprimante[0]['reseau'];
        $type_i = $imprimante[0]['type'];
        $model_i = $imprimante[0]['model'];
        $lieu_i = $imprimante[0]['lieu_instal'];
        $user_i = $imprimante[0]['utilisateur'];
    }else{
        $reseau_i = $type_i = $model_i = $lieu_i = $user_i = '';
    }
@endphp
@include('../helpers.functoins')

@section('content')
    @include('../layout/navbar')
    <div class="sub_nav">
        <div class="container">
            <ul>
                <li><a href="/public/dashboard" class="active">Tableau de bord /</a></li>
            </ul>
        </div>
    </div>

    <section class="container mt-5">
        <section class="ajout_utl_container">
            @if (isset($imprimante[0]['id_imprt']))
            <h4>{{ $imprimante[0]['nome']}}</h4>
            <p>Last Update: <b>{{ $imprimante[0]['updated_at'] }}</b></p>
            @else
            <h4>Nouvelle elements - Imprimantes</h4>
            @endif
            <hr>
            @if (Session::has('error'))
            <div class="alert alert-danger" role="alert">
                {{ Session::get('error') }}
            </div>
            @endif
            <form class="row g-3 mt-5" method="POST">
                @csrf
                <div class="col-md-4 mb-3">
                  <label for="nome" class="form-label">Nome</label>
                  <input type="text" class="form-control" id="nome" value="{{ $imprimante[0]['nome'] ?? ''}}" name="nome" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="serie" class="form-label">Numero de serie</label>
                    <input type="text" class="form-control" id="serie" value="{{ $imprimante[0]['num_serie'] ?? '' }}" name="num_serie" required>
                  </div>
                <div class="col-md-4 mb-5">
                    <label for="select" class="form-label d-block">Utilisateur</label>
                    <select class="form-select p-1" aria-label="Default select example" id="select" style="width: 100%;" name="user" required>
                        <option>choisir une option</option>
                        @foreach ($users as $user)
                        <option value='{{ $user->user_id }}' <?php selectedInput($user_i, $user->user_id);?>>
                            {{ $user->nome }} {{ $user->prenom }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 mb-5">
                    <label for="input_modele" class="form-label d-block">
                        Modèle
                        @if ($_SESSION['role'] == 'admin')
                        <a id="add" href="#"  data-toggle="modal" data-target="#modele"><img src="assets/add.png"></a>
                        @endif
                    </label>
                    <select class="form-select p-1" aria-label="Default select example" id="input_modele" style="width: 100%;" name="model" required>
                        <option>choisir une option</option>
                        @foreach ($models as $model)
                        <option value='{{ $model->id }}' <?php selectedInput($model_i, $model->id );?>>
                            {{ $model->mod_name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 mb-5">
                    <label for="input_type" class="form-label d-block">
                        Type
                        @if ($_SESSION['role'] == 'admin')
                        <a id="add" href="#"  data-toggle="modal" data-target="#type"><img src="assets/add.png"></a>
                        @endif
                    </label>
                    <select class="form-select p-1" aria-label="Default select example" id="input_type" style="width: 100%;" name='type' required>
                        <option>choisir une option</option>
                        @foreach ($types as $type)
                        <option value='{{ $type->type_id_imp  }}' <?php selectedInput($type_i, $type->type_id_imp );?>>
                            {{ $type->nome }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 mb-5">
                    <label for="input_lieu" class="form-label d-block">
                        Lieu
                        @if ($_SESSION['role'] == 'admin')
                        <a id="add" href="#"  data-toggle="modal" data-target="#lieu"><img src="assets/add.png"></a>
                        @endif
                        @if (isset($imprimante[0]['id_imprt']))
                        <img src="assets/info.png" data-toggle="tooltip" data-placement="right" class="info"
                            title="
                                @foreach ($lieux as $lieu)
                                    @if ($lieu->lieu_id == $lieu_i)
                                    {{ $lieu->adress }},
                                    code postal {{ $lieu->code_postal }},
                                    {{ $lieu->ville }}-
                                    {{ $lieu->payer }}
                                    @endif
                                @endforeach
                                ">
                        @endif

                    </label>
                    <select class="form-select p-1" aria-label="Default select example" id="input_lieu" style="width: 100%;" name='lieu'>
                        <option>choisir une option</option>
                        @foreach ($lieux as $lieu)
                        <option value='{{ $lieu->lieu_id  }}' <?php selectedInput($lieu_i, $lieu->lieu_id );?>>
                            {{ $lieu->nome }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-5">
                    <label for="input_reseau" class="form-label d-block">
                        Reseau
                        @if ($_SESSION['role'] == 'admin')
                        <a id="add" href="#"  data-toggle="modal" data-target="#reseau"><img src="assets/add.png"></a>
                        @endif
                    </label>
                    <select class="form-select p-1" aria-label="Default select example" id="input_reseau" style="width: 100%;" name="reseau">
                        <option>choisir une option</option>
                        @foreach ($reseaux as $reseau)
                        <option value='{{ $reseau->id }}' <?php selectedInput($reseau_i, $reseau->id);?>>{{ $reseau->adress }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-5">
                    <label for="cmpt_inc" class="form-label">Compteur initial</label>
                    @if (isset($imprimante[0]['id_imprt']))
                    <input type="text" class="form-control" id="cmpt_inc" value="{{ $imprimante[0]['cmpt_inc'] ?? '' }}" name="cmpt_inc" disabled>
                    @else
                    <input type="text" class="form-control" id="cmpt_inc" value="{{ $imprimante[0]['cmpt_inc'] ?? '' }}" name="cmpt_inc" required>
                    @endif
                  </div>
                  @if (isset($imprimante[0]['id_imprt']))
                  <h4 class="mt-3 col-12 mb-3">Partie Compteur: </h4>
                  <hr>
                  <div class="col-md-6 mb-5">
                      <label for="cmpt_act" class="form-label">Compteur actuel</label>
                      <input type="text" class="form-control" id="cmpt_act" value="{{ $compteur[0]->nbt_impr ?? ''}}" name="compteur" required>
                  </div>
                  <div class="col-md-6 mb-3">
                    <label for="Identifiant" class="form-label">Date de relver</label>
                    <input type="date" class="form-control" id="Identifiant" value="" name="date_relver">
                  </div>
                  @else
                  <div class="col-md-6 mb-3">
                    <label for="Identifiant" class="form-label">Date d'instalation</label>
                    <input type="date" class="form-control" id="Identifiant" value="" name="date_instal" required>
                  </div>
                  @endif

                <div class="col-12 text-center mt-5">
                    @if (isset($imprimante[0]['id_imprt']))
                    <input class="btn btn-primary btn-lg" type="submit" value="Sauvgarder" name="sauvgarder">
                    @else
                    <input class="btn btn-primary btn-lg" type="submit" value="Ajouter Imprimante" name="add">
                    @endif
              </form>
              @if (isset($imprimante[0]['id_imprt']))
              <form action="/public/imprimante_{{ $imprimante[0]['id_imprt'] }}" class="text-center mt-3" method="POST">
                  @csrf
                  @method('DELETE')
                  <input class="btn btn-danger btn-lg" type="submit" value="Supprimer" name="delet">
              </form>
              @endif
        </section>
    </section>
    @if ($_SESSION['role'] == 'admin')
    <!-- Modal for add new lieu -->
    <div class="modal fade" id="lieu" tabindex="-1" role="dialog" aria-labelledby="lieu" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Ajouter un lieu</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
            <form class="row" action="/public/test" method="get">
                @csrf
                <div class="col-12 mb-3">
                    <label for="inputcatnom" class="form-label">Nome:</label>
                    <input type="text" class="form-control" id="inputcatnom" placeholder="nome" name='lieu_name'>
                </div>
                <div class="col-12 mb-3">
                    <label for="inputcatnom" class="form-label">Adress:</label>
                    <input type="text" class="form-control" id="inputcatnom" placeholder="adress" name='adress'>
                </div>
                <div class="col-12 mb-3">
                    <label for="inputcatnom" class="form-label">Code postal:</label>
                    <input type="text" class="form-control" id="inputcatnom" placeholder="code postal" name='code_postal'>
                </div>
                <div class="col-12 mb-3">
                    <label for="inputcatnom" class="form-label">ville:</label>
                    <input type="text" class="form-control" id="inputcatnom" placeholder="ville" name='ville'>
                </div>
                <div class="col-12 mb-3">
                    <label for="inputcatnom" class="form-label">Payer:</label>
                    <input type="text" class="form-control" id="inputcatnom" placeholder="payer" name='payer'>
                </div>
                <div class="col-12">
                    <input class="btn btn-success btn-block" type="submit" value="ajouter">
                </div>
            </form>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
        </div>
    </div>
    <!-- Modal for add new modele -->
    <div class="modal fade" id="modele" tabindex="-1" role="dialog" aria-labelledby="modele" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Ajouter un Modele</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
            <form method="get" class="row" action="/public/test">
                @csrf
                <div class="col-12 mb-3">
                    <label for="inputcatnom" class="form-label">Nome:</label>
                    <input type="text" class="form-control" id="inputcatnom" placeholder="nome" name='model'>
                </div>
                <div class="col-12">
                    <input class="btn btn-success btn-block" type="submit" value="ajouter">
                </div>
            </form>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
        </div>
    </div>
    <!-- Modal for add new reseau -->
    <div class="modal fade" id="reseau" tabindex="-1" role="dialog" aria-labelledby="reseau" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Ajouter un Reseau</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
            <form method="get" class="row" action="/public/test">
                @csrf
                <div class="col-12 mb-3">
                    <label for="inputcatnom" class="form-label">Adresse:</label>
                    <input type="text" class="form-control" id="inputcatnom" placeholder="adresse" name='reseau'>
                </div>
                <div class="col-12">
                    <input class="btn btn-success btn-block" type="submit" value="ajouter_reseau">
                </div>
            </form>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
        </div>
    </div>
    <!-- Modal for add new type -->
    <div class="modal fade" id="type" tabindex="-1" role="dialog" aria-labelledby="type" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Ajouter un nouveau type</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
            <form class="row" action="/public/test" method="get">
                @csrf
                <div class="col-12 mb-3">
                    <label for="inputcatnom" class="form-label">Nome de type:</label>
                    <input type="text" class="form-control" id="inputcatnom" placeholder="type" name="type">
                </div>
                <div class="col-12">
                    <input class="btn btn-success btn-block" type="submit" value="ajouter">
                </div>
            </form>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
        </div>
    </div>
    @endif
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
