<section id="history" class="mb-10">
    <div class="bg-white p-6 rounded-2xl shadow">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="text-xl font-semibold"><?= htmlspecialchars($title ?? 'History') ?></h2>
                <p class="text-sm text-gray-500"><?= htmlspecialchars($description ?? 'Access previously completed and signed forms for your profile.') ?></p>
            </div>
        </div>

        <!-- History Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="bg-gray-50 border-b text-xs text-gray-500 uppercase">
                    <tr>
                        <th class="px-4 py-3">#</th>
                        <th class="px-4 py-3">Form Name</th>
                        <th class="px-4 py-3">Employee</th>
                        <th class="px-4 py-3">Completion Date</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php
                    // Example array of completed forms. Replace this with dynamic data from your backend.
                    $completedForms = [
                        ['form_name' => 'NDA Agreement', 'employee_name' => 'Jane Smith', 'completion_date' => '2025-04-15', 'status' => 'Completed', 'form_id' => 1],
                        ['form_name' => 'Leave Request', 'employee_name' => 'John Doe', 'completion_date' => '2025-04-10', 'status' => 'Completed', 'form_id' => 2],
                    ];

                    foreach ($completedForms as $i => $form):
                    ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 font-medium text-gray-800"><?= $i + 1 ?></td>
                            <td class="px-4 py-3"><?= htmlspecialchars($form['form_name']) ?></td>
                            <td class="px-4 py-3"><?= htmlspecialchars($form['employee_name']) ?></td>
                            <td class="px-4 py-3"><?= htmlspecialchars($form['completion_date']) ?></td>
                            <td class="px-4 py-3">
                                <span class="inline-block px-2 py-0.5 rounded-full text-xs bg-green-100 text-green-700">Completed</span>
                            </td>
                            <td class="px-4 py-3 text-right space-x-2">
                                <button class="text-[#0c372a] hover:underline text-sm">View</button>
                                <button class="text-blue-600 hover:underline text-sm">Download</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>