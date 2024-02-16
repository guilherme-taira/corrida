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
                    <th>Evento(s)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($viewData['corridas'] as $corrida)
                <tr>
                    <td class="link-success"><a href="{{route('corridas.show',['corrida' => $corrida->id])}}">{{$corrida->name}}</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection
