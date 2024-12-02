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
        <div class="relative overflow-x-auto sm:rounded-lg w-full min-h-96 max-h-[30rem]">
            <div class="w-full flex justify-end items-end p-4">
                <button type="button" class="bg-green-500 p-2 rounded-xl text-white" wire:click="downloadExcel()">Download List</button>
            </div>
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 text-left">Barangay</th>
                        <th class="px-4 py-2 text-left">Purok</th>
                        <th class="px-4 py-2 text-left">Purok Leaders</th>
                        <th class="px-4 py-2 text-left">Purok Members</th>
                        <th class="px-4 py-2 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($barangays as $barangay)
                        <tr class="bg-white border-b hover:bg-gray-50" wire:key="barangay-{{ $barangay->id }}">
                            <td class="px-4 py-4">{{ $barangay->barangay_name ?? '-' }}</td>
                            <td class="px-4 py-4">{{ $barangay->purok_name ?? '-' }}</td>
                            <td class="px-4 py-4 text-center">{{ optional($barangay->leaders)->count() }}</td>
                            <td class="px-4 py-4 text-center">{{ optional($barangay->voters)->count() }}</td>
                            <td class="px-4 py-4 flex space-x-2">
                                <button wire:key="barangay-{{ $barangay->id }}"
                                    wire:click="editBarangay({{ $barangay->id }})"
                                    class="p-2 px-3 bg-blue-400 text-white rounded-xl">
                                    Edit
                                </button>
                                <button wire:key="barangay-{{ $barangay->id }}"
                                    wire:click="deleteBarangay({{ $barangay->id }})"
                                    class="p-2 px-3 bg-red-400 text-white rounded-xl">
                                    Delete
                                </button>
                                @if ($barangay->file_path)
                                    <button onclick="showPdf('{{ asset('storage/' . $barangay->file_path) }}')"
                                        class="p-2 px-3 bg-blue-400 text-white rounded-xl">
                                        File
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Modal -->
        <div id="editModal"
            class="hidden fixed inset-0 z-50 p-12 flex items-center justify-center bg-black bg-opacity-50">
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
                            <label for="barangay_name"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Barangay
                                Name</label>
                            <input type="text" id="edit_barangay_name" wire:model="barangay_name" value=""
                                placeholder="Enter Barangay Name"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                required />
                        </div>

                        <div class="w-full">
                            <label for="purok_name"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Purok Name</label>
                            <input type="text" id="edit_purok_name" wire:model="purok_name"
                                placeholder="Enter Sitio Name"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                required />
                        </div>

                        <div class="w-full">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                for="file_input">Upload file</label>
                            <input wire:model="file" accept=".pdf"
                                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                id="file_input" type="file">
                        </div>
                    </div>

                    <div class="flex w-full justify-center items-center gap-x-3">
                        <button wire:click="updateBarangay()"
                            class="px-3 py-2 bg-blue-500 rounded-xl text-white mt-4">Update</button>
                        <button type="button"
                            class="px-3 py-2 bg-red-500 rounded-xl text-white mt-4 js-close-modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>

        <div id="pdfViewModal"
            class="hidden fixed inset-0 z-50 p-12 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white rounded-lg shadow-lg w-[90%] h-[90%] relative">
                <div class="flex justify-between items-center p-5 bg-gray-100">
                    <h1 class="text-xl font-semibold">View PDF</h1>
                    <button type="button" class="text-gray-700 hover:text-gray-900 js-close-pdf-modal">
                        &#x2715; <!-- Close Icon -->
                    </button>
                </div>
                <div class="h-full w-full p-5">
                    <!-- Embed the PDF -->
                    <object data="" type="application/pdf" class="w-full h-full">
                        <p>Your browser does not support viewing PDFs.
                            <a href="" target="_blank" class="text-blue-500 underline js-pdf-download-link">
                                Click here to download the file.
                            </a>
                        </p>
                    </object>
                </div>
                <div class="flex justify-end p-5 bg-gray-100">
                    <button type="button"
                        class="px-3 py-2 bg-red-500 rounded-xl text-white js-close-pdf-modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('openModal', (data) => {
            $(document).ready(() => {
                $('#edit_barangay_id').val(data[0].id);
                $('#edit_barangay_name').val(data[0].barangay_name);
                $('#edit_purok_name').val(data[0].purok_name);
                $('#editModal').removeClass('hidden');
            });
        });

        $('.js-close-modal').click(() => {
            $('#editModal').addClass('hidden');
            $('#barangay_name').val();
            $('#purok_name').val();
        });
    });

    function showPdf(pdfUrl) {
        // Set the PDF URL in the <object> tag
        const pdfObject = document.querySelector('#pdfViewModal object');
        pdfObject.setAttribute('data', pdfUrl);

        // Set the fallback download link
        const downloadLink = document.querySelector('.js-pdf-download-link');
        downloadLink.setAttribute('href', pdfUrl);

        // Show the modal
        document.getElementById('pdfViewModal').classList.remove('hidden');
    }

    // Close modal logic
    document.addEventListener('click', (event) => {
        if (event.target.classList.contains('js-close-pdf-modal')) {
            const modal = document.getElementById('pdfViewModal');
            const pdfObject = modal.querySelector('object');

            // Hide the modal and clear the PDF URL
            modal.classList.add('hidden');
            pdfObject.setAttribute('data', '');
        }
    });
</script>
