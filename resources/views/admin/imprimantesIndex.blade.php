@extends('../layout.structure')

@section('title', 'Imprimantes')

@section('content')
    @include('../layout.navbar')
    <div class="sub_nav">
        <div class="container">
            <ul>
                <li><a href="/public/dashboard">Tableau de bord / </a></li>
                <li><a href="#" class="active">Imprimantes</a></li>
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
    <div class="container mt-5">
        <a class="ajout" href="/public/imprimante">
            <span>+</span>
            Ajouter imprimante
        </a>
    </div>
    <div class="tickets_container">
        <div class="container mt-5">
            <table class="table table-hover">
                <thead>
                  <tr>
                    <th scope="col">Nome</th>
                    <th scope="col">Num serie</th>
                    <th scope="col">Lieu</th>
                    <th scope="col">Type</th>
                    <th scope="col">Modele</th>
                    <th scope="col">Compteur Initail</th>
                    <th></th>
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
                        <td><a href="{{ url('compteur_trace_' . $imprimante->id_imprt ) }}">trace</a></td>
                    </tr>
                    @endforeach
                </tbody>
              </table>
        </div>
    </div>
@endsection

