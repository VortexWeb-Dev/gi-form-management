<section id="config" class="mb-10">
    <div class="bg-white p-6 rounded-2xl shadow">
        <div class="mb-4">
            <h2 class="text-xl font-semibold"><?= htmlspecialchars($title ?? 'Configuration') ?></h2>
            <p class="text-sm text-gray-500"><?= htmlspecialchars($description ?? 'Manage system settings and form template configuration.') ?></p>
        </div>

        <div class="grid md:grid-cols-2 gap-6">
            <!-- Assign HR Roles -->
            <div class="border rounded-xl p-4 shadow-sm">
                <h3 class="text-lg font-medium mb-2">Assign HR Roles</h3>
                <p class="text-sm text-gray-500 mb-3">Select users who should have HR access to manage forms and approvals.</p>
                <select class="w-full px-3 py-2 border rounded-lg text-sm text-gray-700 focus:outline-none focus:ring focus:border-[#0c372a]">
                    <option>Select HR User</option>
                    <option>Jane Smith</option>
                    <option>John Doe</option>
                </select>
                <button class="mt-3 inline-block px-4 py-2 text-sm font-semibold text-white bg-[#0c372a] rounded-lg hover:bg-[#0a2a1a]">
                    Save
                </button>
            </div>

            <!-- Upload Form Templates -->
            <div class="border rounded-xl p-4 shadow-sm">
                <h3 class="text-lg font-medium mb-2">Upload Form Template</h3>
                <p class="text-sm text-gray-500 mb-3">Upload PDF, DOCX, or use the custom form builder.</p>
                <input type="file" class="block w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-[#0c372a] file:text-white hover:file:bg-[#0a2a1a]">
                <button class="mt-3 inline-block px-4 py-2 text-sm font-semibold text-white bg-[#0c372a] rounded-lg hover:bg-[#0a2a1a]">
                    Upload
                </button>
            </div>

            <!-- Define Mandatory Fields -->
            <div class="border rounded-xl p-4 shadow-sm col-span-full">
                <h3 class="text-lg font-medium mb-2">Mandatory Fields Per Template</h3>
                <p class="text-sm text-gray-500 mb-3">Set required fields for each uploaded template.</p>
                <select class="w-full mb-3 px-3 py-2 border rounded-lg text-sm text-gray-700 focus:outline-none focus:ring focus:border-[#0c372a]">
                    <option>Select Template</option>
                    <option>NDA Agreement</option>
                    <option>Leave Request</option>
                </select>
                <div class="grid grid-cols-2 gap-2 text-sm text-gray-700">
                    <label class="flex items-center">
                        <input type="checkbox" class="mr-2"> Full Name
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" class="mr-2"> Signature
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" class="mr-2"> Employee ID
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" class="mr-2"> Date of Submission
                    </label>
                </div>
                <button class="mt-4 inline-block px-4 py-2 text-sm font-semibold text-white bg-[#0c372a] rounded-lg hover:bg-[#0a2a1a]">
                    Save Fields
                </button>
            </div>
        </div>
    </div>
</section>