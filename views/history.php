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
                        <th class="px-4 py-3">Assigned To</th>
                        <th class="px-4 py-3">Assigned By</th>
                        <th class="px-4 py-3">Assigned Date</th>
                        <th class="px-4 py-3">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php foreach ($assignments as $index => $assignment): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 font-medium text-gray-800"><?= $index + 1 ?></td>
                            <td class="px-4 py-3"><?= htmlspecialchars($assignment['template_name'] ?? 'N/A') ?></td>
                            <td class="px-4 py-3"><?= htmlspecialchars($assignment['assigned_to'] ?? 'N/A') ?></td>
                            <td class="px-4 py-3"><?= htmlspecialchars($assignment['assigned_by'] ?? 'N/A') ?></td>
                            <td class="px-4 py-3">
                                <?= $assignment['assigned_at'] ? $assignment['assigned_at'] : '—' ?>
                            </td>
                            <td class="px-4 py-3">
                                <?php
                                $status = strtolower($assignment['status']);
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