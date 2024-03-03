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

</head>

<body>


    <!-- ***** Header Area Start ***** -->
    <header class="header-area header-sticky">
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
                            @if (Auth::user())
                                <li class="scroll-to-section text-white py-2">Usuário: {{ Auth::user()->name }}</li>
                                <li class="scroll-to-section">
                                <li class="scroll-to-section"><a href="{{ route('sair') }}" class="active">Logout</a>
                                </li>
                                </li>
                            @else
                                <li class="scroll-to-section"><a href="{{ route('login') }}" class="active">Login</a>
                                </li>
                            @endif

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
    <section class="service-details">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3">
                    <div class="section-heading">
                        <h6>Cadastro de Evento</h6>
                        <h4>Crie um novo Evento</h4>
                    </div>
                </div>
                <div class="col-lg-12 p-4">

                    <ul class="nacc">
                        <li class="active p-4">
                            <div>
                                <div>

                                    @if ($errors->any())
                                        <div>
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    @if (session('success'))
                                        <div>{{ session('success') }}</div>
                                    @endif

                                    <form action="{{ route('corridas.store') }}" method="post"
                                        enctype="multipart/form-data">
                                        @csrf

                                        <div class="col-12">
                                            <label for="validationTextarea" class="form-label">Dados da Corrida</label>
                                            <textarea class="form-control is-invalid" name="dados" id="validationTextarea"
                                                placeholder="Coloque os dados da corrida" required></textarea>
                                            <div class="invalid-feedback">
                                                Please enter a message in the textarea.
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <button class="btn btn-primary" type="submit">Enviar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        </div>
        </div>
        </div>
    </section>

    <section class="partners">
        <div class="container">
            <div class="row">
                <div class="col-lg-2 col-sm-4 col-6">
                    <div class="item">
                        <img src="assets/images/client-01.png" alt="">
                    </div>
                </div>
                <div class="col-lg-2 col-sm-4 col-6">
                    <div class="item">
                        <img src="assets/images/client-01.png" alt="">
                    </div>
                </div>
                <div class="col-lg-2 col-sm-4 col-6">
                    <div class="item">
                        <img src="assets/images/client-01.png" alt="">
                    </div>
                </div>
                <div class="col-lg-2 col-sm-4 col-6">
                    <div class="item">
                        <img src="assets/images/client-01.png" alt="">
                    </div>
                </div>
                <div class="col-lg-2 col-sm-4 col-6">
                    <div class="item">
                        <img src="assets/images/client-01.png" alt="">
                    </div>
                </div>
                <div class="col-lg-2 col-sm-4 col-6">
                    <div class="item">
                        <img src="assets/images/client-01.png" alt="">
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
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset('js/isotope.min.js') }}"></script>
    <script src="{{ asset('js/owl-carousel.js') }}"></script>

    <script src="{{ asset('js/tabs.js') }}"></script>
    <script src="{{ asset('js/swiper.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    <script>
        var interleaveOffset = 0.5;

        var swiperOptions = {
            loop: true,
            speed: 1000,
            grabCursor: true,
            watchSlidesProgress: true,
            mousewheelControl: true,
            keyboardControl: true,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev"
            },
            on: {
                progress: function() {
                    var swiper = this;
                    for (var i = 0; i < swiper.slides.length; i++) {
                        var slideProgress = swiper.slides[i].progress;
                        var innerOffset = swiper.width * interleaveOffset;
                        var innerTranslate = slideProgress * innerOffset;
                        swiper.slides[i].querySelector(".slide-inner").style.transform =
                            "translate3d(" + innerTranslate + "px, 0, 0)";
                    }
                },
                touchStart: function() {
                    var swiper = this;
                    for (var i = 0; i < swiper.slides.length; i++) {
                        swiper.slides[i].style.transition = "";
                    }
                },
                setTransition: function(speed) {
                    var swiper = this;
                    for (var i = 0; i < swiper.slides.length; i++) {
                        swiper.slides[i].style.transition = speed + "ms";
                        swiper.slides[i].querySelector(".slide-inner").style.transition =
                            speed + "ms";
                    }
                }
            }
        };

        var swiper = new Swiper(".swiper-container", swiperOptions);
    </script>
    <script src="{{ asset('js/isotope.min.js') }}"></script>
    <script src="{{ asset('js/owl-carousel.js') }}"></script>
    <script src="{{ asset('jquery.min.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
</body>

</html>
