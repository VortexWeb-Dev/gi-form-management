<section id="archive" class="mb-10">
    <div class="bg-white p-6 rounded-2xl shadow">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="text-xl font-semibold"><?= htmlspecialchars($title ?? 'Archive') ?></h2>
                <p class="text-sm text-gray-500"><?= htmlspecialchars($description ?? 'Access and manage all completed and signed forms.') ?></p>
            </div>
            <select class="border border-gray-300 rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring focus:border-[#0c372a]">
                <option value="">Filter by User Profile</option>
                <option>HR Department</option>
                <option>Admin</option>
                <option>Finance</option>
                <option>Sales</option>
            </select>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="bg-gray-50 border-b text-xs text-gray-500 uppercase">
                    <tr>
                        <th class="px-4 py-3">#</th>
                        <th class="px-4 py-3">Employee</th>
                        <th class="px-4 py-3">Form Name</th>
                        <th class="px-4 py-3">Signed Date</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php foreach (range(1, 5) as $i): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 font-medium text-gray-800"><?= $i ?></td>
                            <td class="px-4 py-3">Jane Smith</td>
                            <td class="px-4 py-3">NDA Agreement</td>
                            <td class="px-4 py-3">2025-04-15</td>
                            <td class="px-4 py-3">
                                <span class="inline-block px-2 py-0.5 rounded-full text-xs bg-green-100 text-green-700">Signed</span>
                            </td>
                            <td class="px-4 py-3 text-right space-x-2">
                                <button class="text-[#0c372a] hover:underline text-sm">View</button>
                                <button class="text-blue-600 hover:underline text-sm">Download</button>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</section>