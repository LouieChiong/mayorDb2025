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

    @if (session()->has('duplicate-error'))
        <div id="error-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg">
                <div class="flex justify-between items-center border-b pb-3 mb-4">
                    <h2 class="text-xl font-bold text-red-600">Duplicate Entry</h2>
                    <button onclick="document.getElementById('error-modal').remove()"
                        class="text-red-500 hover:text-red-700">
                        &times;
                    </button>
                </div>
                <div class="text-gray-800">
                    <p class="mb-4">{{ session('duplicate-error') }}</p>
                    @if (session()->has('data'))
                        <ul class="list-disc pl-5 space-y-2">
                            <li>
                                <strong>Last Name:</strong> {{ session('data')['last_name'] }}
                            </li>
                            <li>
                                <strong>First Name:</strong> {{ session('data')['first_name'] }}
                            </li>
                            <li>
                                <strong>Middle Name:</strong> {{ session('data')['middle_name'] }}
                            </li>
                            <li>
                                <strong>Barangay:</strong> {{ session('data')['barangay'] }}
                            </li>
                            <li>
                                <strong>Purok:</strong> {{ session('data')['purok'] }}
                            </li>
                            <li>
                                <strong>Precinct:</strong> {{ session('data')['precinct'] }}
                            </li>
                            <li>
                                <strong>Under Leader:</strong> {{ session('data')['leader'] }}
                            </li>
                        </ul>
                    @endif
                </div>
                <div class="flex justify-end mt-4">
                    <button onclick="document.getElementById('error-modal').remove()"
                        class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-700">
                        Close
                    </button>
                </div>
            </div>
        </div>
    @endif


    <div class="flex flex-col w-full gap-5">
        <form class="flex flex-col justify-between items-center w-full h-full" wire:submit.prevent="submit">
            <div class="p-3 pl-7 w-full justify-start">
                <h3 for="name" class="block mb-2 text-gray-900 text-[18px]">Leader
                    Name: <b>{{ $this->leader->last_name .', '. $this->leader->first_name }}</b> </h3>
            </div>
            <div class="p-3 pl-7 flex justify-start gap-x-3 w-full h-full">
                <div class="w-[30%]">
                    <label for="last_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Last
                        Name</label>
                    <input type="text" id="last_name" wire:model="last_name" placeholder="Enter Last Name"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                        placeholder="John" required />
                    @error('last_name')
                        <span class="error text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                    <div class="w-[30%]">
                    <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">First
                        Name</label>
                    <input type="text" id="first_name" wire:model="first_name" placeholder="Enter First Name"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                        placeholder="John" required />
                    @error('first_name')
                        <span class="error text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="w-[30%]">
                    <label for="middle_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Middle
                        Name</label>
                    <input type="text" id="middle_name" wire:model="middle_name" placeholder="Enter Middle Name"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                        placeholder="John" required />
                    @error('middle_name')
                        <span class="error text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="w-[30%]">
                    <label for="status"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status</label>
                    <select id="status" wire:model.live="status"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        <option value="1">Alive</option>
                        <option value="0">Deceased</option>
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
                    <input type="text" id="precinct" wire:model="precinct" placeholder="Enter Precinct"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                            placeholder="Enter Precinct"/>
                    @error('precinct')
                        <span class="error text-red-500">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex gap-2 justify-center items-center">
                <button type="submit" class="mt-2 px-3 py-2 w-24 bg-blue-500 text-white rounded-xl">Create</button>
                <button type="button" class="mt-2 px-3 py-2 w-32 bg-green-500 text-white rounded-xl" wire:click="downloadPDF()">Download</button>
            </div>
        </form>

        <div class="flex justify-between items-center w-full p-1">
            <div class="relative overflow-x-auto bg-white sm:rounded-lg w-full min-h-96 max-h-[50rem] p-5">
                <table class="w-full table-sm border-collapse border-2 rounded-lg">
                    <thead>
                        <tr class="bg-blue-100">
                            <th class="px-4 py-2 text-left border">Member Name</th>
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
                                    <td class="px-4 py-2">{{ $voter->full_name }}</td>
                                    <td class="px-4 py-2">{{ optional($voter->barangay)->barangay_name ?? '-' }}</td>
                                    <td class="px-4 py-2">{{ optional($voter->barangay)->purok_name ?? '-' }}</td>
                                    <td class="px-4 py-2">{{ $voter->precinct ?? '-' }}</td>
                                    @if ($voter->is_alive == 1)
                                        <td class="px-4 py-2 text-white"><span class="bg-green-500 p-2">Alive</span>
                                        </td>
                                    @else
                                        <td class="px-4 py-2 text-white"><span class="bg-red-500 p-2">Deceased</span>
                                        </td>
                                    @endif
                                    <td class="px-4 py-2">
                                        <button wire:key="voter-{{ $voter->id }}"
                                            wire:click="editVoter({{ $voter->id }})"
                                            class="p-2 px-3 bg-blue-400 text-white rounded-xl">
                                            Edit
                                        </button>
                                        <button wire:key="voter-{{ $voter->id }}"
                                            wire:click="deleteVoter({{ $voter->id }})"
                                            class="p-2 px-3 bg-red-400 text-white rounded-xl">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="editModal"
        class="{{ $isModalOpen ? '' : 'hidden' }} fixed inset-0 z-50 p-12 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg w-[540px] relative">
            <div class="flex justify-between items-center p-5">
                <h1 class="text-xl">Edit Barangay Information</h1>
                <button type="button" class="text-gray-700 hover:text-gray-900 js-close-modal"
                    wire:click="closeModal()">
                    &#x2715; <!-- Close Icon -->
                </button>
            </div>
            <div class="flex flex-col items-center justify-center h-full p-5 w-full gap-y-3">
                <div class="flex justify-center flex-col items-start w-full">
                    <div class="w-full">
                        <label for="first_name"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">First Name</label>
                        <input type="text" id="js-first-name" wire:model="first_name"
                            class="disabled cursor-not-allowed bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                            placeholder="" disabled />
                    </div>
                    <div class="w-full">
                        <label for="last_name"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Last Name</label>
                        <input type="text" id="js-last-name" wire:model="last_name"
                            class="disabled cursor-not-allowed bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                            placeholder=""disabled />
                    </div>
                    <div class="w-full">
                        <label for="middle_name"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Middle Name</label>
                        <input type="text" id="js-middle-name" wire:model="middle_name"
                            class="disabled cursor-not-allowed bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                            placeholder=""disabled />
                    </div>
                    <div class="w-1/2">
                        <label for="js-status" class="block mb-2 text-sm font-medium">Status</label>

                        <select id="js-status" name="update_status" wire:model="updateStatus"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            <option value="0" {{ $this->status == 0 ? 'selected' : '' }}>Deceased</option>
                            <option value="1" {{ $this->status == 1 ? 'selected' : '' }}>Alive</option>
                        </select>
                    </div>

                    <div class="w-full">
                        <label for="barangay"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Barangay</label>
                        <select id="barangay" wire:model.live="edit_barangay" required
                            class="bg-gray-50 border  border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            <option value="">Select Barangay</option>
                            @foreach ($barangays as $barangay)
                                <option value="{{ $barangay }}">
                                    {{ $barangay }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="w-full">
                        <label for="purok_name"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Purok</label>
                        <select id="purok_name" wire:model.live="edit_purok" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            {{ empty($puroks) ? 'disabled' : '' }}>
                            <option value="">Select Purok</option>
                            @foreach ($puroks as $purok)
                                <option value="{{ $purok }}">
                                    {{ $purok }}</option>
                            @endforeach
                        </select>
                        @error('edit_purok')
                            <span class="error text-red-400">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="w-full">
                        <label for="edit_precinct"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Precinct</label>
                        <input type="text" id="js-edit-precinct" wire:model="edit_precinct" placeholder="Enter Precinct" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                            placeholder="Enter Precinct"/>
                        @error('edit_precinct')
                            <span class="error text-red-400">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="flex w-full justify-center items-center gap-x-3">
                    <button wire:click="updateVoter()"
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
                $('#js-first-name').val(data[0].first_name);
                $('#js-last-name').val(data[0].last_name);
                $('#js-middle-name').val(data[0].middle_name);
                $('#js-edit-precinct').val(data[0].precinct);
                $('#js-status').find('option:first').prop('selected', true);
                $('#editModal').removeClass('hidden');
            });
        });

        Livewire.on('closeModal', () => {
            $(document).ready(() => {
                $('#editModal').addClass('hidden');
            });
        });
    });
</script>
