@extends('../layout.structure')

@section('title', 'Contrats')

@section('content')
    @include('../layout.navbar')
    <div class="sub_nav">
        <div class="container">
            <ul>
                <li><a href="dashboard.html">Tableau de bord /</a></li>
                <li><a href="#"> Gestion /</a></li>
                <li><a href="#" class="active"> contact</a></li>
            </ul>
        </div>
    </div>
    <div class="container mt-5">
        <a class="ajout" href="contrat">
            <span>+</span>
            Ajouter contrat
        </a>
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
        <section class="utilisateurs">
            <table class="table table-hover">
                <thead>
                  <tr>
                    <th scope="col">Nom</th>
                    <th scope="col">Type</th>
                    <th scope="col">Numero</th>
                    <th scope="col">date de debut</th>
                    <th scope="col">Durée</th>
                    <th scope="col">Cout (noir & blanc)</th>
                    <th scope="col">Cout (couleur)</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($contrats as $contrat)
                    <tr>
                        <th scope="row"><a href="/public/contrat_<?php echo $contrat->id;?>">{{ $contrat->nome }}</a></th>
                        <td>{{ $contrat->name }}</td>
                        <td>{{ $contrat->numero }}</td>
                        <td>{{ $contrat->date_debut }}</td>
                        <td>{{ $contrat->duree }} mois</td>
                        <td>{{ $contrat->cout_c  }} dh</td>
                        <td>{{ $contrat->cout_nb  }} dh</td>
                    </tr>
                    @endforeach
                </tbody>
              </table>
        </section>
    </section>
@endsection
