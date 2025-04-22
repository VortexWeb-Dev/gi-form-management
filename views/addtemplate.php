<section id="add-template" class="mb-10">
    <div class="bg-white p-6 rounded-2xl shadow">
        <h2 class="text-xl font-semibold mb-4"><?= htmlspecialchars($title ?? 'Add New Template') ?> | <?= htmlspecialchars($description ?? '') ?></h2>
        <main class="space-y-6">

            <!-- Template Name -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Template Name</label>
                <input name="template_name" type="text" required
                    class="w-full px-4 py-2 border rounded-lg text-sm focus:outline-none focus:ring focus:border-[#0c372a]">
            </div>

            <!-- Description -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea name="description" rows="3"
                    class="w-full px-4 py-2 border rounded-lg text-sm focus:outline-none focus:ring focus:border-[#0c372a]"></textarea>
            </div>

            <!-- File Upload -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Upload File (PDF, DOCX)</label>
                <input type="file" name="file" accept=".pdf,.doc,.docx"
                    class="w-full border px-4 py-2 rounded-lg text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-[#0c372a] file:text-white hover:file:bg-[#0a2a1a]">
            </div>

            <!-- Mandatory Fields -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Select Mandatory Fields</label>
                <div class="grid grid-cols-2 gap-3 text-sm text-gray-700">
                    <?php
                    $fields = ['Employee Name', 'Department', 'Date', 'Manager Signature', 'HR Approval'];
                    foreach ($fields as $field): ?>
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" name="mandatory_fields[]" value="<?= $field ?>" class="accent-[#0c372a]">
                            <span><?= $field ?></span>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Submit -->
            <div>
                <button type="submit"
                    class="inline-block px-6 py-2 text-sm font-semibold text-white bg-[#0c372a] rounded-lg hover:bg-[#0a2a1a]">
                    Save Template
                </button>
            </div>

        </main>
    </div>
</section>