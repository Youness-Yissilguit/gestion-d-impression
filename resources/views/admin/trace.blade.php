@extends('../layout/structure')

@section('title', 'Trace')

@include('../helpers.functoins')

@section('content')
    @include('../layout/navbar')
    <div class="sub_nav">
        <div class="container">
            <ul>
                <li><a href="dashboard">Tableau de bord /</a></li>
                <li><a href="#" class="active">Trace</a></li>
            </ul>
        </div>
    </div>

    <div class="tickets_container mt-5">
        <form method="post" class="container">
            @csrf
            <select class="form-select p-2" aria-label="Default select example" name="nbr_trace">
                <option selected>Nomres de trace a afficher</option>
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="20">20</option>
                <option value="50">50</option>
                <option value="100">100</option>
              </select>
              <input type="submit" value="afficher" class="btn btn-primary">
        </form>
        <div class="container mt-5">
            <table class="table table-hover">
                <thead>
                  <tr>
                    <th scope="col">Source</th>
                    <th scope="col">Id</th>
                    <th scope="col">Date</th>
                    <th scope="col">Service</th>
                    <th scope="col">Message</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($traces as $trace)
                    <tr>
                        <th scope="row">{{ $trace->source}}</th>
                        <td><a href="<?php echoLink($trace->source, $trace->id_ele); ?>">{{ $trace->id_ele }}</a></td>
                        <td>{{ $trace->created_at }}</td>
                        <td>{{ $trace->service}}</td>
                        <td>{{ $trace->message}}</td>
                      </tr>
                    @endforeach
                </tbody>
              </table>
        </div>
    </div>
@endsection
