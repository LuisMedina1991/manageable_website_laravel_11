<!--inicio de archivos css cargados desde el directorio publico en caso de no utilizar el compilador de vite-->
{{--<link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" /> <!--archivo compilado de estilos bootstrap 5-->
<link href="{{ asset('plugins/icons/fontawesome/css/fontawesome.css') }}" rel="stylesheet" type="text/css" />  <!--comprobado-->
<link href="{{ asset('plugins/icons/fontawesome/css/brands.css') }}" rel="stylesheet" type="text/css" />  <!--comprobado-->
<link href="{{ asset('plugins/icons/fontawesome/css/solid.css') }}" rel="stylesheet" type="text/css" />  <!--comprobado-->
<link href="{{ asset('assets/css/styles.css') }}" rel="stylesheet" type="text/css" /> <!--estilos propios-->--}}
<!--fin de archivos css cargados desde el directorio publico en caso de no utilizar el compilador de vite-->

<!--inicio de cdn de bootstrap-->
{{--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">--}}
<!--fin de cdn de bootstrap-->

<link rel="shortcut icon" href="{{ asset('storage/monitor_1.png') }}" type="image/x-icon">   <!--icono de la pestaña del navegador-->

<!--el orden es importante 1ro los estilos bootstrap y luego los estilos personalizados-->
@vite(['resources/sass/app.scss','resources/css/custom_styles.css'])