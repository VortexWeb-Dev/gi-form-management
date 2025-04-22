<section id="inbox" class="mb-10">
    <div class="bg-white p-6 rounded-2xl shadow">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="text-xl font-semibold"><?= htmlspecialchars($title ?? 'Inbox') ?></h2>
                <p class="text-sm text-gray-500"><?= htmlspecialchars($description ?? 'View all submitted forms pending HR approval.') ?></p>
            </div>
            <input type="text" placeholder="Search..." class="border border-gray-300 rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring focus:border-[#0c372a]">
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="bg-gray-50 border-b text-xs text-gray-500 uppercase">
                    <tr>
                        <th class="px-4 py-3">#</th>
                        <th class="px-4 py-3">Employee</th>
                        <th class="px-4 py-3">Form</th>
                        <th class="px-4 py-3">Date Submitted</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php foreach (range(1, 5) as $i): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 font-medium text-gray-800"><?= $i ?></td>
                            <td class="px-4 py-3">John Doe</td>
                            <td class="px-4 py-3">Leave Request</td>
                            <td class="px-4 py-3">2025-04-20</td>
                            <td class="px-4 py-3">
                                <span class="inline-block px-2 py-0.5 rounded-full text-xs bg-yellow-100 text-yellow-700">Pending</span>
                            </td>
                            <td class="px-4 py-3 text-right space-x-2">
                                <button class="text-[#0c372a] hover:underline text-sm">View</button>
                                <button class="text-green-600 hover:underline text-sm">Approve</button>
                                <button class="text-red-500 hover:underline text-sm">Reject</button>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</section>