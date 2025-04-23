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
                        <th class="px-4 py-3">Context</th>
                        <th class="px-4 py-3">Timestamp</th>
                        <th class="px-4 py-3">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php if (!empty($logs)): ?>
                        <?php foreach ($logs as $index => $log): ?>
                            <?php $details = json_decode($log['details'] ?? '{}', true); ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 font-medium text-gray-800"><?= $index + 1 ?></td>
                                <td class="px-4 py-3"><?= htmlspecialchars($log['user_name'] ?? 'Unknown') ?></td>
                                <td class="px-4 py-3"><?= htmlspecialchars($log['action'] ?? '-') ?></td>
                                <td class="px-4 py-3"><?= htmlspecialchars($log['context'] ?? '-') ?></td>
                                <td class="px-4 py-3"><?= htmlspecialchars($log['timestamp'] ?? '-') ?></td>
                                <td class="px-4 py-3">
                                    <span class="inline-block px-2 py-0.5 rounded-full text-xs 
                                        <?= match ($details['status'] ?? '') {
                                            'submitted' => 'bg-blue-100 text-blue-700',
                                            'pending'   => 'bg-yellow-100 text-yellow-700',
                                            'completed' => 'bg-green-100 text-green-700',
                                            'rejected'  => 'bg-red-100 text-red-700',
                                            default     => 'bg-gray-100 text-gray-600',
                                        } ?>">
                                        <?= htmlspecialchars($details['status'] ?? '-') ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="px-4 py-6 text-center text-gray-400">
                                No logs found.
                            </td>
                        </tr>
                    <?php endif ?>
                </tbody>
            </table>
        </div>
    </div>
</section>