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
            <h4>Profil - {{ $_SESSION['user_name'] }}</h4>
            <div class="hide show" id="1">
                <form class="row g-3 mt-5" method="post">
                    @csrf
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
                    <div class="col-md-4 mb-3">
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

                    <div class="col-12 text-center mt-5">
                        <input class="btn btn-primary" type="submit" value="sauvgarder">
                    </div>
                  </form>
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
