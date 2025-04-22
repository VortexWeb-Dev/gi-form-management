<section id="submitted" class="mb-10">
    <div class="bg-white p-6 rounded-2xl shadow">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="text-xl font-semibold"><?= htmlspecialchars($title ?? 'Submitted Forms') ?></h2>
                <p class="text-sm text-gray-500"><?= htmlspecialchars($description ?? 'Track the status of your submitted forms.') ?></p>
            </div>
            <select class="border border-gray-300 rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring focus:border-[#0c372a]">
                <option value="">Filter by Status</option>
                <option>Approved</option>
                <option>Pending</option>
                <option>Rejected</option>
            </select>
        </div>

        <!-- Submitted Forms Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="bg-gray-50 border-b text-xs text-gray-500 uppercase">
                    <tr>
                        <th class="px-4 py-3">#</th>
                        <th class="px-4 py-3">Form Name</th>
                        <th class="px-4 py-3">Employee</th>
                        <th class="px-4 py-3">Submission Date</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php
                    // Example array of submitted forms. Replace this with dynamic data from your backend.
                    $submittedForms = [
                        ['form_name' => 'NDA Agreement', 'employee_name' => 'Jane Smith', 'submission_date' => '2025-04-15', 'status' => 'Approved', 'form_id' => 1],
                        ['form_name' => 'Leave Request', 'employee_name' => 'John Doe', 'submission_date' => '2025-04-10', 'status' => 'Pending', 'form_id' => 2],
                    ];

                    foreach ($submittedForms as $i => $form):
                    ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 font-medium text-gray-800"><?= $i + 1 ?></td>
                            <td class="px-4 py-3"><?= htmlspecialchars($form['form_name']) ?></td>
                            <td class="px-4 py-3"><?= htmlspecialchars($form['employee_name']) ?></td>
                            <td class="px-4 py-3"><?= htmlspecialchars($form['submission_date']) ?></td>
                            <td class="px-4 py-3">
                                <?php
                                // Display status with corresponding styles
                                if ($form['status'] == 'Approved') {
                                    echo '<span class="inline-block px-2 py-0.5 rounded-full text-xs bg-green-100 text-green-700">Approved</span>';
                                } elseif ($form['status'] == 'Pending') {
                                    echo '<span class="inline-block px-2 py-0.5 rounded-full text-xs bg-yellow-100 text-yellow-700">Pending</span>';
                                } elseif ($form['status'] == 'Rejected') {
                                    echo '<span class="inline-block px-2 py-0.5 rounded-full text-xs bg-red-100 text-red-700">Rejected</span>';
                                }
                                ?>
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