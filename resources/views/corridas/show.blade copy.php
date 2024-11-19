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
                        @if ($viewData['corridas']->exibir_gap)
                             <th>Gap</th>
                        @endif
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
                            @if ($viewData['corridas']->exibir_tempo_liquido)
                                <td>{{ $corrida->chiptime }}</td>
                            @else
                                <td>{{ $corrida->time }}</td>
                            @endif
                            @if ($viewData['corridas']->exibir_gap)
                                <th>{{ $corrida->gap }}</th>
                            @endif

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <style>
        /* Classe para destacar as opções selecionadas */
        .selected-option {
            background-color: #d4edda; /* Exemplo de cor de fundo verde claro */
            color: #155724; /* Texto em verde escuro */
            font-weight: bold;
        }
    </style>

    <script>
$(document).ready(function() {
    let allData = []; // Armazena todos os dados iniciais da tabela
    let selectedValues = []; // Armazena as linhas das categorias selecionadas
    let selectedCategories = []; // Armazena as categorias selecionadas

    $('#myTable thead tr')
        .clone(true)
        .addClass('filters')
        .appendTo('#myTable thead');

    var table = $('#myTable').DataTable({
        order: [
            [0, 'asc']
        ],
        pageLength: 100, // Exibir mais registros por página, ajuste conforme necessário
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

            // Armazena todos os dados da tabela no array `allData` para preservar o estado inicial
            allData = api.rows().data().toArray();
            console.log("Dados iniciais da tabela armazenados em allData:", allData);

            api.columns().eq(0).each(function(colIdx) {
                var cell = $('.filters th').eq($(api.column(colIdx).header()).index());
                $(cell).empty();

                if (colIdx === 3) { // Coluna de "Corrida" com filtro múltiplo
                    var select = $('<select multiple class="form-control"><option value="">Todas</option></select>')
                        .appendTo(cell)
                        .on('change', function() {
                            applyFilter(); // Atualiza a tabela com os valores selecionados
                        });

                    // Adiciona as opções ao select
                    api.column(colIdx).data().unique().sort().each(function(d) {
                        var option = $('<option value="' + d + '">' + d + '</option>');
                        option.appendTo(select);
                    });

                    // Adiciona evento de clique nas opções do select múltiplo
                    select.on('click', 'option', function() {
                        const clickedValue = $(this).val();

                        if (selectedCategories.includes(clickedValue)) {
                            // Remove a categoria e suas linhas correspondentes
                            console.log(`Removendo categoria: ${clickedValue}`);
                            selectedCategories = selectedCategories.filter(category => category !== clickedValue);
                            selectedValues = selectedValues.filter(row => row[3] !== clickedValue);
                            $(this).removeClass('selected-option');
                        } else {
                            // Adiciona a categoria e suas linhas correspondentes
                            console.log(`Adicionando categoria: ${clickedValue}`);
                            selectedCategories.push(clickedValue);
                            allData.forEach(function(row) {
                                if (row[3] === clickedValue) {
                                    selectedValues.push(row);
                                }
                            });
                            $(this).addClass('selected-option');
                        }

                        console.log("Categorias selecionadas:", selectedCategories);
                        console.log("Linhas atualmente armazenadas em selectedValues:", selectedValues);

                        recreateTable(); // Recria a tabela com os valores selecionados
                    });
                } else {
                    // Cria um input para as outras colunas
                    $(cell).html('<input type="text" class="form-control" placeholder="" />');
                }

                // Evento para todos os inputs e selects
                $('input, select', $('.filters th').eq($(api.column(colIdx).header()).index()))
                    .off('keyup change')
                    .on('keyup change', function(e) {
                        var regexr = '({search})';
                        var cursorPosition = this.selectionStart;

                        api.column(colIdx)
                            .search(
                                this.value != '' ?
                                regexr.replace('{search}', '(((' + this.value + ')))') :
                                '',
                                this.value != '',
                                this.value == ''
                            )
                            .draw();

                        if (colIdx === 3) {
                            recreateTable();
                        }
                    });
            });

            function recreateTable() {
                // Destroi a tabela atual
                table.destroy();
                $('#myTable tbody').empty(); // Remove todas as linhas atuais da tabela

                if (selectedCategories.length > 0) {
                    console.log("Recriando tabela com selectedValues:", selectedValues);
                    // Recria a tabela com as linhas acumuladas de selectedValues
                    selectedValues.forEach(function(row) {
                        $('#myTable tbody').append('<tr><td>' + row.join('</td><td>') + '</td></tr>');
                    });
                } else {
                    console.log("Nenhuma categoria selecionada, restaurando estado inicial.");
                    // Restaura a tabela com todos os dados iniciais
                    allData.forEach(function(row) {
                        $('#myTable tbody').append('<tr><td>' + row.join('</td><td>') + '</td></tr>');
                    });
                }

                // Re-inicializa o DataTable
                table = $('#myTable').DataTable({
                    order: [
                        [0, 'asc']
                    ],
                    pageLength: 100,
                    "language": {
                        "info": "",
                        "paginate": {
                            "previous": "Anterior",
                            "next": "Próxima"
                        }
                    }
                });
            }
        }
    });
});

    </script>

@endsection
