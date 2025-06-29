@extends('layouts.corridas')

@section('conteudo')
<div id="app">
    <corrida-edit :id='@json($id)'></corrida-edit>
</div>
@endsection
