<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(Auth::user()->type == 1)
                <div class="flex justify-center">
                    <h3 class="font-bold text-2xl">Lijst met reserveringen</h3>
                </div>
            @else
                <div class="flex justify-center">
                    <h3 class="font-bold text-2xl">Lijst met spaces</h3>

                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @foreach($reservations as $reservation)
                    <div class="p-6 bg-white border-b border-gray-200">
                        <p class="font-bold">Space</p>
                        <p>{{$reservation->space->name}}</p>
                        <p class="font-bold">Time</p>
                        <p>{{$date =\Carbon\Carbon::parse($reservation->begin_time)->format('d-m-Y')}}</p>
                        <p>{{date("H:i", strtotime($reservation->begin_time))}}-{{date("H:i", strtotime($reservation->end_time))}}</p>
                        <div class="flex flex-row">
                            <a href="{{route('reservations.edit',$reservation->id)}}">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </a>
                            <form action="{{route('reservations.destroy', $reservation->id)}}" method="post">
                                @method('delete')
                                @csrf
                                <button type="submit">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>

                    </div>

                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
