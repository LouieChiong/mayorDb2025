<div>
    <div class="flex flex-col mt-3 w-full gap-y-5">
        <select id="barnagay" required name="barangay" wire:model.live="barangay"
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

        <select id="precinct" name="precinct" wire:model.live="precinct"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-[250px]">
            <option value="">Select Precinct</option>
            @foreach ($precincts as $precinct)
                <option value="{{ $precinct }}"> {{ $precinct }} </option>
            @endforeach
        </select>

        <button>
            <button class="py-3 bg-blue-500 rounded-xl text-white">Search</button>
        </button>
    </div>
</div>
