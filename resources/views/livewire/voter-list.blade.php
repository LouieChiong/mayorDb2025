<div>
    @if (session()->has('success'))
        <div id="success-message"
            class="bg-green-300 text-white p-4 rounded-lg mb-4 mt-5 flex justify-between items-center">
            <span>{{ session('success') }}</span>
            <button onclick="document.getElementById('success-message').remove()"
                class="text-green-900 font-bold bg-transparent hover:bg-green-400 hover:text-white rounded-full w-6 h-6 flex items-center justify-center">
                &times;
            </button>
        </div>
    @endif
    @if (session()->has('error'))
        <div id="error-message" class="bg-red-300 text-white p-4 rounded-lg mb-4 mt-5 flex justify-between items-center">
            <span>{{ session('error') }}</span>
            <button onclick="document.getElementById('error-message').remove()"
                class="bg-red-900 font-bold bg-transparent hover:bg-green-400 hover:text-white rounded-full w-6 h-6 flex items-center justify-center">
                &times;
            </button>
        </div>
    @endif
    <div class="flex flex-col w-full gap-5">
        <form class="flex flex-col justify-between items-center w-full h-full" wire:submit.prevent="submit">
            <div class="p-3 pl-7 w-full justify-start">
                <h3 for="name" class="block mb-2 text-gray-900 text-[18px]">Leader
                    Name: <b>{{ $this->leader->name }}</b> </h3>
            </div>
            <div class="p-3 pl-7 flex justify-start gap-x-3 w-full h-full">
                <div class="w-[30%]">
                    <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">First
                        Name</label>
                    <input type="text" id="first_name" wire:model="first_name" placeholder="Enter Barangay Name"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                        placeholder="John" required />
                    @error('first_name')
                        <span class="error text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="w-[30%]">
                    <label for="last_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Last
                        Name</label>
                    <input type="text" id="last_name" wire:model="last_name" placeholder="Enter Barangay Name"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                        placeholder="John" required />
                    @error('last_name')
                        <span class="error text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="w-[30%]">
                    <label for="status"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status</label>
                    <select id="status" wire:model.live="status"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        <option value="1">Alive</option>
                        <option value="0">Ceceased</option>
                    </select>
                </div>
            </div>
            <div class="p-3 pl-7 flex justify-start gap-x-3 w-full h-full">
                <div class="w-[30%]">
                    <label for="barangay"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Barangay</label>
                    <select id="barangay" wire:model.live="barangay"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        <option value="">Select Barangay</option>
                        @foreach ($barangays as $barangay)
                            <option value="{{ $barangay }}">
                                {{ $barangay }}</option>
                        @endforeach
                    </select>
                    @error('barangay')
                        <span class="error text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="w-[30%]">
                    <label for="purok"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Purok</label>
                    <select id="purok" wire:model.live="purok"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        <option value="">Select Purok</option>
                        @foreach ($puroks as $purok)
                            <option value="{{ $purok }}">
                                {{ $purok }}</option>
                        @endforeach
                    </select>
                    @error('purok')
                        <span class="error text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="w-[30%]">
                    <label for="precinct"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Precinct</label>
                    <select id="precinct" wire:model.live="precinct"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        <option value="">Select Precinct</option>
                        @foreach ($precincts as $precinct)
                            <option value="{{ $precinct }}">
                                {{ $precinct }}</option>
                        @endforeach
                    </select>
                    @error('precinct')
                        <span class="error text-red-500">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <button type="submit" class="mt-2 px-3 py-2 w-24 bg-blue-300 text-white rounded-xl">Create</button>
        </form>

        <div class="flex justify-between items-center w-full p-1">
            <div class="relative overflow-x-auto bg-white sm:rounded-lg w-full min-h-96 max-h-[50rem] p-5">
                <table class="w-full table-sm border-collapse border-2 rounded-lg">
                    <thead>
                        <tr class="bg-blue-100">
                            <th class="px-4 py-2 text-left border">First Name</th>
                            <th class="px-4 py-2 text-left border">Last Name</th>
                            <th class="px-4 py-2 text-left border">Barangay</th>
                            <th class="px-4 py-2 text-left border">Purok</th>
                            <th class="px-4 py-2 text-left border">Precinct</th>
                            <th class="px-4 py-2 text-left border">Status</th>
                            <th class="px-4 py-2 text-left border">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @if ($voters->isEmpty())
                            <tr>
                                <td colspan="7" class="px-4 py-4 text-center">
                                    No Records Found
                                </td>
                            </tr>
                        @else
                            @foreach ($voters as $voter)
                                <tr class="hover:bg-gray-50 odd:bg-gray-50 even:bg-white"
                                    wire:key="voter-{{ $voter->id }}">
                                    <td class="px-4 py-2">{{ $voter->first_name }}</td>
                                    <td class="px-4 py-2">{{ $voter->last_name }}</td>
                                    <td class="px-4 py-2">{{ $voter->barangay->barangay_name ?? '-' }}</td>
                                    <td class="px-4 py-2">{{ $voter->barangay->purok_name ?? '-' }}</td>
                                    <td class="px-4 py-2">{{ $voter->barangay->precinct ?? '-' }}</td>
                                    @if ($voter->is_alive == 1)
                                        <td class="px-4 py-2 text-white"><span class="bg-green-500 p-2">Alive</span>
                                        </td>
                                    @else
                                        <td class="px-4 py-2 text-white"><span class="bg-red-500 p-2">Deceased</span>
                                        </td>
                                    @endif
                                    <td class="px-4 py-2">

                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
