<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Voters List') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">
            <div class="relative overflow-x-auto shadow-md bg-white sm:rounded-lg w-full min-h-96 max-h-[50rem] p-5">
                <table class="w-full border-collapse border-2 rounded-lg">
                    <thead>
                        <tr class="bg-blue-200">
                            <th class="px-4 py-2 text-left">Voter Name</th>
                            <th class="px-4 py-2 text-left">Barangay</th>
                            <th class="px-4 py-2 text-left">Purok/Sitio</th>
                            <th class="px-4 py-2 text-left">Precinct</th>
                            <th class="px-4 py-2 text-left">Leader</th>
                            <th class="px-4 py-2 text-left">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @if ($voters->isEmpty())
                            <tr>
                                <td colspan="5" class="px-4 py-4 text-center">
                                    No Leader Found
                                </td>
                            </tr>
                        @else
                            @foreach ($voters as $voter)
                                <tr class="hover:bg-gray-50 odd:bg-gray-100 even:bg-white"
                                    wire:key="voter-{{ $voter->id }}">
                                    <td class="px-4 py-2">{{ $voter->full_name }}</td>
                                    <td class="px-4 py-2">{{ optional( $voter->barangay)->barangay_name ?? '-' }}</td>
                                    <td class="px-4 py-2">{{ optional( $voter->barangay)->purok_name ?? '-' }}</td>
                                    <td class="px-4 py-2">{{ $voter->precinct ?? '-' }}</td>
                                    <td class="px-4 py-2">
                                        @if ($voter->leader && !empty($voter->leader) && $voter->leader->id)
                                            {{ optional($voter->leader)->full_name  }}
                                        @else
                                            <span class="text-white bg-red-500 p-1 rounded-lg">Not Assigned</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2">
                                        @if ($voter->leader && !empty($voter->leader) && $voter->leader->id)
                                            <a href="{{ route('leader-list', ['leaderId' => $voter->leader->id]) }}"
                                                class="px-2 py-1 bg-green-500 hover:bg-green-300 text-white rounded-xl">
                                                See Leader
                                            </a>
                                        @endif
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
