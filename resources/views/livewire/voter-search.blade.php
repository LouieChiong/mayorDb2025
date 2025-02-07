<div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">
        <div class="flex flex-col w-full">
            <div class="p-5 mt-2 flex gap-y-4 gap-x-4 w-full">
                <div class="w-full">
                    <label for="last_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Last
                        Name</label>
                    <input type="text" id="last_name" wire:model="last_name" placeholder="Enter Last Name"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-l  focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                        placeholder="John" required />
                </div>
                <div class="w-full">
                    <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">First
                        Name</label>
                    <input type="text" id="first_name" wire:model="first_name" placeholder="Enter First Name"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                        placeholder="John" required />
                </div>
                <div class="w-full">
                    <label for="middle_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Middle
                        Name</label>
                    <input type="text" id="middle_name" wire:model="middle_name" placeholder="Enter Middle Name"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg  focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                        placeholder="John" required />
                </div>
            </div>

            <div class="flex flex-row w-full gap-x-4 pl-5">
                <div class="w-full">
                    <label for="barangay"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Barangay</label>
                    <select id="barangay" wire:model.live="barangay" required
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        <option value="">Select Barangay</option>
                        @foreach ($barangays->unique('barangay_name') as $barangay)
                            <option value="{{ $barangay->barangay_name }}">
                                {{ $barangay->barangay_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="w-full">
                    <label for="purok_name"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Purok/ Sitio</label>
                    <select id="purok_name" wire:model.live="purok_name"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        {{ empty($puroks) ? 'disabled' : '' }}>
                        <option value="">Select Purok / Sitio</option>
                        @foreach ($puroks as $id => $purok)
                            <option value="{{ $purok }}">{{ $purok }}</option>
                        @endforeach
                    </select>
                    @error('purok_name')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div class="w-full">
                    <label for="precinct"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Precinct</label>
                    <input type="text" id="precinct" wire:model="precinct" placeholder="Enter Precinct" required
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                        placeholder="Enter Precinct"/>
                </div>
            </div>

            <div class="flex flex-row w-full gap-x-4 pl-5 mt-5 justify-center items-center">
                <button type="button" wire:click="filterSearch()" class="w-[130px] px-3 py-2 bg-orange-500 rounded-xl text-white">Filter</button>
                <button type="button" wire:click="resetFilter()" class="w-[130px] px-3 py-2 bg-red-500 rounded-xl text-white">Reset</button>
                <button type="button" wire:click="downloadPDF()" class="w-[130px] px-3 py-2 bg-green-500 rounded-xl text-white">Download</button>
            </div>
        </div>

        <div class="relative overflow-x-auto shadow-md bg-white sm:rounded-lg w-full min-h-96 max-h-[60rem] p-5">
            <div class="min-h-3/4 mt-5">

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
                                    <td class="px-4 py-2 ">
                                        @if ($voter->leader && !empty($voter->leader) && $voter->leader->id)
                                            <a href="{{ route('voters-list', ['leaderId' => $voter->leader->id]) }}"
                                                class="px-2 py-1 bg-green-500 hover:bg-green-300 text-white rounded-xl w-full flex justify-center items-center">
                                                <x-svg.user/>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $voters->links() }}
            </div>
        </div>
    </div>
</div>
