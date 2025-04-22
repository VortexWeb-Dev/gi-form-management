<section id="log" class="mb-10">
    <div class="bg-white p-6 rounded-2xl shadow">
        <div class="mb-4">
            <h2 class="text-xl font-semibold"><?= htmlspecialchars($title ?? 'Audit Log') ?></h2>
            <p class="text-sm text-gray-500"><?= htmlspecialchars($description ?? 'Maintain logs for every action taken.') ?></p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="bg-gray-50 border-b text-xs text-gray-500 uppercase">
                    <tr>
                        <th class="px-4 py-3">#</th>
                        <th class="px-4 py-3">User</th>
                        <th class="px-4 py-3">Action</th>
                        <th class="px-4 py-3">Form</th>
                        <th class="px-4 py-3">Timestamp</th>
                        <th class="px-4 py-3">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php foreach (range(1, 6) as $i): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 font-medium text-gray-800"><?= $i ?></td>
                            <td class="px-4 py-3">Jane Smith</td>
                            <td class="px-4 py-3">Signed</td>
                            <td class="px-4 py-3">Employee NDA</td>
                            <td class="px-4 py-3">2025-04-22 09:45</td>
                            <td class="px-4 py-3">
                                <span class="inline-block px-2 py-0.5 rounded-full text-xs bg-green-100 text-green-700">Completed</span>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</section>