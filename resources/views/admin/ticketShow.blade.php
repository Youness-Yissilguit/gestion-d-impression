@extends('../layout.structure')

@section('title', 'Tickets - Nouveau')
@php
    if(isset($ticket_id)){
        $titre = $ticket[0]["titre"];
        $description = $ticket[0]["description"];
        $date_ouvert = $ticket[0]["date_ouvert"];
        $date_limit = $ticket[0]["date_limit"];
        $statue = $ticket[0]["statue"];
        $priorite = $ticket[0]["priorite"];
        $type = $ticket[0]["type"];
        $cat_id = $ticket[0]["categorie"];
        $from = $ticket[0]["created_by"];
        $to = $ticket[0]["attribu_to"];
    }else{
        $titre = $description = $date_ouvert = $date_limit = $statue = $priorite = $type = $cat_id = $from = $to ='';
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
    @if (Session::has('message'))
    <div id="message">
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>{{ $_SESSION['user_name'] }}!</strong> <br>{{ Session::get('message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
    @endif
    <section class="container mt-5">
        <section class="ajout_utl_container">
            @if (isset($ticket_id))
            <h4>{{ $titre}}</h4>
            <p>Last Update: <b>{{ $ticket[0]['updated_at'] }}</b></p>
            @else
            <h4>Nouvelle elements - Imprimantes</h4>
            @endif
            <hr>
            <form class="row g-3 mt-5" method="POST">
                @csrf
                <div class="col-md-6 mb-3">
                  <label for="Identifiant" class="form-label">Date d'ouverture</label>
                  <input type="date" class="form-control" id="Identifiant" value="{{ $date_ouvert }}" name="date_ouvert">
                </div>
                <div class="col-md-6 mb-5">
                  <label for="inputPassword" class="form-label">Date de Limite</label>
                  <input type="date" class="form-control" id="inputPassword" value="{{ $date_limit }}" name="date_limit">
                </div>
                <div class="col-md-4 mb-5">
                    <label for="select" class="form-label d-block">Statue</label>
                    <select class="form-select p-1" aria-label="Default select example" id="select" style="width: 100%;" name="statue">
                        <option>choisir une option</option>
                        <option value="nouveau" <?php selectedInput($statue, 'nouveau');?>>Nouveau</option>
                        <option value="en cours" <?php selectedInput($statue, 'en cours');?>>En cour</option>
                        <option value="resolut" <?php selectedInput($statue, 'resolut');?>>Résolut</option>
                    </select>
                </div>
                <div class="col-md-4 mb-5">
                    <label for="select" class="form-label d-block">Priorité</label>
                    <select class="form-select p-1" aria-label="Default select example" id="select" style="width: 100%;" name="priorite">
                        <option>choisir une option</option>
                        <option value="basse" <?php selectedInput($priorite, 'basse');?>>Basse</option>
                        <option value="moyenne" <?php selectedInput($priorite, 'moyenne');?>>Moyenne</option>
                        <option value="danger" <?php selectedInput($priorite, 'danger');?>>danger</option>
                    </select>
                </div>
                <div class="col-md-4 mb-5">
                    <label for="select" class="form-label d-block">Type</label>
                    <select class="form-select p-1" aria-label="Default select example" id="select" style="width: 100%;" name="type">
                        <option>choisir une option</option>
                        <option value="demande" <?php selectedInput($type, 'demande');?>>Demande</option>
                        <option value="incendie" <?php selectedInput($type, 'incendie');?>>Incident</option>
                    </select>
                </div>
                <div class="col-md-4 mb-5">
                    <label for="select" class="form-label d-block">
                        Categorie
                        @if ($_SESSION['role'] == 'admin')
                        <a id="add" href="#"  data-toggle="modal" data-target="#exampleModalCenter"><img src="assets/add.png"></a>
                        @endif
                    </label>
                    <select class="form-select p-1" aria-label="Default select example" id="select" style="width: 100%;" name="categorie">
                        <option>choisir une option</option>
                        @foreach ($categorie as $categ)
                        <option value='{{ $categ->cat_id }}' <?php selectedInput($cat_id, $categ->cat_id);?>>{{ $categ->nome }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 mb-5">
                    <label for="select" class="form-label d-block">Atribut à</label>
                    <select class="form-select p-1" aria-label="Default select example" id="select" style="width: 100%;" name="atri_to">
                        <option>choisir une option</option>
                        @foreach ($techs as $tech)
                        <option value="{{ $tech->user_id }}" <?php selectedInput($to, $tech->user_id);?>>
                            {{ $tech->nome }} {{ $tech->prenom }}
                        </option>
                        @endforeach
                    </select>
                </div>
                {{-- admin --}}
                @if ($_SESSION['role'] != 'user')
                <div class="col-md-4 mb-5">
                    <label for="select" class="form-label d-block">Demendeur</label>
                    <select class="form-select p-1" aria-label="Default select example" id="select" style="width: 100%;" name="demandeur">
                        <option>choisir une option</option>
                        @foreach ($users as $user)
                        <option value="{{ $user->user_id }}" <?php selectedInput($from, $user->user_id);?>>
                            {{ $user->nome }} {{ $user->prenom }}
                        </option>
                        @endforeach
                    </select>
                </div>
                @endif
                <div class="col-12 mb-5">
                    <label for="inputnom" class="form-label">Titre</label>
                    <input type="text" class="form-control" id="inputnom" value='{{ $titre }}' name="titre">
                  </div>
                  <div class="col-12 mb-5">
                    <label for="inputprenom" class="form-label">Description</label>
                    <textarea id="mytextarea" cols="30" rows="10" name="description">
                        {{ $description }}
                    </textarea>
                  </div>
                <div class="col-12 text-center mt-5">
                    @if (isset($ticket_id))
                    <input class="btn btn-primary btn-lg" type="submit" value="Sauvgarder" name="sauvgarder">
                    @else
                    <input class="btn btn-primary btn-lg" type="submit" value="Ajouter Ticket" name="add">
                    @endif
                  </div>
            </form>
            @if (isset($ticket_id))
            <form action="/public/ticket_{{ $ticket_id }}" class="text-center mt-3" method="POST">
                @csrf
                @method('DELETE')
                <input class="btn btn-danger btn-lg" type="submit" value="Supprimer" name="delet">
            </form>
            @endif
        </section>
    </section>
    @if ($_SESSION['role'] != 'user')
    <!-- Modal for add new categorie -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Ajouter un Categorie</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
            <form method="get" class="row" action="/public/test">
                 @csrf
                <div class="col-12 mb-3">
                    <label for="inputcatnom" class="form-label">Nome:</label>
                    <input type="text" class="form-control" id="inputcatnom" placeholder="nome" name='categorie'>
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
@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.8.2/tinymce.min.js" integrity="sha512-laacsEF5jvAJew9boBITeLkwD47dpMnERAtn4WCzWu/Pur9IkF0ZpVTcWRT/FUCaaf7ZwyzMY5c9vCcbAAuAbg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    tinymce.init({
        selector: 'textarea#mytextarea'
    });
</script>
@endsection
