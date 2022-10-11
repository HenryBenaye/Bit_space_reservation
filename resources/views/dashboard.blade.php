<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-center">
                <h3 class="font-bold text-2xl">Lijst met reserveringen</h3>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @foreach($reservations as $reservation)
                    <div class="p-6 bg-white border-b border-gray-200">
                        <p class="font-bold">Space</p>
                        <p>{{$reservation->space->name}}</p>
                        <p class="font-bold">Time</p>
                        <p>{{$reservation->begin_time}}-{{$reservation->end_time}}</p>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
</x-app-layout>
