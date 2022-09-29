<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <body class="antialiased">
        <div>Hola {{$patient->name}}, el doctor {{$doctor->name}} te ha adjuntado una prescription a la submission {{$submission->title}}</div>
        <div>Veala aqui</div>
    </body>
</html>
