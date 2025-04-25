<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    require_once __DIR__ . '/../config/Database.php';
    require_once __DIR__ . '/../models/Notification.php';

    $database = new Database();
    $db = $database->getConnection();
    $notificationModel = new Notification($db);

    $userId = $_POST['user_id'] ?? null;
    echo $notificationModel->markAllAsRead($userId);
    header('Location: ../index.php?page=notifications');
}

?>

<section id="notifications" class="mb-10">
    <div class="bg-white p-6 rounded-2xl shadow">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="text-xl font-semibold"><?= htmlspecialchars($title ?? 'Notifications') ?></h2>
                <p class="text-sm text-gray-500"><?= htmlspecialchars($description ?? 'Receive alerts when forms are submitted or signed.') ?></p>
            </div>
            <form action="./views/notifications.php" method="POST">
                <input type="hidden" name="user_id" value="<?= htmlspecialchars($this->user['ID']) ?>">
                <button type="submit" class="inline-block px-4 py-2 text-sm font-semibold text-white bg-[#0c372a] rounded-lg shadow-md hover:bg-[#0a2a1a] focus:outline-none">
                    Mark All as Read
                </button>
            </form>
        </div>

        <div class="overflow-x-auto">
            <ul class="space-y-4">
                <?php if (!empty($notifications)): ?>
                    <?php foreach ($notifications as $notif): ?>
                        <?php
                        // Set different background based on read status
                        $bgClass = $notif['is_read'] ? 'bg-gray-50 hover:bg-gray-100' : 'bg-green-50 hover:bg-green-100';
                        ?>
                        <li class="flex justify-between items-center py-3 px-4 rounded-lg shadow-sm <?= $bgClass ?>">
                            <div>
                                <p class="font-medium text-gray-800">
                                    <?= htmlspecialchars($notif['type']) ?> - Assignment #<?= $notif['assignment_id'] ?>
                                </p>
                                <p class="text-sm text-gray-500"><?= htmlspecialchars($notif['message']) ?></p>
                                <p class="text-sm text-gray-500 mt-2"><?= htmlspecialchars($notif['created_at']) ?></p>
                            </div>
                        </li>
                    <?php endforeach ?>
                <?php else: ?>
                    <li class="text-gray-500 text-sm">No notifications found.</li>
                <?php endif ?>
            </ul>
        </div>
    </div>
</section>