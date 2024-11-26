<div>
    <div class="flex flex-col w-full">
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
            <div id="error-message"
                class="bg-red-300 text-white p-4 rounded-lg mb-4 mt-5 flex justify-between items-center">
                <span>{{ session('error') }}</span>
                <button onclick="document.getElementById('error-message').remove()"
                    class="bg-red-900 font-bold bg-transparent hover:bg-green-400 hover:text-white rounded-full w-6 h-6 flex items-center justify-center">
                    &times;
                </button>
            </div>
        @endif
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg w-full min-h-96 max-h-[30rem]">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-100 flex">
                        <th class="w-[30%] px-4 py-2 text-left">Leader Name</th>
                        <th class="w-[15%] px-4 py-2 text-left">Barangay</th>
                        <th class="w-[15%] px-4 py-2 text-left">Purok</th>
                        <th class="w-[15%] px-4 py-2 text-left">Precinct</th>
                        <th class="w-[20%] px-4 py-2 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($leaders as $leader)
                        <tr class="bg-white border-b flex items-center hover:bg-gray-50 text-sm"
                            wire:key="barangay-{{ $leader->id }}">
                            <td class="w-[30%] p-4">{{ $leader->name }}</td>
                            <td class="w-[15%] px-4 py-4 text-left">{{ $leader->barangay->barangay_name ?? '-' }}</td>
                            <td class="w-[15%] px-4 py-4 text-left">{{ $leader->barangay->purok_name ?? '-' }}</td>
                            <td class="w-[10%] px-4 py-4 text-left">{{ $leader->barangay->precinct ?? '-' }}</td>
                            <td class="w-[20%] px-4 py-4 flex space-x-2">
                                <button wire:key="leader-{{ $leader->id }}"
                                    wire:click="editL1eader({{ $leader->id }})"
                                    class="p-2 px-3 bg-blue-400 text-white rounded-xl">
                                    Edit
                                </button>
                                <button wire:key="leader-{{ $leader->id }}"
                                    wire:click="deleteLeader({{ $leader->id }})"
                                    class="p-2 px-3 bg-red-400 text-white rounded-xl">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- Modal -->
    <div id="editModal"
        class="{{ $isModalOpen ? '' : 'hidden' }} fixed inset-0 z-50 p-12 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg w-[540px] relative">
            <div class="flex justify-between items-center p-5">
                <h1 class="text-xl">Edit Barangay Information</h1>
                <button type="button" class="text-gray-700 hover:text-gray-900 js-close-modal">
                    &#x2715; <!-- Close Icon -->
                </button>
            </div>
            <div class="flex flex-col items-center justify-center h-full p-5 w-full gap-y-3">
                <div class="flex justify-center flex-col items-start w-full">
                    <div class="w-full">
                        <label for="name"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Barangay Name</label>
                        <input type="text" id="name" wire:model="leader_name" placeholder="Enter Barangay Name"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                            placeholder="John" required />
                    </div>

                    <div class="w-full">
                        <label for="barangay"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Barangay</label>
                        <select id="barangay" wire:model.live="edit_barangay" required
                            class="bg-gray-50 border  border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            <option value="">Select Barangay</option>
                            @foreach ($barangays as $barangay)
                                <option wire:key="barangay-{{ $barangay->id }}"
                                    value="{{ $barangay->barangay_name }}">
                                    {{ $barangay->barangay_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="w-full">
                        <label for="purok_name"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Purok</label>
                        <select id="purok_name" wire:model.live="edit_purok_name" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            {{ empty($puroks) ? 'disabled' : '' }}>
                            <option value="">Select Purok</option>
                            @foreach ($puroks as $id => $purok)
                                <option value="{{ $purok }}">{{ $purok }}</option>
                            @endforeach
                        </select>
                        @error('edit_purok_name')
                            <span class="error text-red-400">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="w-full">
                        <label for="precinct"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Precinct</label>
                        <select id="precinct" wire:model="edit_precinct" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            {{ empty($puroks) ? 'disabled' : '' }}>
                            <option value="">Select Precinct</option>
                            @foreach ($precincts as $precinct)
                                <option value="{{ $precinct }}">{{ $precinct }}</option>
                            @endforeach
                        </select>
                        @error('edit_precinct')
                            <span class="error text-red-400">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="flex w-full justify-center items-center gap-x-3">
                    <button wire:click="updateLeader()"
                        class="px-3 py-2 bg-blue-500 rounded-xl text-white mt-4">Update</button>
                    <button wire:click="closeModal()"
                        class="px-3 py-2 bg-red-500 rounded-xl text-white mt-4 js-close-modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('openModal', (data) => {
            $(document).ready(() => {
                $('#name').val(data.leader_name);
                $('#editModal').removeClass('hidden');
            });
        });

        Livewire.on('closeModal', () => {
            $(document).ready(() => {
                $('#name').val();
                $('#barangay').find('option:first').prop('selected', true);
                $('#editModal').addClass('hidden');
            });
        });
    });
</script>