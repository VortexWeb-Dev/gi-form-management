<section id="templates" class="mb-10">
    <div class="bg-white p-6 rounded-2xl shadow">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="text-xl font-semibold"><?= htmlspecialchars($title ?? 'Templates') ?></h2>
                <p class="text-sm text-gray-500"><?= htmlspecialchars($description ?? 'Upload or create new form templates for reuse.') ?></p>
            </div>
            <div>
                <a href="?page=addtemplate" class="inline-block px-4 py-2 text-sm font-semibold text-white bg-[#0c372a] rounded-lg shadow-md hover:bg-[#0a2a1a] focus:outline-none">
                    Add New Template
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="bg-gray-50 border-b text-xs text-gray-500 uppercase">
                    <tr>
                        <th class="px-4 py-3">#</th>
                        <th class="px-4 py-3">Template Name</th>
                        <th class="px-4 py-3">Created By</th>
                        <th class="px-4 py-3">Created On</th>
                        <th class="px-4 py-3">Category</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php foreach (range(1, 5) as $i): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 font-medium text-gray-800"><?= $i ?></td>
                            <td class="px-4 py-3">NDA Agreement</td>
                            <td class="px-4 py-3">HR Team</td>
                            <td class="px-4 py-3">2025-04-15</td>
                            <td class="px-4 py-3">HR</td>
                            <td class="px-4 py-3 text-right space-x-2">
                                <button class="text-[#0c372a] hover:underline text-sm">Edit</button>
                                <button class="text-blue-600 hover:underline text-sm">Download</button>
                                <button class="text-red-600 hover:underline text-sm">Delete</button>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</section>