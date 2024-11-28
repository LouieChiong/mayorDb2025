<div>
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
                <option value="">Select Purok</option>
                @foreach ($puroks as $purok)
                    <option value="{{ $purok }}"> {{ $purok }} </option>
                @endforeach
            </select>
        </div>

        <button class="py-3 bg-blue-500 rounded-xl text-white w-1/2 text-center">Search</button>
    </div>
</div>
