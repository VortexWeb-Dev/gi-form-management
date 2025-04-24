<section id="submitted" class="mb-10">
    <div class="bg-white p-6 rounded-2xl shadow">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="text-xl font-semibold"><?= htmlspecialchars($title ?? 'Submitted Forms') ?></h2>
                <p class="text-sm text-gray-500"><?= htmlspecialchars($description ?? 'Track the status of your submitted forms.') ?></p>
            </div>
            <select id="statusFilter" class="border border-gray-300 rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring focus:border-[#0c372a]">
                <option value="">Filter by Status</option>
                <option value="approved">Approved</option>
                <option value="pending">Pending</option>
                <option value="submitted">Submitted</option>
                <option value="rejected">Rejected</option>
            </select>
        </div>

        <!-- Submitted Forms Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="bg-gray-50 border-b text-xs text-gray-500 uppercase">
                    <tr>
                        <th class="px-4 py-3">#</th>
                        <th class="px-4 py-3">Form Name</th>
                        <th class="px-4 py-3">Assigned To</th>
                        <th class="px-4 py-3">Assigned By</th>
                        <th class="px-4 py-3">Submission Date</th>
                        <th class="px-4 py-3">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100" id="formTableBody">
                    <?php foreach ($assignments as $index => $assignment): ?>
                        <?php $status = strtolower($assignment['status']); ?>
                        <tr class="hover:bg-gray-50" data-status="<?= $status ?>">
                            <td class="px-4 py-3 font-medium text-gray-800"><?= $index + 1 ?></td>
                            <td class="px-4 py-3"><?= htmlspecialchars($assignment['template_name'] ?? 'N/A') ?></td>
                            <td class="px-4 py-3"><?= htmlspecialchars($assignment['assigned_to'] ?? 'N/A') ?></td>
                            <td class="px-4 py-3"><?= htmlspecialchars($assignment['assigned_by'] ?? 'N/A') ?></td>
                            <td class="px-4 py-3">
                                <?= $assignment['submitted_at'] ? $assignment['submitted_at'] : '—' ?>
                            </td>
                            <td class="px-4 py-3">
                                <?php
                                $statusColors = [
                                    'pending' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-700'],
                                    'submitted' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-700'],
                                    'approved' => ['bg' => 'bg-green-100', 'text' => 'text-green-700'],
                                    'rejected' => ['bg' => 'bg-red-100', 'text' => 'text-red-700'],
                                ];
                                $color = $statusColors[$status] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-700'];
                                ?>
                                <span class="inline-block px-2 py-0.5 rounded-full text-xs <?= $color['bg'] ?> <?= $color['text'] ?>">
                                    <?= ucfirst($status) ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- JavaScript to handle status filtering -->
<script>
    document.getElementById('statusFilter').addEventListener('change', function() {
        const selectedStatus = this.value;
        const rows = document.querySelectorAll('#formTableBody tr');

        rows.forEach(row => {
            const rowStatus = row.getAttribute('data-status');
            if (!selectedStatus || rowStatus === selectedStatus.toLowerCase()) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>