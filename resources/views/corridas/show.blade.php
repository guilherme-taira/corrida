@extends('layouts.corridas')
@section('conteudo')
    <div class="page-heading">
        <img class="page-headingbg" src="{{ asset('images/heading-bg.jpg') }}" alt="">
        <div class="containerFoto">
            <div class="row">
                <div class="col-lg-12">
                    <div class="header-text">
                        <h4 class="title-responsive">{{ $viewData['title'] }}</h4>
                        <div class="div-dec"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-12 mt-4 p-4">
        <div class="table-responsive">
            <table id="myTable" class="table table-striped">
                <thead>
                    <tr>
                        <th>Rank</th>
                        <th>Número</th>
                        <th>Nome</th>
                        <th>Corrida</th>
                        <th>Categoria</th>
                        <th>Sexo</th>
                        <th>Tempo</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach (json_decode($viewData['corridas']->dados) as $corrida)
                        <tr>
                            <td>{{ $corrida->rank }}</td>
                            <td>{{ $corrida->realbib }}</td>
                            <td>{{ $corrida->lastname . ' ' . $corrida->firstname }}</td>
                            <td>{{ $corrida->race }}</td>
                            <td>{{ $corrida->category }}</td>
                            <td>{{ $corrida->sex }}</td>
                            <td>{{ $corrida->time }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        $(document).ready(function() {
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
                initComplete: function() {
                    var api = this.api();

                    // For each column
                    api
                        .columns()
                        .eq(0)
                        .each(function(colIdx) {
                            // Set the header cell to contain the input element or select element for category
                            var cell = $('.filters th').eq(
                                $(api.column(colIdx).header()).index()
                            );

                            // Clear the content of the header cell
                            $(cell).empty();

                            if (colIdx === 0) { // Coluna de Rank
                                // Create input element
                                $(cell).html(
                                    '<input type="text" class="form-control" placeholder="" />');
                            } else if (colIdx === 3 || colIdx === 4 || colIdx ===
                                5) { // Coluna de categoria
                                // Create select element
                                var select = $(
                                        '<select class="form-control"><option value="">Todas</option></select>'
                                    )
                                    .appendTo(cell)
                                    .on('change', function() {
                                        var val = $.fn.dataTable.util.escapeRegex(
                                            $(this).val()
                                        );

                                        api.column(colIdx)
                                            .search(val ? '^' + val + '$' : '', true, false)
                                            .draw();

                                        if (val !== '') {
                                            reorderRankColumn();
                                        }
                                    });

                                // Add options to select element
                                api.column(colIdx).data().unique().sort().each(function(d) {
                                    select.append('<option value="' + d + '">' + d +
                                        '</option>');
                                });
                            } else {
                                // Create input element
                                $(cell).html(
                                    '<input type="text" class="form-control" placeholder="" />');
                            }

                            // On every keypress/change in input/select
                            $('input, select', $('.filters th').eq($(api.column(colIdx).header())
                                    .index()))
                                .off('keyup change')
                                .on('keyup change', function(e) {
                                    // Get the search value
                                    $(this).attr('title', $(this).val());
                                    var regexr = '({search})';

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

                                    if (colIdx === 3 || colIdx === 4 || colIdx === 5) {
                                        resetTable();
                                        reorderRankColumn();
                                    }
                                })
                                .on('keyup', function(e) {
                                    e.stopPropagation();

                                    $(this).trigger('change');
                                    $(this)
                                        .focus()[0]
                                        .setSelectionRange(cursorPosition, cursorPosition);
                                });
                        });


                    var api = this.api();

                    // Armazenar uma cópia dos dados originais da tabela
                    var originalData = api.rows().data().toArray();

                    // Função para redefinir a tabela para os dados originais
                    function resetTable() {
                        // Limpar a tabela e adicionar os dados originais
                        api.clear().rows.add(originalData).draw();

                        // Reordenar a coluna de rank numericamente
                        reorderRankColumn();
                    }


                    function reorderRankColumn() {
                        var table = $('#myTable').DataTable();
                        var data = table.rows({
                            search: 'applied'
                        }).data().toArray(); // Get all filtered data
                        var newData = [];

                        // Update the rank values in the data array
                        for (var i = 0; i < data.length; i++) {
                            data[i][0] = i + 1; // Update the rank value
                            newData.push(data[i]);
                        }

                        // Clear and add the updated data to the DataTable
                        table.clear().rows.add(newData).draw();
                    }

                },
            });
        });
    </script>
@endsection
