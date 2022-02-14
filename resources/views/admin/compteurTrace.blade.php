@extends('../layout.structure')

@section('title', 'trace compteur')

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
            <form method="post">
                @csrf
                <label for="">choisir le mois:</label>
                <input class="p-2" type="date" name="date_trace" required>
                <input class="btn btn-large btn-primary" type="submit" value="Rechercher" name="search">
            </form>
            <table class="table table-hover mt-5">
                <thead>
                  <tr>
                    <th scope="col">id</th>
                    <th scope="col">N serie</th>
                    <th>Lieu instal</th>
                    <th scope="col">Date Relvé</th>
                    <th scope="col">Compteur</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($compteurs as $compteur)
                    <tr>
                        <td><a href="{{ url('imprimante_' . $compteur->id_imp ) }}">{{ $compteur->id_imp }}</a></td>
                        <td>{{ $compteur->num_serie }}</td>
                        <td>{{ $compteur->lieu }}</td>
                        <td>{{ $compteur->date_relver }}</td>
                        <td>{{ $compteur->compteur }}</td>
                    </tr>
                    @endforeach
                </tbody>
              </table>
        </div>
    </div>
@endsection

