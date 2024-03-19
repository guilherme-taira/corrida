@extends('layouts.corridas')

@section('conteudo')
    <div class="page-heading">
        <img class="page-headingbg" src="{{ asset('images/heading-bg.jpg') }}" alt="">
        <div class="containerFoto">
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

    <div class="col-lg-12 mt-4 p-4">

        <!--- MENSAGEM DE CONFIRMAÇÂO DE SUCESSO --->
        @if (session('msg'))
            <div class="alert alert-success" role="alert">
                {{ session('msg') }}
            </div>
        @endif

        <table id="myTable" class="display">
            <thead>
                <tr>
                    <th>Evento(s)</th>
                    <th>Data</th>
                    @if (Auth::user())
                        <th>Editar</th>
                        <th>Apagar</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($viewData['corridas'] as $corrida)
                    <tr>
                        <td class="link-success "><a
                                href="{{ route('corridas.show', ['corrida' => $corrida->id]) }}">{{ $corrida->name }}</a>
                        </td>
                        <td class="link-success text-center">
                            {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $corrida->created_at)->format('d/m/Y') }}
                        </td>
                        @if (Auth::user())
                            <td class="link-success text-center"><a class="btn btn-warning"
                                    href="{{ route('editar', ['id' => $corrida->id]) }}">Editar</a></td>
                            <form method="POST" action="{{ route('corridas.destroy', ['corrida' => $corrida->id]) }}">
                                @csrf
                                @method('delete')
                                <td class="link-success  text-center">
                                    <button type="submit" class="btn btn-danger">Apagar</button>
                                </td>
                            </form>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function() {
            // Setup - add a text input to each footer cell
            $('#myTable thead tr')
                .clone(true)
                .addClass('filters')
                .appendTo('#myTable thead');

            var table = $('#myTable').DataTable({
                order: [
                    [1, 'desc']
                ],
                "language": {
                    "info": "",
                    "paginate": {
                        "previous": "Anterior",
                        "next": "Próxima"
                    }
                },
                orderCellsTop: true,
                fixedHeader: true,
                initComplete: function() {
                    var api = this.api();

                    // For each column
                    api
                        .columns()
                        .eq(0)
                        .each(function(colIdx) {
                            // Set the header cell to contain the input element
                            var cell = $('.filters th').eq(
                                $(api.column(colIdx).header()).index()
                            );
                            var title = $(cell).text();
                            $(cell).html('<input type="text" class="form-control" placeholder="' +
                                title + '" />');

                            // On every keypress in this input
                            $(
                                    'input',
                                    $('.filters th').eq($(api.column(colIdx).header()).index())
                                )
                                .off('keyup change')
                                .on('change', function(e) {
                                    // Get the search value
                                    $(this).attr('title', $(this).val());
                                    var regexr =
                                        '({search})'; //$(this).parents('th').find('select').val();

                                    var cursorPosition = this.selectionStart;
                                    // Search the column for that value
                                    api
                                        .column(colIdx)
                                        .search(
                                            this.value != '' ?
                                            regexr.replace('{search}', '(((' + this.value +
                                                ')))') :
                                            '',
                                            this.value != '',
                                            this.value == ''
                                        )
                                        .draw();
                                })
                                .on('keyup', function(e) {
                                    e.stopPropagation();

                                    $(this).trigger('change');
                                    $(this)
                                        .focus()[0]
                                        .setSelectionRange(cursorPosition, cursorPosition);
                                });
                        });
                },
            });
        });
    </script>
@endsection
