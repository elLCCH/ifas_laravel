<!DOCTYPE html><html lang="en" nighteye="enabled"><head><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <meta charset="utf-8">
    <title>Instituto de Formacion Artistica</title>
    <base href="/">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css">
      <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>


      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
      <!-- Ionicons -->
      <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
      <!-- Theme style -->

      <!-- Google Font: Source Sans Pro -->
      <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

      <!-- PARA ADMINLTE -->
      <!-- Google Font: Source Sans Pro -->
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
      <!-- Font Awesome Icons -->
      <link rel="stylesheet" href="/assets/Angular/assets/plugins/fontawesome-free/css/all.min.css">
      <!-- Theme style -->
      <link rel="stylesheet" href="/assets/Angular/assets/dist/css/adminlte.min.css">

      <link rel="stylesheet" href="/assets/Angular/assets/scripts_validation/estilos.min.css">

  <link rel="stylesheet" href="/assets/Angular/assets/styles.ef46db3751d8e999.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Trirong">
  </head>
    <app-root></app-root>
    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->





    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous">
    </script>


    <script src="/assets/Angular/runtime.8acea97c940ea2f40e7e.js" defer=""></script><script src="/assets/Angular/polyfills.6e24aca16d400ed18e82.js" defer=""></script><script src="/assets/Angular/main.3e7eff33ff79168b9f84.js" defer=""></script>

  <script src="/assets/Angular/assets/pdf-2.10.558.min.js" defer></script>
  <script src="/assets/Angular/assets/viewer-2.10.558.min.js" defer></script>
  <script src="/assets/Angular/assets/pdf.worker-2.10.558.min.js" defer></script>
  <style>
    body{

      /* background-image: url(" http://localhost:8000/fijos/fondopirata.jpg"); */
      /*background-image:  linear-gradient(-10deg, #b12a02 -100%, #ffffff 100%);
      background-size: cover;
      background-repeat: no-repeat;
      background-position: center center;
      background-attachment: fixed;*/
    }
  </style>
  <script type="text/javascript">
    // var rutacion = 'http://localhost:8000/';
    var rutacion = '';

  </script>
  <!-- PARA ADMINLTE -->

  <!-- jQuery -->
  <script src="/assets/Angular/assets/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <!-- <script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script> -->
  <!-- AdminLTE App -->
  <script src="/assets/Angular/assets/dist/js/adminlte.min.js"></script>


  <!-- NIEVE -->
  <style>
    body {
      margin: 0;
      /* overflow: hidden; */
    }

    #snowfall-wrapper {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      pointer-events: none;
    }

    .flake {
      position: absolute;
      color: #fff;
      pointer-events: none;
      display: block;
    }
  </style>

  <script>
    (function ($) {
      $.snowfall = {
        intervals: [],
        $wrapper: null,
        start: function (options, $wrapper) {
          var options = $.extend({}, {
            size: {
              min: 10,
              max: 20
            },
            interval: 500,
            color: '#fff',
            content: '&#10052;',
            disappear: 'linear'
          }, options);

          if ($wrapper == undefined) {
            $('body').append('<div id="snowfall-wrapper" />');
            $wrapper = $('#snowfall-wrapper');

            $wrapper.css({
              'overflow': 'hidden',
              'height': '100%',
              'width': '100%',
              'position': 'fixed',
              'top': '0',
              'left': '0'
            });
          }

          var $snowfall = $('<div class="flake" />').css({ 'position': 'fixed', 'top': '-50px' }).html(options.content);

          $.snowfall.$wrapper = $wrapper;
          $.snowfall.$wrapper.show();

          $.snowfall.intervals.push(setInterval(function () {
            var wrapperWidth = $wrapper.width(),
              wrapperHeight = $wrapper.height(),
              flakeSize = options.size.min + (Math.random() * options.size.max),
              duration = (wrapperHeight * 10) + (Math.random() * 2000),
              startPosition = (Math.random() * wrapperWidth) - 100;

            $snowfall.clone().appendTo($wrapper).css({
              'left': startPosition,
              'opacity': 0.5 + Math.random(),
              'font-size': flakeSize,
              'color': options.color
            }).animate({
              top: wrapperHeight - 40,
              left: (startPosition - 100) + (Math.random() * 200),
              opacity: 0.2
            }, duration, options.disappear, function () {
              $(this).remove();
            });
          }, options.interval));
        },
        stop: function () {
          $.snowfall.intervals.forEach(function (interval) {
            $.snowfall.$wrapper.hide();
            $.snowfall.$wrapper.children('div').each(function () {
              $(this).remove();
            });
            clearInterval(interval);
          });
        }
      };
    })(jQuery);

    // Iniciar la nieve
    $.snowfall.start({
      content: '<i class="fa fa-snowflake-o"></i>',
      size: {
        min: 20,
        max: 50
      }
    });
  </script>
  <script type="text/javascript">
    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-36251023-1']);
    _gaq.push(['_setDomainName', 'jqueryscript.net']);
    _gaq.push(['_trackPageview']);

    (function () {
      var ga = document.createElement('script');
      ga.type = 'text/javascript';
      ga.async = true;
      ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') +
        '.google-analytics.com/ga.js';
      var s = document.getElementsByTagName('script')[0];
      s.parentNode.insertBefore(ga, s);
    })();
  </script>
  </body></html>
