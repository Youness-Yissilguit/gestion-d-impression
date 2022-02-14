@extends('../layout.structure')

@section('title', 'Contrats')
@php
    if(isset($contrat[0]['id'])){

    }else{

    }
    // selectedInput($statue, 'nouveau');
@endphp
@include('../helpers.functoins')

@section('content')
    @include('../layout.navbar')
    <div class="sub_nav">
        <div class="container">
            <ul>
                <li><a href="dashboard.html">Tableau de bord /</a></li>
                <li><a href="ticket.html"> Tickets /</a></li>
                <li><a href="#" class="active"> Ajouter tickets</a></li>
            </ul>
        </div>
    </div>

    <section class="container mt-5">
        <section class="ajout_utl_container">
            @if (isset($contrat[0]['id']))
            <h4>Contrat {{ $contrat[0]['nome']}}</h4>
            @else
            <h4>Nouvelle elements - Contrat</h4>
            @endif
            <form class="row g-3 mt-5" method="post">
                @csrf
                <div class="col-md-6 mb-3">
                  <label for="nome" class="form-label">Nome</label>
                  <input type="text" class="form-control" id="nome" value="{{ $contrat[0]['nome']  ?? ''}}" name="nome">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="num" class="form-label">Numero</label>
                    <input type="text" class="form-control" id="num" value="{{ $contrat[0]['numero']  ?? ''}}" name="numero">
                </div>
                <div class="col-md-6 mb-5">
                    <label for="date_d" class="form-label d-block">Date debut</label>
                    <input type="date" class="form-control" id="date_d" value="{{ $contrat[0]['date_debut']  ?? ''}}" name="date_d">
                </div>
                <div class="col-md-6 mb-5">
                    <label for="duree" class="form-label d-block">Durée</label>
                    <select class="form-select p-1" aria-label="Default select example" id="duree" style="width: 100%;" name="duree">
                        <option selected>choisir une option</option>
                        <option value="1" <?php selectedInput($contrat[0]['type'] ?? '', '1');?>>1 mois</option>
                        <option value="2" <?php selectedInput($contrat[0]['type'] ?? '', '2');?>>2 mois</option>
                        <option value="3" <?php selectedInput($contrat[0]['type'] ?? '', '3');?>>3 mois</option>
                        <option value="6" <?php selectedInput($contrat[0]['type'] ?? '', '6');?>>6 mois</option>
                        <option value="12" <?php selectedInput($contrat[0]['type'] ?? '', '12');?>>12 mois</option>
                        <option value="24" <?php selectedInput($contrat[0]['type'] ?? '', '24');?>>24 mois</option>
                        <option value="36" <?php selectedInput($contrat[0]['type'] ?? '', '36');?>>36 mois</option>
                        <option value="48" <?php selectedInput($contrat[0]['type'] ?? '', '48');?>>48 mois</option>
                    </select>
                </div>
                <div class="col-md-4 mb-5">
                    <label for="select" class="form-label d-block">Périodicité du facturation</label>
                    <select class="form-select p-1" aria-label="Default select example" id="select" style="width: 100%;" name='perio_fac'>
                        <option selected>choisir une option</option>
                        <option value="1" <?php selectedInput($contrat[0]['perio_facturation'] ?? '', '1');?>>1 mois</option>
                        <option value="2" <?php selectedInput($contrat[0]['perio_facturation'] ?? '', '2');?>>2 mois</option>
                        <option value="3" <?php selectedInput($contrat[0]['perio_facturation'] ?? '', '3');?>>3 mois</option>
                        <option value="6" <?php selectedInput($contrat[0]['perio_facturation'] ?? '', '6');?>>6 mois</option>
                        <option value="12" <?php selectedInput($contrat[0]['perio_facturation'] ?? '', '12');?>>12 mois</option>
                    </select>
                </div>
                <div class="col-md-4 mb-5">
                    <label for="input_type" class="form-label d-block">
                        Type De Contrat
                        <a id="add" href="#"  data-toggle="modal" data-target="#type"><img src="assets/add.png"></a>
                    </label>
                    <select class="form-select p-1" aria-label="Default select example" id="input_type" style="width: 100%;" name='type'>
                        <option selected>choisir une option</option>
                        @foreach ($types as $type)
                        <option value='{{ $type->type_id }}' <?php selectedInput($contrat[0]['type'] ?? '', $type->type_id);?>>{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 mb-5">
                    <label for="cout_c" class="form-label d-block">Cout (couleur)</label>
                    <input type="text" class="form-control" id="cout_c" placeholder="0.00dh" value="{{ $contrat[0]['cout_c'] ?? '' }}" name="cout_c">
                </div>
                <div class="col-md-4 mb-5">
                    <label for="cout_nb" class="form-label d-block">Cout (noir et blanc)</label>
                    <input type="text" class="form-control" id="cout_nb" placeholder="0.00dh" value="{{ $contrat[0]['cout_nb'] ?? '' }}" name="cout_nb">
                </div>
                <div class="col-md-4 mb-5">
                    <label for="frn" class="form-label d-block">Fournnisseur</label>
                    <select class="form-select p-1" aria-label="Default select example" id="frn" style="width: 100%;" name="fournisseur">
                        <option selected>choisir une option</option>
                        @foreach ($fournisseurs as $fourni)
                        <option value='{{ $fourni->f_id }}' <?php selectedInput($contrat[0]['id_fournisseur'] ?? '', $fourni->f_id);?>>{{ $fourni->nome ?? '' }} {{ $fourni->prenom }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 mb-5">
                    <label for="imp" class="form-label d-block">Imprimante</label>
                    <select class="form-select p-1" aria-label="Default select example" id="imp" style="width: 100%;" name="imprimante">
                        <option selected>choisir une option</option>
                        @foreach ($imprimantes as $imprimante)
                        <option value='{{ $imprimante->id_imprt }}' <?php selectedInput($contrat[0]['id_imprimante'] ?? 'yt', $imprimante->id_imprt);?>>{{ $imprimante->nome }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 text-center mt-5">
                    @if (isset($contrat[0]['id']))
                    <input class="btn btn-primary btn-lg" type="submit" value="Sauvgarder" name="sauvgarder">
                    @else
                    <input class="btn btn-primary btn-lg" type="submit" value="Ajouter Contrat" name="add">
                    @endif
                </div>
              </form>
              @if (isset($contrat[0]['id']))
              <form action="contrat_{{ $contrat[0]['id'] }}" class="text-center mt-3" method="POST">
                  @csrf
                  @method('DELETE')
                  <input class="btn btn-danger btn-lg" type="submit" value="Supprimer" name="delet">
              </form>
              @endif
        </section>
    </section>
    <!-- Modal for add new contrat type -->
    <div class="modal fade" id="type" tabindex="-1" role="dialog" aria-labelledby="type" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Ajouter un type de contrat</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
            <form method="get" class="row" action="/public/test">
                @csrf
                <div class="col-12 mb-3">
                    <label for="inputcatnom" class="form-label">Nome:</label>
                    <input type="text" class="form-control" id="inputcatnom" placeholder="nome" name="contrat_type">
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
