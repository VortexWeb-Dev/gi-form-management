<section id="track" class="mb-10">
    <div class="bg-white p-6 rounded-2xl shadow">
        <div class="flex items-center justify-between mb-4">
            <div class="mb-4">
                <h2 class="text-xl font-semibold"><?= htmlspecialchars($title ?? 'Track Signatures') ?></h2>
                <p class="text-sm text-gray-500"><?= htmlspecialchars($description ?? 'View which users have signed or are pending.') ?></p>
            </div>
            <select id="statusFilter" class="border border-gray-300 rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring focus:border-[#0c372a]">
                <option value="">Filter by Status</option>
                <option value="signed">Signed</option>
                <option value="not_signed">Not Signed</option>
            </select>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left border border-gray-200 rounded-lg overflow-hidden">
                <thead class="bg-gray-50 text-gray-700">
                    <tr>
                        <th class="px-4 py-2">Form</th>
                        <th class="px-4 py-2">Assigned To</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Sent</th>
                        <th class="px-4 py-2">Signed</th>
                    </tr>
                </thead>
                <tbody class="divide-y" id="formTableBody">
                    <?php foreach ($assignments as $assignment): ?>
                        <tr class="hover:bg-gray-50" data-status="<?= isset($assignment['signature']) && isset($assignment['signature']['signed_at']) ? 'signed' : 'not_signed' ?>">
                            <td class="px-4 py-2"><?= htmlspecialchars($assignment['template_name']) ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars($assignment['assigned_to']) ?></td>
                            <td class="px-4 py-2">
                                <?php
                                $isSigned = isset($assignment['signature']) && isset($assignment['signature']['signed_at']);
                                $statusLabel = $isSigned ? 'Signed' : 'Not Signed';
                                $statusClass = $isSigned
                                    ? 'bg-green-100 text-green-700'
                                    : 'bg-yellow-100 text-yellow-800';

                                echo "<span class='inline-block {$statusClass} px-2 py-1 rounded-full text-xs'>{$statusLabel}</span>";
                                ?>
                            </td>
                            <td class="px-4 py-2"><?= htmlspecialchars($assignment['assigned_at']) ?></td>
                            <td class="px-4 py-2">
                                <?= isset($assignment['signature']['signed_at']) ? htmlspecialchars($assignment['signature']['signed_at']) : '—' ?>
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