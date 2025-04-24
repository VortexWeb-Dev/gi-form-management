<section id="alerts" class="mb-10">
    <div class="bg-white p-6 rounded-2xl shadow">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="text-xl font-semibold"><?= htmlspecialchars($title ?? 'Alerts') ?></h2>
                <p class="text-sm text-gray-500"><?= htmlspecialchars($description ?? 'Stay updated on assigned forms and pending submissions.') ?></p>
            </div>
            <button class="inline-block px-4 py-2 text-sm font-semibold text-white bg-[#0c372a] rounded-lg shadow-md hover:bg-[#0a2a1a] focus:outline-none">
                Mark All as Read
            </button>
        </div>

        <div class="overflow-x-auto">
            <ul class="space-y-4">
                <?php if (!empty($notifications)): ?>
                    <?php foreach ($notifications as $notif): ?>
                        <?php
                        // Set different background based on read status
                        $bgClass = $notif['is_read'] ? 'bg-green-50 hover:bg-green-100' : 'bg-gray-50 hover:bg-gray-100';
                        ?>
                        <li class="flex justify-between items-center py-3 px-4 rounded-lg shadow-sm <?= $bgClass ?>">
                            <div>
                                <p class="font-medium text-gray-800">
                                    <?= htmlspecialchars($notif['type']) ?> - Assignment #<?= $notif['assignment_id'] ?>
                                </p>
                                <p class="text-sm text-gray-500"><?= htmlspecialchars($notif['message']) ?></p>
                                <p class="text-sm text-gray-500 mt-2"><?= htmlspecialchars($notif['created_at']) ?></p>
                            </div>
                            <!-- Uncomment this block if you want actions like view or dismiss -->
                            <!--
                <div class="space-x-2">
                    <button class="text-[#0c372a] hover:underline text-sm">View</button>
                    <button class="text-gray-600 hover:underline text-sm">Dismiss</button>
                </div>
                -->
                        </li>
                    <?php endforeach ?>
                <?php else: ?>
                    <li class="text-gray-500 text-sm">No notifications found.</li>
                <?php endif ?>
            </ul>
        </div>
    </div>
</section>