@extends('layouts.corridas')
@section('conteudo')

<div class="page-heading">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="header-text">
                    <h2>{{$viewData['title']}}</h2>
                    <div class="div-dec"></div>
                </div>
            </div>
        </div>
    </div>
</div>

    <div class="col-lg-12 mt-4 p-4">
        <table id="myTable" class="display">
            <thead>
                <tr>
                    <th>Rank</th>
                    <th>Número</th>
                    <th>Nome</th>
                    <th>Corrida</th>
                    <th>Categoria</th>
                    <th>Time</th>
                    <th>Sx</th>
                </tr>
            </thead>
            <tbody>
                @foreach (json_decode($viewData['corridas']->dados) as $corrida)
                    <tr>
                        <td>{{$corrida->rank}}</td>
                        <td>{{$corrida->realbib}}</td>
                        <td>{{$corrida->lastname. " ". $corrida->firstname}}</td>
                        <td>{{$corrida->race}}</td>
                        <td>{{$corrida->category}}</td>
                        <td>{{$corrida->team}}</td>
                        <td>{{$corrida->sex}}</td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection
