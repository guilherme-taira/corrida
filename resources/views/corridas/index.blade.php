@extends('layouts.app')

@section('content')
  <div id="app"></div> <!-- NÃO renderiza componentes direto aqui -->
  @vite('resources/js/app.js')
  <script>
    window.authUserId = {{ auth()->id() ?? 'null' }};
  </script>
@endsection
