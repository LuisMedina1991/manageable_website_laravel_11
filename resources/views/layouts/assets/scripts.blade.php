<!--inicio de archivos js cargados desde el directorio publico en caso de no utilizar el compilador de vite-->
{{--<script src="{{ asset('bootstrap/js/bootstrap.js') }}"></script>    <!--archivos compilados bootstrap-->
<script src="{{ asset('bootstrap/js/bootstrap.bundle.js') }}"></script>    <!--archivos compilados bootstrap-->
<script src="{{ asset('assets/js/scripts.js') }}"></script> <!--scripts propios-->--}}
<!--fin de archivos js cargados desde el directorio publico en caso de no utilizar el compilador de vite-->

<!--inicio de cdn de bootstrap-->
{{--<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>--}}
<!--fin de cdn de bootstrap-->

<!--inicio de cdn para los iconos de fontawesome-->
{{--<script src="https://kit.fontawesome.com/6614eec914.js" crossorigin="anonymous"></script>--}}
<!--fin de cdn para los iconos de fontawesome-->

@vite(['resources/js/app.js','resources/js/custom_scripts.js',])