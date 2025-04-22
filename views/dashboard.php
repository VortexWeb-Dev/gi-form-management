<section id="dashboard" class="mb-10">
    <div class="bg-white p-6 rounded-2xl shadow">
        <div class="mb-6">
            <h2 class="text-xl font-semibold"><?= htmlspecialchars($title ?? 'Dashboard') ?></h2>
            <p class="text-sm text-gray-500"><?= htmlspecialchars($description ?? '') ?></p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4 mb-6">
            <!-- Stats Cards -->
            <?php
            $cards = [
                ['label' => 'Pending Approvals', 'value' => '8', 'bg' => 'bg-yellow-100', 'text' => 'text-yellow-800'],
                ['label' => 'Completed Forms', 'value' => '120', 'bg' => 'bg-green-100', 'text' => 'text-green-800'],
                ['label' => 'New Submissions', 'value' => '15', 'bg' => 'bg-blue-100', 'text' => 'text-blue-800'],
                ['label' => 'Rejected Forms', 'value' => '2', 'bg' => 'bg-red-100', 'text' => 'text-red-800'],
            ];
            foreach ($cards as $card): ?>
                <div class="p-4 rounded-xl <?= $card['bg'] ?> shadow-sm">
                    <div class="text-sm text-gray-500"><?= $card['label'] ?></div>
                    <div class="text-2xl font-semibold <?= $card['text'] ?>"><?= $card['value'] ?></div>
                </div>
            <?php endforeach ?>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
            <!-- Pending Approvals -->
            <div class="col-span-2">
                <div class="border rounded-xl p-4 shadow-sm">
                    <h3 class="text-lg font-medium mb-3">Pending Approvals</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-600">
                            <thead class="bg-gray-50 border-b text-xs text-gray-500 uppercase">
                                <tr>
                                    <th class="px-4 py-3">Employee</th>
                                    <th class="px-4 py-3">Form</th>
                                    <th class="px-4 py-3">Submitted</th>
                                    <th class="px-4 py-3">Status</th>
                                    <th class="px-4 py-3 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <?php foreach (range(1, 6) as $i): ?>
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3">John Doe</td>
                                        <td class="px-4 py-3">Leave Application</td>
                                        <td class="px-4 py-3">2025-04-21</td>
                                        <td class="px-4 py-3">
                                            <span class="inline-block px-2 py-0.5 rounded-full text-xs bg-yellow-100 text-yellow-700">Pending</span>
                                        </td>
                                        <td class="px-4 py-3 text-right space-x-2">
                                            <button class="text-[#0c372a] hover:underline text-sm">Review</button>
                                            <button class="text-red-600 hover:underline text-sm">Reject</button>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="flex flex-col gap-4">
                <div class="border rounded-xl p-4 shadow-sm">
                    <h3 class="text-lg font-medium mb-3">Quick Actions</h3>
                    <ul class="space-y-2 text-sm text-[#0c372a]">
                        <li><a href="#send" class="hover:underline">➤ Send a Form</a></li>
                        <li><a href="#track" class="hover:underline">➤ Track Signatures</a></li>
                        <li><a href="#archive" class="hover:underline">➤ View Archive</a></li>
                        <li><a href="#templates" class="hover:underline">➤ Manage Templates</a></li>
                        <li><a href="#config" class="hover:underline">➤ Assign HR Roles</a></li>
                        <li><a href="#log" class="hover:underline">➤ View Audit Logs</a></li>
                    </ul>
                </div>

                <div class="border rounded-xl p-4 shadow-sm">
                    <h3 class="text-lg font-medium mb-3">Recent Notifications</h3>
                    <ul class="text-sm text-gray-600 space-y-2">
                        <li>📩 Jane submitted a WFH request</li>
                        <li>✅ Leave Form approved for Mark</li>
                        <li>📄 New template uploaded: Travel Reimbursement</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>