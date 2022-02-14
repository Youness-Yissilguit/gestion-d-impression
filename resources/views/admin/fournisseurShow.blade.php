@extends('../layout/structure')

@section('title', 'Administration')
@php
    if(isset($fournisseur[0]['f_id'])){

    }else{

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
            @if(isset($fournisseur[0]['f_id']))
                <h4>Fournisseur - {{ $fournisseur[0]['nome'] }}</h4>
            @else
                <h4>Nouvelle elements - fournisseur</h4>
            @endif
            <hr>
            @if(isset($fournisseur[0]['f_id']))
            <ul class="select_list_menu" id="test">
                <li class="active" data-item_to_show='1'>fournisseur</li>
                <li data-item_to_show='2'>Contrats</li>
            </ul>

            <div class="hide" id="2">
                <table class="table table-hover mt-5">
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
            </div>
            @endif
            <div class="hide show" id="1">
                <form class="row g-3 mt-5" method="post">
                    @csrf
                    <div class="col-md-6 mb-3">
                      <label for="nome" class="form-label">Nom</label>
                      <input type="text" class="form-control" id="nome" value="{{ $fournisseur[0]['nome'] ?? ''}}" name="nome">
                    </div>
                    <div class="col-md-6 mb-3">
                      <label for="prenom" class="form-label">Prenome</label>
                      <input type="text" class="form-control" id="prenom"  value="{{ $fournisseur[0]['prenom']  ?? ''}}" name="prenom">
                    </div>
                    <div class="col-6 mb-3">
                      <label for="adresse" class="form-label">Adress</label>
                      <input type="text" class="form-control" id="adresse" value="{{ $fournisseur[0]['adresse']  ?? ''}}" name="adresse">
                    </div>
                    <div class="col-6 mb-3">
                      <label for="ville" class="form-label">Ville</label>
                      <input type="text" class="form-control" id="ville" value="{{ $fournisseur[0]['ville']  ?? ''}}" name="ville">
                    </div>
                    <div class="col-md-6 mb-3">
                      <label for="code" class="form-label">Code postak</label>
                      <input type="text" class="form-control" id="code" value="{{ $fournisseur[0]['code_postal']  ?? ''}}" name="code_postal">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="fax" class="form-label">Fax</label>
                        <input type="text" class="form-control" id="fax" value="{{ $fournisseur[0]['fax']  ?? ''}}" name="fax">
                    </div>
                    @if(isset($fournisseur[0]['f_id']))
                        <div class="col-12 text-center mt-5">
                            <input class="btn btn-primary" type="submit" value="sauvgarder">
                        </div>
                    @else
                        <div class="col-12 text-center mt-5">
                            <input class="btn btn-primary" type="submit" value="Ajouter utilisateur">
                        </div>
                    @endif
                  </form>
                  @if (isset($fournisseur[0]['f_id']))
                  <form action="fournisseur_{{ $fournisseur[0]['f_id']}}" class="text-center mt-3" method="POST">
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
