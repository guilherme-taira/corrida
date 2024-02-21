@extends('layouts.corridas')
@section('conteudo')
    <div class="page-heading">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="header-text">
                        <h2>{{ $viewData['title'] }}</h2>
                        <div class="div-dec"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-4">
        <div class="row">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    Editar Evento
                </div>
                <div class="card-body">
                    <h5 class="card-title">Data do Evento: {{ $viewData['corridas']->created_at }}</h5>
                    <form class="row g-3 needs-validation" method="POST" action="{{route('corridas.update',['corrida' => $viewData['corridas']->id])}}" novalidate>
                        @csrf
                        @method('put')
                        <div class="col-md-8">
                            <label for="validationCustom01" class="form-label">Título do Evento</label>
                            <input type="text" class="form-control" name="name" id="validationCustom01"
                                value="{{ $viewData['corridas']->name }}" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary" type="submit">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
