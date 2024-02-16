<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>For Life</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('css/templatemo-574-mexant.css') }}">
    <link rel="stylesheet" href="{{ asset('css/owl.css') }}">
    <link rel="stylesheet" href="{{ asset('css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('https://unpkg.com/swiper@7/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
</head>

<body>
    <!-- ***** Header Area Start ***** -->
    <header class="header-area header-sticky bg-dark">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav class="main-nav">
                        <!-- ***** Logo Start ***** -->
                        <a href="{{ route('index') }}" class="logo">
                            <img src="{{ asset('images/logo.png') }}" class="logomarca" alt="">
                        </a>
                        <!-- ***** Logo End ***** -->
                        <!-- ***** Menu Start ***** -->
                        <ul class="nav">
                            <li class="scroll-to-section"><a href="{{ route('index') }}" class="active">Home</a></li>
                            <li class="scroll-to-section"><a href="{{ route('corridas.index') }}">Resultados</a></li>
                            <li class="scroll-to-section d-none"><a href="#about">Sobre Nós</a></li>

                        </ul>
                        <a class='menu-trigger'>
                            <span>Menu</span>
                        </a>
                        <!-- ***** Menu End ***** -->
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <!-- ***** Header Area End ***** -->

    <!-- ***** Main Banner Area Start ***** -->
    <div class="swiper-container" id="top">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <div class="slide-inner" style="background-image:url({{ asset('images/bg.jpg') }})">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="header-text">
                                    <h2>Acompanhe o <em>Resultado</em> de Todas corridas e Eventos<br></h2>
                                    <div class="div-dec"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ***** Main Banner Area End ***** -->

        <div class="col-lg-12 mt-4 p-4">
            <table id="myTable" class="display">
                <thead>
                    <tr>
                        <th>Evento(s)</th>
                        <th>Data</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($viewData['corridas'] as $corrida)
                        <tr>
                            <td class="link-success"><a
                                    href="{{ route('corridas.show', ['corrida' => $corrida->id]) }}">{{ $corrida->name }}</a>
                            </td>
                            <td class="link-success">
                                {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $corrida->created_at)->format('d/m/Y') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>



        <section class="partners">
            <div class="container">
                <div class="row">
                    <div class="col-lg-2 col-sm-4 col-6">
                        <div class="item">
                            <img src="{{ asset('images/logo.png') }}" alt="">
                        </div>
                    </div>
                    <div class="col-lg-2 col-sm-4 col-6">
                        <div class="item">
                            <img src="{{ asset('images/logo.png') }}" alt="">
                        </div>
                    </div>
                    <div class="col-lg-2 col-sm-4 col-6">
                        <div class="item">
                            <img src="{{ asset('images/logo.png') }}" alt="">
                        </div>
                    </div>
                    <div class="col-lg-2 col-sm-4 col-6">
                        <div class="item">
                            <img src="{{ asset('images/logo.png') }}" alt="">
                        </div>
                    </div>
                    <div class="col-lg-2 col-sm-4 col-6">
                        <div class="item">
                            <img src="{{ asset('images/logo.png') }}" alt="">
                        </div>
                    </div>
                    <div class="col-lg-2 col-sm-4 col-6">
                        <div class="item">
                            <img src="{{ asset('images/logo.png') }}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <p>Copyright © {{ date('Y') }} For Life All Rights Reserved.
                    </div>
                </div>
            </div>
        </footer>

        <!-- Scripts -->
        <!-- Bootstrap core JavaScript -->

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


</body>

</html>
