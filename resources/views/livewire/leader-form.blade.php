<div>
    <div class="flex flex-col items-center justify-center h-full p-5 w-full gap-y-4">
        <div class="flex py-5 flex-col items-start justify-start w-full gap-x-3">
            <form wire:submit.prevent="submit" class="flex flex-col w-full">
                <div class="flex flex-col w-full">
                    <h1 class="pl-5 text-center font-bold">Add New Leader</h1>
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
                    <button type="submit" class="w-[130px] px-3 py-2 bg-blue-500 rounded-xl text-white">Submit</button>
                    <button type="button" wire:click="downloadPDF()" class="w-[130px] px-3 py-2 bg-green-500 rounded-xl text-white">Download</button>
                </div>
            </form>
        </div>
        <div class="w-full">
            @livewire('leader-list')
        </div>
    </div>
</div>
