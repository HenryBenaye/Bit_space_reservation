<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex justify-center flex-col items-center">
<h1 class="text-2xl font-bold">Reservations</h1>
<div class="flex flex-row">
    @foreach($reservations as $reservation)
        <div class="flex flex-col items-center shadow-lg space-x-4">
            <p class="font-bold">{{$reservation->space->name}}</p>
            <p>{{$reservation->student->name}} , Time: {{$reservation->begin_time}} - {{$reservation->end_time}}</p>
        </div>
    @endforeach
</div>



</body>
</html>
