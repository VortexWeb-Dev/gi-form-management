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
                        <th class="px-4 py-3">Is Active</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php foreach ($templates as $index => $template): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 font-medium text-gray-800"><?= $index + 1 ?></td>
                            <td class="px-4 py-3"><?= htmlspecialchars($template['title']) ?></td>
                            <td class="px-4 py-3">
                                <?= htmlspecialchars($template['created_by'] ?? 'Unknown') ?>
                            </td>
                            <td class="px-4 py-3">
                                <?= date('Y-m-d', strtotime($template['created_at'])) ?>
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-2 py-1 text-xs font-medium text-green-800 bg-green-100 rounded-full">
                                    <?= $template['is_active'] ? 'Yes' : 'No' ?>
                                </span>
                            </td>
                            <td class="px-4 py-3 text-right space-x-2">
                                <a href="?page=edittemplate&id=<?= $template['id'] ?>" class="text-[#0c372a] hover:underline text-sm">Edit</a>
                                <?php if (!empty($template['file_path'])): ?>
                                    <a href="<?= htmlspecialchars($template['file_path']) ?>" class="text-blue-600 hover:underline text-sm" download>Download</a>
                                <?php endif; ?>
                                <a href="?page=deletetemplate&id=<?= $template['id'] ?>" class="text-red-600 hover:underline text-sm">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>