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
                    <form action="{{ route('voters') }}" method="get">
                        @csrf
                        <div class="flex flex-row items-center justify-center gap-x-4">
                            <div class="w-full">
                                <label for="last_name"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Last Name</label>
                                <input type="text" id="js-last-name" name="last_name"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                                    placeholder=""/>
                            </div>
                            <div class="w-full">
                                <label for="first_name"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">First Name</label>
                                <input type="text" id="js-first-name" name="first_name"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                                    placeholder="" />
                            </div>
                            <div class="w-full">
                                <label for="middle_name"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Middle Name</label>
                                <input type="text" id="js-middle-name" name="middle_name"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                                    placeholder=""/>
                            </div>
                        </div>
                        @livewire('barangay-dropdown')
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
