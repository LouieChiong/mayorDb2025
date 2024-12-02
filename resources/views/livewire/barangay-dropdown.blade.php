<div>
    <div class="flex flex-row items-center justify-center gap-x-4">
        <div class="w-full">
            <label for="last_name"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Last Name</label>
            <input type="text" id="js-last-name" name="last_name" wire:model="last_name"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                placeholder=""/>
        </div>
        <div class="w-full">
            <label for="first_name"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">First Name</label>
            <input type="text" id="js-first-name" name="first_name" wire:model="first_name"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                placeholder="" />
        </div>
        <div class="w-full">
            <label for="middle_name"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Middle Name</label>
            <input type="text" id="js-middle-name" name="middle_name" wire:model="middle_name"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                placeholder=""/>
        </div>
    </div>
    <div class="flex flex-col mt-3 w-full gap-y-5 gap-x-4 items-center justify-center">
        <div class="flex flex-row  gap-x-4">
            <select id="barnagay" name="barangay" wire:model.live="barangay"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-[250px]">
                <option value="">Select Barangay</option>
                @foreach ($barangays as $barangay)
                    <option value="{{ $barangay }}"> {{ $barangay }} </option>
                @endforeach
            </select>

            <select id="purok" name="purok" wire:model.live="purok"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-[250px]">
                <option value="">Select Purok / Sitio</option>
                @foreach ($puroks as $purok)
                    <option value="{{ $purok }}"> {{ $purok }} </option>
                @endforeach
            </select>
        </div>

        <div class="flex justify-center items-center gap-x-4 w-full">
            <button class="py-3 bg-blue-500 rounded-xl text-white w-auto px-4 text-center" wire:click="searchLeaders">Search Leaders</button>
            <button class="py-3 bg-blue-500 rounded-xl text-white w-auto px-4 text-center" wire:click="searchVoters">Search Voters</button>
        </div>
    </div>
</div>
