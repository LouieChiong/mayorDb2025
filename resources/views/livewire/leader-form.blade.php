<div>
    <div class="flex items-center justify-center h-full p-5 w-full gap-y-4">
        <div class="flex py-5 flex-row items-center justify-start w-1/4 gap-x-3">
            <form wire:submit.prevent="submit">
                <h2 class="pl-5">Add New Leader</h2>
                <div class="p-5 mt-2 flex flex-col gap-y-4">
                    <div>
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Leader
                            Name</label>
                        <input type="text" id="name" wire:model="name" placeholder="Enter Barangay Name"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                            placeholder="John" required />
                    </div>

                    <div class="">
                        <label for="barangay"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Barangay</label>
                        <select id="barangay" wire:model.live="barangay"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            <option value="">Select Barangay</option>
                            @foreach ($barangays->unique('barangay_name') as $barangay)
                                <option value="{{ $barangay->barangay_name }}">
                                    {{ $barangay->barangay_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="">
                        <label for="purok_name"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Purok</label>
                        <select id="purok_name" wire:model.live="purok_name"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            {{ empty($puroks) ? 'disabled' : '' }}>
                            <option value="">Select Purok</option>
                            @foreach ($puroks as $id => $purok)
                                <option value="{{ $purok }}">{{ $purok }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="">
                        <label for="precinct"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Precinct</label>
                        <select id="precinct" wire:model="precinct"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            {{ empty($puroks) ? 'disabled' : '' }}>
                            <option value="">Select Precinct</option>
                            @foreach ($precincts as $id => $precinct)
                                <option value="{{ $precinct }}">{{ $precinct }}</option>
                            @endforeach
                        </select>
                    </div>

                    @error('name')
                        <span class="error">{{ $message }}</span>
                    @enderror
                    <button type="submit" class="px-3 py-2 bg-blue-300 rounded-xl text-white">Submit</button>
                </div>
            </form>


        </div>
        <div class="w-3/4">
            @livewire('leader-list')
        </div>
    </div>
</div>
