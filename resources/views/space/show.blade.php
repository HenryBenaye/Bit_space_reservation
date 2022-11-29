<x-app-layout>
    <div class="mt-4 flex justify-center flex-col items-center ">
        <h1 class="font-bold text-2xl">{{$SpaceName}}</h1>
        <span class=" text-xl">Max students: {{$MaxStudents}}</span>
    </div>
    <div class="grid grid-rows-4 grid-flow-col gap-4" >
        @foreach($reservations as $reservation)
            <div class="p-6 bg-white border-b border-gray-200">
                <p class="font-bold">Name</p>
                <p>{{$reservation->user->name}}</p>
                <p class="font-bold">Time</p>
                <p>{{$date =\Carbon\Carbon::parse($reservation->begin_time)->format('d-m-Y')}}</p>
                <p>{{date("H:i", strtotime($reservation->begin_time))}}-{{date("H:i", strtotime($reservation->end_time))}}</p>
            </div>
        @endforeach
    </div>
    <div class="mt-4">
        {{$reservations->links()}}
    </div>
</x-app-layout>
