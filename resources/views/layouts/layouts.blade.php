<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>For Life</title>

    <!-- Bootstrap core CSS -->
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="{{asset('css/fontawesome.css')}}">
    <link rel="stylesheet" href="{{asset('css/templatemo-574-mexant.css')}}">
    <link rel="stylesheet" href="{{asset('css/owl.css')}}">
    <link rel="stylesheet" href="{{asset('css/animate.css')}}">
    <link rel="stylesheet" href="{{asset('https://unpkg.com/swiper@7/swiper-bundle.min.css')}}">

  </head>

<body>


  <!-- ***** Header Area Start ***** -->
  <header class="header-area header-sticky bg-dark">
      <div class="container">
          <div class="row">
              <div class="col-12">
                  <nav class="main-nav">
                      <!-- ***** Logo Start ***** -->
                      <a href="index.html" class="logo">
                          <img src="{{asset('images/logo.png')}}" class="logomarca" alt="">
                      </a>
                      <!-- ***** Logo End ***** -->
                      <!-- ***** Menu Start ***** -->
                      <ul class="nav">
                          <li class="scroll-to-section"><a href="{{route('index')}}" class="active">Home</a></li>
                          <li class="scroll-to-section"><a href="{{route('corridas.index')}}">Resultados</a></li>
                          <li class="scroll-to-section"><a href="#about">Sobre Nós</a></li>
                          <li><a href="contact-us.html">Contato WhatsApp</a></li>
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
        <div class="slide-inner" style="background-image:url({{asset('images/bg.jpg')}})">
          <div class="container">
            <div class="row">
              <div class="col-lg-8">
                <div class="header-text">
                  <h2>Get <em>ready</em> for your business<br>&amp; upgrade <em>all aspects</em></h2>
                  <div class="div-dec"></div>
                  <p>Mexant HTML5 Template is provided for free of charge. This layout is based on Boostrap 5 CSS framework. Anyone can download and edit for any professional website. Thank you for visiting TemplateMo website.</p>
                  <div class="buttons">
                    <div class="green-button">
                      <a href="#">Discover More</a>
                    </div>
                    <div class="orange-button">
                      <a href="#">Contact Us</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="swiper-slide">
        <div class="slide-inner" style="background-image:url({{asset('images/slide-02.jpg')}}">
          <div class="container">
            <div class="row">
              <div class="col-lg-8">
                <div class="header-text">
                  <h2><em>Digital</em> Currency for you <br>&amp; Best <em>Crypto</em> Tips</h2>
                  <div class="div-dec"></div>
                  <p>You will see a bunch of free CSS templates when you search on Google. TemplateMo website is probably the best one because it is 100% free. It does not ask you anything in return. You have a total freedom to use any template for any purpose.</p>
                  <div class="buttons">
                    <div class="green-button">
                      <a href="#">Discover More</a>
                    </div>
                    <div class="orange-button">
                      <a href="#">Contact Us</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
  </div>

  <!-- ***** Main Banner Area End ***** -->

  <section class="services" id="services">
    <div class="container">
      <div class="row">
        <div class="col-lg-6">
          <div class="service-item">
            <i class="bi bi-broadcast text-danger"></i>
            <h4>Resultado em Tempo Real</h4>
            <p>Acompanhe o resultado das Provas em Tempo Real</p>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="service-item">
            <i class="bi bi-person-walking"></i>
            <h4>Resultado Todas Corridas</h4>
            <p>Veja o resultado de todas as corridas.</p>
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
            <img src="{{asset('images/logo.png')}}" alt="">
          </div>
        </div>
        <div class="col-lg-2 col-sm-4 col-6">
          <div class="item">
            <img src="{{asset('images/logo.png')}}" alt="">
          </div>
        </div>
        <div class="col-lg-2 col-sm-4 col-6">
          <div class="item">
            <img src="{{asset('images/logo.png')}}" alt="">
          </div>
        </div>
        <div class="col-lg-2 col-sm-4 col-6">
          <div class="item">
            <img src="{{asset('images/logo.png')}}" alt="">
          </div>
        </div>
        <div class="col-lg-2 col-sm-4 col-6">
          <div class="item">
            <img src="{{asset('images/logo.png')}}" alt="">
          </div>
        </div>
        <div class="col-lg-2 col-sm-4 col-6">
          <div class="item">
            <img src="{{asset('images/logo.png')}}" alt="">
          </div>
        </div>
      </div>
    </div>
  </section>

  <footer>
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <p>Copyright © {{date('Y')}} For Life All Rights Reserved.
            </div>
      </div>
    </div>
  </footer>

  <!-- Scripts -->
  <!-- Bootstrap core JavaScript -->
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>

    <script src="{{asset('js/isotope.min.js')}}"></script>
    <script src="{{asset('js/owl-carousel.js')}}"></script>

    <script src="{{asset('js/tabs.js')}}"></script>
    <script src="{{asset('js/swiper.js')}}"></script>
    <script src="{{asset('js/custom.js')}}"></script>
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
  </body>
</html>
