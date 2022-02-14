@extends('../layout.structure')

@section('title', 'Administration')

@section('content')
    @include('../layout.navbar')
    <div class="sub_nav">
        <div class="container">
            <ul>
                <li><a href="dashboard.html">Tableau de bord /</a></li>
                <li><a href="#" class="active"> Utilisateurs</a></li>
            </ul>
        </div>
    </div>
    <section class="container">
        <div class="filtre">
            <form method="post">
                <input type="text" name="indentifiant" placeholder="indentifiant">
                <select class="form-select form-select-lg" aria-label=".form-select-lg example">
                    <option selected>Role</option>
                    <option value="1">Admin</option>
                    <option value="2">Technicien</option>
                    <option value="3">Utilisateurs</option>
                </select>
                <input type="submit" value="Rechercher" name="search">
            </form>
            <a class="ajout" href="user">
                <span>+</span>
                Ajouter utilisateur
            </a>
        </div>
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
    <section class="container mt-5">
        <section class="utilisateurs">
            <table class="table table-hover">
                <thead>
                  <tr>
                    <th scope="col">Identifiant</th>
                    <th scope="col">Nom de Famille</th>
                    <th scope="col">Adresses de messagerie</th>
                    <th scope="col">Téléphone</th>
                    <th scope="col">Lieu</th>
                    <th scope="col">Role</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                      <tr>
                        <th scope="row"><a href="user_{{ $user->user_id }}">{{ $user->identifiant }}</a></th>
                        <td>{{ $user->nome }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->telephone }}</td>
                        <td>{{ $user->adress }}</td>
                        <td>{{ $user->role }}</td>
                      </tr>
                    @endforeach
                </tbody>
              </table>
        </section>
    </section>
@endsection
