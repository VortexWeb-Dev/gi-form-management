<?php
// views/send.php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    require_once __DIR__ . '/../config/Database.php';
    require_once __DIR__ . '/../models/FormAssignment.php';
    require_once __DIR__ . '/../models/Notification.php';

    $database            = new Database();
    $db                  = $database->getConnection();
    $formAssignmentModel = new FormAssignment($db);
    $notificationModel   = new Notification($db);

    // Grab POST data
    $assignedBy  = (int) ($_POST['assigned_by']  ?? 0);
    $assignedTo  = (int) ($_POST['assigned_to']  ?? 0);
    $templateId  = (int) ($_POST['template_id']  ?? 0);
    $remarks     = trim($_POST['remarks']       ?? '');

    // 1) Create the assignment
    $assignmentId = $formAssignmentModel->createAssignment(
        $templateId,
        $assignedTo,
        $assignedBy,
        $remarks
    );

    if ($assignmentId) {
        // 2) Create a notification for the user
        $message = $remarks !== ''
            ? $remarks
            : 'A new form has been assigned to you.';
        $notificationModel->create(
            $assignedTo,       // notify this user
            $assignmentId,     // about this assignment
            'assigned',        // notification type
            $message           // custom message
        );
    } else {
        // You might want to surface an error here in future
        error_log("Failed to create assignment for template {$templateId}");
    }

    // 3) Redirect back to avoid resubmission
    header('Location: ../index.php?page=send');
    exit;
}
?>

<section id="send" class="mb-10">
    <div class="bg-white p-6 rounded-2xl shadow">
        <div class="mb-4">
            <h2 class="text-xl font-semibold"><?= htmlspecialchars($title ?? 'Send Forms') ?></h2>
            <p class="text-sm text-gray-500"><?= htmlspecialchars($description ?? 'Assign specific forms to individual users for completion and signature.') ?></p>
        </div>

        <form class="space-y-4" action="./views/send.php" method="POST">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Select Form</label>
                <select name="template_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring focus:border-[#0c372a]">
                    <option value="">Choose a form</option>
                    <?php foreach ($templates as $template): ?>
                        <option value="<?= htmlspecialchars($template['id']) ?>"><?= htmlspecialchars($template['title']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Select User</label>
                <select name="assigned_to" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring focus:border-[#0c372a]">
                    <option value="">Choose a user</option>
                    <?php foreach ($users as $userIdOption => $userName): ?>
                        <option value="<?= htmlspecialchars($userIdOption) ?>"><?= htmlspecialchars($userName) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Optional Message</label>
                <textarea name="remarks" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring focus:border-[#0c372a]" placeholder="Add a note or instructions..."><?= htmlspecialchars($_POST['remarks'] ?? '') ?></textarea>
            </div>

            <input type="hidden" name="assigned_by" value="<?= htmlspecialchars($userId) ?>">

            <div>
                <button type="submit" class="bg-[#0c372a] text-white text-sm px-5 py-2 rounded-lg hover:bg-[#0a2f24] transition">Send Form</button>
            </div>
        </form>
    </div>
</section>