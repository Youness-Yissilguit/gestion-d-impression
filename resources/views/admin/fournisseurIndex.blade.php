@extends('../layout.structure')

@section('title', 'Fournisseur')

@section('content')
    @include('../layout.navbar')
    <div class="sub_nav">
        <div class="container">
            <ul>
                <li><a href="dashboard">Tableau de bord / </a></li>
                <li><a href="#" class="active">Fournisseurs</a></li>
            </ul>
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
    <div class="container mt-5">
        <a class="ajout" href="fournisseur">
            <span>+</span>
            Ajouter fournisseur
        </a>
    </div>
    <div class="tickets_container">
        <div class="container mt-5">
            <table class="table table-hover">
                <thead>
                  <tr>
                    <th scope="col">Nome</th>
                    <th scope="col">Adress</th>
                    <th scope="col">Fax</th>
                    <th scope="col">Ville</th>
                    <th>relver</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($fournisseurs as $fournisseur)
                        <tr>
                        <th scope="row">
                            <a href="/public/fournisseur_<?php echo $fournisseur->f_id;?>">
                            {{ $fournisseur->nome }}
                        </a>
                        </th>
                        <td>{{ $fournisseur->adresse  }}</td>
                        <td>{{ $fournisseur->fax}}</td>
                        <td>{{ $fournisseur->ville}}</td>
                        <td><a href="relver_{{$fournisseur->f_id}}">voir</a></td>
                        </tr>
                    @endforeach
                </tbody>
              </table>
        </div>
    </div>
@endsection
