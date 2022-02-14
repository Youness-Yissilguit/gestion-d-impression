@extends('../layout.structure')

@section('title', 'Tickets')

@section('content')
    @include('../layout.navbar')
    <div class="sub_nav">
        <div class="container">
            <ul>
                <li><a href="#">Tableau de bord / </a></li>
                <li><a href="#" class="active">Tickets</a></li>
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
    <div class="container">
        <div class="row mt-5">
            <div class="col-md">
                <div class="tick_box y">
                    <h4>
                        <?php echo ($sum<10) ?  '0'. $sum : $sum;?> <br>
                        Tickets
                    </h4>
                </div>
            </div>
            <div class="col-md">
                <div class="tick_box r">
                    <h4>
                        <?php echo ($sum_nr<10) ?  '0'. $sum_nr : $sum_nr;?> <br>
                        Tickets non résolus
                    </h4>
                </div>
            </div>
            <div class="col-md">
                <div class="tick_box g">
                    <h4>
                        <?php echo ($sum_r<10) ?  '0'. $sum_r : $sum_r;?> <br>
                        Ticket résolus
                    </h4>
                </div>
            </div>
        </div>
    </div>
    <div class="tickets_container">
        <div class="container-fluid mt-5">
            <table class="table table-hover">
                <thead>
                  <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Titre</th>
                    <th scope="col">Statue</th>
                    <th scope="col">Date d'ouverture</th>
                    <th scope="col">Priorité</th>
                    <th scope="col">Demandeur</th>
                    <th scope="col">Categorie</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($tickets as $ticket)
                        <tr>
                        <td>{{ $ticket->ticket_id }}</td>
                        <th scope="row">
                            <a href="/public/ticket_<?php echo $ticket->ticket_id;?>">
                            {{ $ticket->titre }}
                        </a>
                        </th>
                        <td class="statut">
                            @if ($ticket->statue == "en cours")
                            <img src="assets/work-in-progress.png" alt="">
                            @elseif($ticket->statue == "resolut")
                            <img src="assets/checked.png" alt="">
                            @else
                            <img src="assets/new.png" alt="">
                            @endif
                            {{ $ticket->statue }}
                        </td>
                        <td>{{ $ticket->date_ouvert }}</td>
                        <td class="<?php
                            if($ticket->priorite == "moyenne")
                                echo "alert alert-warning";
                            else if($ticket->priorite == "danger")
                                echo "alert alert-danger";
                            else
                                echo "alert alert-info";
                            ?>" >
                            {{ $ticket->priorite}}
                        </td>
                        <td>{{ $ticket->username  }}</td>
                        <td>{{ $ticket->cat_name}}</td>
                        </tr>
                    @endforeach
                </tbody>
              </table>
        </div>
    </div>
@endsection
