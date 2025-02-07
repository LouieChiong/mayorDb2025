<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Leader List') }}
        </h2>
    </x-slot>

    <div class="py-12">
        @livewire('leader-search')
    </div>
</x-app-layout>
