@extends('layouts.app')

@section('content')
    <div id="app"></div>
    @vite('resources/js/app.js')
@endsection

<script>
    window.VUE_INITIAL_ROUTE = "{{ request()->path() }}";
</script>
