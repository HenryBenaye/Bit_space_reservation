
<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <p>Maak een nieuwe reservering</p>
        </x-slot>

        <form method="POST" action="{{ route('reservations.store') }}">
            @csrf
            <!-- Space -->
            <div>
                <x-input-label for="space_name" :value="__('Space')" />
                <select name="space_name" id="space_name" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    @foreach($spaces as $space)
                        <option  value="{{$space->name}}">{{$space->name}}</option>
                    @endforeach
                </select>
            </div>

            <!-- Time -->
            <div class="mt-4">
                <x-input-label for="begin_time" :value="__('Begin tijd')"  />

                <x-text-input id="begin_time" class="block mt-1 w-full" type="time" name="begin_time" min="08:30" max="17:00" required />

            </div>

            <div class="mt-4">
                <x-input-label for="end_time" :value="__('Eind tijd')" />

                <x-text-input id="end_time" class="block mt-1 w-full" type="time" name="end_time" min="08:30" max="17:00" required />

            </div>

            <div class="flex items-center justify-end mt-4">
                @if($errors->any())
                    {{ implode('', $errors->all(':message')) }}
                @endif
                <x-primary-button class="ml-4">
                    {{ __('Klaar') }}
                </x-primary-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
