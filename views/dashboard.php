<section id="dashboard" class="mb-10">
    <div class="bg-white p-6 rounded-2xl shadow">
        <div class="mb-6">
            <h2 class="text-xl font-semibold"><?= htmlspecialchars($title ?? 'Dashboard') ?></h2>
            <p class="text-sm text-gray-500"><?= htmlspecialchars($description ?? '') ?></p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4 mb-6">
            <!-- Stats Cards -->
            <?php
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
                                    <th class="px-4 py-3">Remarks</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <?php if (empty($pendingAssignments)): ?>
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-gray-500">No pending approvals</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($pendingAssignments as $assignment): ?>
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-3"><?= htmlspecialchars($assignment['assigned_to'] ?? '') ?></td>
                                            <td class="px-4 py-3"><?= htmlspecialchars($assignment['assigned_by'] ?? '') ?></td>
                                            <td class="px-4 py-3"><?= htmlspecialchars($assignment['template_name'] ?? '') ?></td>
                                            <!-- <td class="px-4 py-3">
                                            <?= $assignment['submitted_at'] ? $assignment['submitted_at'] : '—' ?>
                                        </td> -->
                                            <td class="px-4 py-3">
                                                <?php
                                                $status = $assignment['status'] ? strtolower($assignment['status']) : 'unknown';
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
                                            <td class="px-4 py-3"><?= htmlspecialchars($assignment['template_name'] ?? '') ?></td>
                                        </tr>
                                    <?php endforeach ?>
                                <?php endif ?>
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
                        <?php foreach ($quickLinks as $link): ?>
                            <li>
                                <a href="<?= htmlspecialchars($link['link']) ?>" class="hover:underline">
                                    ➤ <?= htmlspecialchars($link['label']) ?>
                                </a>
                            </li>
                        <?php endforeach ?>
                    </ul>
                </div>

                <div class="border rounded-xl p-4 shadow-sm">
                    <h3 class="text-lg font-medium mb-3">Recent Notifications</h3>
                    <ul class="text-sm text-gray-600 space-y-2">
                        <?php foreach ($notifications as $notif): ?>
                            <li class="flex items-center justify-between p-2 border-b last:border-b-0">
                                <span class="flex-grow text-xs"><?= htmlspecialchars($notif['message']) ?></span>
                                <span class="text-xs text-gray-400"><?= htmlspecialchars($notif['created_at']) ?></span>
                            </li>
                        <?php endforeach ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>