<x-app-layout>
    <x-auth-card>
        <x-slot name="logo">
            <p>Wijzig je reservering</p>
        </x-slot>

        <form method="POST" action="{{ route('reservations.update', $reservation->id ) }}">
            @csrf
            @method('put')
            <!-- Space -->
            <div>
                <x-input-label for="space_name" :value="__('Space')" />
                <select name="space_name" id="space_name" value="{{$reservation->space->name}}" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    @foreach($spaces as $space)
                        <option  value="{{$space->name}}" {{$space->name != $reservation->space->name ?: "selected"}}>{{$space->name}}</option>
                    @endforeach
                </select>
            </div>

            <!-- TimeRule -->
            <div class="begin_time_box mt-4">
                <x-input-label for="begin_time" :value="__('Begin tijd')"  />

                <select class="rounded-md mt-1 shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="begin_time_hour" id="begin_time_hour">
                    @for($x = 8; $x <= 16; $x++)
                        <option  value="{{$x}}" {{ $x != date('H',strtotime($reservation->begin_time)) ?: "selected"}}>{{$x}}</option>
                    @endfor
                </select>
                <select class="rounded-md mt-1 shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="begin_time_minute" id="begin_time_minute">
                    @for($x = 00; $x <= 45; $x+=15)
                        <option value="{{$x}}" {{ $x != date('i',strtotime($reservation->begin_time)) ?: "selected"}}>{{$x}}</option>
                    @endfor
                </select>
            </div>

            <div class="end_time_box mt-4">
                <x-input-label for="end_time" :value="__('Eind tijd')" />

                <select class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="end_time_hour" id="end_time_hour">
                    @for($x = 8; $x <= 17; $x++)
                        <option value="{{$x}}" {{ $x != date('H',strtotime($reservation->end_time)) ?: "selected"}}>{{$x}}</option>
                    @endfor
                </select>
                <select class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="end_time_minute" id="end_time_minute">
                    @for($x = 00; $x <= 45; $x+=15)
                        <option value="{{$x}}" {{ $x != date('i',strtotime($reservation->end_time)) ?: "selected"}}>{{$x}}</option>
                    @endfor
                </select>
            </div>
            <x-text-input id="id" class="block mt-1 w-full" type="hidden" name="reservation_id" value="{{$reservation->id}}" required autofocus />


            <div class="flex items-center justify-end mt-4">
                <x-error-message>

                </x-error-message>
                <x-primary-button class="ml-4">
                    {{ __('Klaar') }}
                </x-primary-button>
            </div>
        </form>
    </x-auth-card>
</x-app-layout>
<script>
    jQuery("#end_time_hour").change(function() {
        if($("#end_time_hour").val() === "17")
        {
            $("#end_time_minute").prop('disabled', true);
        }
    });
</script>
