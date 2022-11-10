<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>


</head>
<body class="antialiased h-screen flex flex-col justify-center items-center">
<div class="flex flex-col justify-center items-center ease-in duration-500 welcome-box opacity-0 duration-1000">
    <h1 class="text-4xl">Welkom bij Bit reserveringen</h1>
    @if (Route::has('login'))
        <div>
            @auth
                <a href="{{route('reservations.show', Auth::user()->id)}}" class="text-m text-gray-700 dark:text-gray-500 ">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="text-m text-gray-700 dark:text-gray-500 hover:text-purple-500 duration-1000">Login</a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="ml-4 text-m text-gray-700 dark:text-gray-500 hover:text-purple-500 duration-1000">Registreer</a>
                @endif
            @endauth
        </div>
    @endif

</div>
<script>
    $( document ).ready(function() {
        $(".welcome-box").toggleClass('opacity-100');
    });
</script>
</body>
</html>
