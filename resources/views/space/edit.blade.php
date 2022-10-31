<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <p>Wijzig je space</p>

        </x-slot>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('space.update', $space->id) }}">
            @method('PUT')
            @csrf
            <!-- Email Address -->
            <div>
                <x-input-label for="space_name" :value="__('Space')" />

                <x-text-input id="space_name" class="block mt-1 w-full" type="text" name="space_name" value="{{$space->name}}" required autofocus />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="max_students" :value="__('Max students')" />

                <x-text-input id="max_students" class="block mt-1 w-full"
                              type="number"
                              name="max_students" value="{{$space->max_students}}"/>

            </div>


            <div class="flex items-center justify-end mt-4">
                <x-primary-button class="ml-3">
                    {{ __('Klaar') }}
                </x-primary-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
