<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session()->has('error'))
                <div id="error-message"
                    class="bg-red-300 text-white p-4 rounded-lg mb-4 mt-5 flex justify-between items-center">
                    <span>{{ session('error') }}</span>
                    <button onclick="document.getElementById('error-message').remove()"
                        class="bg-red-900 font-bold bg-transparent hover:bg-green-400 hover:text-white rounded-full w-6 h-6 flex items-center justify-center">
                        &times;
                    </button>
                </div>
            @endif
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 flex flex-col items-center justify-center">
                    <img src="{{ asset('storage/images/logo.png') }}" alt="Municipality Logo" height="200"
                        width="200">
                    <h1 class="font-semibold text-lg">WELCOME</h1>
                    <h4>Barangay Voters Search</h4>
                </div>
                <div class="mb-3 w-full flex-row text-gray-900 flex items-center justify-center">
                    <div class="flex justify-center items-center gap-x-4 w-full">
                        <a href="{{ route('leader-search') }}" class="py-3 bg-blue-500 rounded-xl text-white w-auto px-4 text-center">By Leaders</a>
                        <a href="{{ route('voter-search') }}" class="py-3 bg-blue-500 rounded-xl text-white w-auto px-4 text-center">By Voters</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
