<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Leader List') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">
            <div class="relative overflow-x-auto shadow-md bg-white sm:rounded-lg w-full min-h-96 max-h-[50rem] p-5">
                <table class="w-full border-collapse border-2 rounded-lg">
                    <thead>
                        <tr class="bg-blue-200">
                            <th class="px-4 py-2 text-left">Leader</th>
                            <th class="px-4 py-2 text-left">Barangay</th>
                            <th class="px-4 py-2 text-left">Purok/Sitio</th>
                            <th class="px-4 py-2 text-left">Precinct</th>
                            <th class="px-4 py-2 text-left">Counts</th>
                            <th class="px-4 py-2 text-left">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @if ($leaders->isEmpty())
                            <tr>
                                <td colspan="5" class="px-4 py-4 text-center">
                                    No Leader Found
                                </td>
                            </tr>
                        @else
                            @foreach ($leaders as $leader)
                                <tr class="hover:bg-gray-50 odd:bg-gray-100 even:bg-white"
                                    wire:key="leader-{{ $leader->id }}">
                                    <td class="px-4 py-2">{{ $leader->full_name }}</td>
                                    <td class="px-4 py-2">{{ optional($leader->barangay)->barangay_name ?? '-' }}</td>
                                    <td class="px-4 py-2">{{ optional($leader->barangay)->purok_name ?? '-' }}</td>
                                    <td class="px-4 py-2">{{ $leader->precinct ?? '-' }}</td>
                                    <td class="px-4 py-2">{{ $leader->voters->count() }}</td>
                                    <td class="px-4 py-2">
                                        <a href="{{ route('voters-list', ['leaderId' => $leader->id]) }}"
                                            class="px-2 py-1 bg-green-500 hover:bg-green-300 text-white rounded-xl">
                                            Voter List
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
