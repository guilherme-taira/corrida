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
                    <th>Tempo</th>
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
                        <td>{{$corrida->time}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>

        $(document).ready(function () {
    // Setup - add a text input to each footer cell
    $('#myTable thead tr')
        .clone(true)
        .addClass('filters')
        .appendTo('#myTable thead');

    var table = $('#myTable').DataTable({
        order: [
        [0, 'asc']
    ],
        orderCellsTop: true,
        fixedHeader: true,
        initComplete: function () {
            var api = this.api();

            // For each column
            api
                .columns()
                .eq(0)
                .each(function (colIdx) {
                    // Set the header cell to contain the input element
                    var cell = $('.filters th').eq(
                        $(api.column(colIdx).header()).index()
                    );
                    var title = $(cell).text();
                    $(cell).html('<input type="text" class="form-control" placeholder="' + title + '" />');

                    // On every keypress in this input
                    $(
                        'input',
                        $('.filters th').eq($(api.column(colIdx).header()).index())
                    )
                        .off('keyup change')
                        .on('change', function (e) {
                            // Get the search value
                            $(this).attr('title', $(this).val());
                            var regexr = '({search})'; //$(this).parents('th').find('select').val();

                            var cursorPosition = this.selectionStart;
                            // Search the column for that value
                            api
                                .column(colIdx)
                                .search(
                                    this.value != ''
                                        ? regexr.replace('{search}', '(((' + this.value + ')))')
                                        : '',
                                    this.value != '',
                                    this.value == ''
                                )
                                .draw();
                        })
                        .on('keyup', function (e) {
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
