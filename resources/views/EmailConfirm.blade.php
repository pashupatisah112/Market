<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <title>Online Market</title>
  
        <!-- Fonts -->
        <link rel="stylesheet" href="{{asset('css/app.css')}}">

    </head>
    <body>
        <p>Welcome to your <b>Esmartorder Online Shopping</b></p>
        <p>Your email confirmation code is <b>{{$confirmCode}}</b></p>
        <script src="{{asset('js/app.js')}}"></script>
    </body>

</html>