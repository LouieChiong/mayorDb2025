<div class="flex items-center justify-center h-full p-5 w-full gap-y-4">
    <div class="flex py-5 flex-row items-center justify-start w-1/4 gap-x-3">
        <form wire:submit.prevent="submit">
            <h2>Add New Barangay</h2>
            <div class="p-5 mt-2 flex flex-col gap-y-4">
                <div>
                    <label for="barangay_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Barangay Name</label>
                    <input type="text" id="barangay_name" wire:model="barangay_name" placeholder="Enter Barangay Name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " placeholder="John" required />
                </div>

                <div class="">
                    <label for="purok_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Purok Name</label>
                    <input type="text" id="purok_name" wire:model="purok_name" placeholder="Enter Sitio Name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " placeholder="John" required />
                </div>

                <div>
                    <label for="precinct" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Precinct</label>
                    <input type="text" id="precinct" wire:model="precinct" placeholder="Enter Barangay Name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " placeholder="John" required />
                </div>

                <div class="">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file_input">Upload file</label>
                    <input wire:model="file" accept=".pdf"  class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" id="file_input" type="file">
                </div> 
                @error('name') <span class="error">{{ $message }}</span> @enderror
                <button type="submit" class="px-3 py-2 bg-blue-300 rounded-xl text-white">Submit</button>
            </div>
        </form>


    </div>
    <div class="w-3/4">
        @livewire('barangay-list')
    </div>
</div>
