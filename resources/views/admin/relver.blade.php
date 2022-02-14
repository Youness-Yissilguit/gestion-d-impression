@extends('../layout.structure')

@section('title', 'relver')

@section('content')
    @include('../layout.navbar')
    <div class="sub_nav">
        <div class="container">
            <ul>
                <li><a href="/public/dashboard">Tableau de bord / </a></li>
                <li><a href="fournisseur" class="active">fournisseur</a></li>
                <li><a href="#" class="">relver</a></li>
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
    <div class="tickets_container">
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-8">
                    <form method="post">
                        @csrf
                        <label class="d-block">Filtre:</label>
                        <input class="p-2" type="text" name="num_serie" placeholder="N° serie" required>
                        <input class="btn btn-large btn-primary" type="submit" value="Rechercher" name="search">
                    </form>
                </div>
                <div class="col-4">
                    <div class="col-md-12 mb-1" align="right">
                        <a href="{{ url("pdf_".request('id') ) }}" class="btn btn-danger">Telecharger pdf</a>
                    </div>
                    <div class="col-md-12 mb-5" align="right">
                        <a href="{{ url("csv_".request('id') ) }}" class="btn btn-success">Telecharger csv</a>
                    </div>
                </div>
            </div>
            <table class="table table-hover">
                <thead>
                  <tr>
                    <th scope="col">lieu instalation</th>
                    <th scope="col">N serie</th>
                    <th scope="col">Date relver</th>
                    <th scope="col">Anc. Cptr N</th>
                    <th scope="col">Cptr. Actuel N</th>
                    <th>cout</th>
                    <th scope="col">Nr copie N</th>
                    <th scope="col">Forfait</th>
                    <th scope="col">montant</th>
                    <th scope="col">trace</th>
                  </tr>
                </thead>
                <tbody>
                    @php
                        $i = 0;
                    @endphp
                    @foreach ($data as $contrat)
                    <tr>
                        <td>{{ $contrat->lieu_nome }}</td>
                        <td>{{ $contrat->num_serie }}</td>
                        <td>{{ date('d-m-Y', strtotime($last_compt[$i]->date_relver)) }}</td>
                        <td>{{ $last_compt[$i]->compteur }}</td>
                        <td>{{ $contrat->nbt_impr}}</td>
                        <td>{{ $contrat->cout_nb }} dh</td>
                        <td>{{ $contrat->nbt_impr - $last_compt[$i]->compteur }}</td>
                        <td>175,00</td>
                        <td>{{ $contrat->cout_nb * ($contrat->nbt_impr - $last_compt[$i]->compteur) + 175}} DH</td>
                        <td><a href="{{ url('compteur_trace_' . $contrat->id_imprt ) }}">voir</a></td>
                    </tr>
                    @php
                    $i = $i + 1;
                    @endphp
                    @endforeach
                </tbody>
              </table>
        </div>
    </div>

@endsection
