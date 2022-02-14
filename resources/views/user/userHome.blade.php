@extends('../layout/structure')

@section('title', 'Tableau de bord')



@section('content')
    @include('../layout/navbar')
    <div class="sub_nav">
        <div class="container">
            <ul>
                <li><a href="/public/dashboard" class="active">Tableau de bord /</a></li>
            </ul>
        </div>
    </div>
    <h1 class="text-center mt-5">Bienvenu !! <br> Utilisateur {{ $_SESSION['user_name'] }} </h1>
    <p class="text-center mt-5">IMP.CONTROL 9.5.5 Copyright (C) 2015-2021 created by Youness</p>
@endsection
