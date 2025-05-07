<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once __DIR__ . '/../config/Database.php';
    require_once __DIR__ . '/../models/FormResponse.php';
    require_once __DIR__ . '/../models/FormAssignment.php';
    require_once __DIR__ . '/../models/Notification.php';

    $db                = (new Database())->getConnection();
    $assignmentModel   = new FormAssignment($db);
    $responseModel     = new FormResponse($db);
    $notificationModel = new Notification($db);

    $templateId = (int) ($_POST['form_id'] ?? 0);
    $userId     = $this->user['ID'];
    $hrId       = 1938;  // or derive dynamically if you have that logic
    $remarks    = 'Submitted by user without HR assignment';

    // — STEP 1 (already): create the assignment and get its new ID —
    $assignmentId = $assignmentModel->createAssignment($templateId, $userId, $hrId, "submitted", $remarks);
    if (!$assignmentId) {
        throw new Exception("Failed to create assignment.");
    }

    // — STEP 2: save each field response —
    foreach ($_POST as $key => $value) {
        // match only keys like "field_{order}_{fieldId}_{idx}"
        if (preg_match('/^field_\d+_(\d+)_\d+$/', $key, $m)) {
            $fieldId = (int)$m[1];
            // skip empty (optional) fields
            if ($value === '') {
                continue;
            }
            $ok = $responseModel->create($assignmentId, $fieldId, $value);
            if (!$ok) {
                throw new Exception("Failed to save response for field {$fieldId}.");
            }
        }
    }

    // — STEP 3: notify HR of the new submission —
    $notificationModel->create(
        $hrId,
        $assignmentId,
        'submitted',
        $remarks
    );
}
?>
<section id="fill" class="mb-10">
    <div class="bg-white p-6 rounded-2xl shadow">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="text-xl font-semibold"><?= htmlspecialchars($title ?? 'Fill and Sign') ?></h2>
                <p class="text-sm text-gray-500"><?= htmlspecialchars($description ?? 'Complete the required fields and apply your digital signature for pending forms.') ?></p>
            </div>
        </div>

        <div class="space-y-6">
            <?php if (empty($templates)): ?>
                <p class="text-gray-500 text-center py-4">No pending forms available.</p>
            <?php else: ?>
                <?php foreach ($templates as $form): ?>
                    <div class="bg-gray-50 rounded-lg shadow-sm overflow-hidden border">
                        <button
                            type="button"
                            class="w-full flex justify-between items-center px-4 py-3 text-left bg-white hover:bg-gray-100 transition"
                            onclick="toggleAccordion(this)">
                            <div>
                                <h3 class="text-lg font-semibold"><?= htmlspecialchars($form['title']) ?></h3>
                                <p class="text-sm text-gray-600"><?= htmlspecialchars($form['description']) ?></p>
                            </div>
                            <svg class="w-5 h-5 text-gray-500 transition-transform transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div class="accordion-content hidden px-4 pb-4">
                            <form
                                action="?page=fill&action=submit"
                                method="POST"
                                class="space-y-4 mt-4"
                                enctype="multipart/form-data">
                                <input type="hidden" name="form_id" value="<?= htmlspecialchars($form['id']) ?>">

                                <?php
                                // Sort fields by order
                                usort($form['fields'], fn($a, $b) => ($a['field_order'] ?? 0) <=> ($b['field_order'] ?? 0));

                                // Group fields by order if needed
                                $fieldGroups = [];
                                foreach ($form['fields'] as $field) {
                                    $order = $field['field_order'] ?? 0;
                                    $fieldGroups[$order][] = $field;
                                }
                                ?>

                                <?php foreach ($fieldGroups as $order => $fields): ?>
                                    <div class="grid grid-cols-<?= count($fields) ?> gap-6">
                                        <?php foreach ($fields as $idx => $field): ?>
                                            <?php
                                            // Safely grab the field's unique ID (fall back to 'field_id' or the loop index).
                                            $fieldId = $field['id']
                                                ?? $field['field_id']
                                                ?? $idx;
                                            // If even that fails, skip this field entirely.
                                            if ($fieldId === null) {
                                                continue;
                                            }

                                            $inputName   = sprintf('field_%d_%d_%d', $order, $fieldId, $idx);
                                            $requiredAttr = !empty($field['is_required']) ? 'required' : '';
                                            $asterisk     = !empty($field['is_required'])
                                                ? '<span class="text-red-500">*</span>'
                                                : '';
                                            $fullWidth    = ($field['type'] === 'textarea' || count($fields) === 1)
                                                ? 'col-span-' . count($fields)
                                                : '';
                                            ?>
                                            <div class="<?= $fullWidth ?>">
                                                <label for="<?= $inputName ?>" class="block text-sm font-medium text-gray-700 mb-1">
                                                    <?= htmlspecialchars($field['label'] ?? 'Field') ?> <?= $asterisk ?>
                                                </label>

                                                <?php if (in_array($field['type'] ?? '', ['text', 'number', 'currency', 'percentage'], true)): ?>
                                                    <input
                                                        id="<?= $inputName ?>"
                                                        type="<?= in_array($field['type'], ['currency', 'percentage']) ? 'number' : htmlspecialchars($field['type']) ?>"
                                                        name="<?= $inputName ?>"
                                                        placeholder="<?= htmlspecialchars($field['placeholder'] ?? "Please enter {$field['label']}") ?>"
                                                        <?= $requiredAttr ?>
                                                        class="w-full px-4 py-2 border rounded-lg text-sm focus:outline-none focus:ring focus:border-[#0c372a]"
                                                        <?php if (($field['type'] ?? '') === 'currency'): ?>
                                                        step="0.01" min="0" data-type="currency"
                                                        <?php elseif (($field['type'] ?? '') === 'percentage'): ?>
                                                        step="0.01" min="0" max="100" data-type="percentage"
                                                        <?php endif; ?>>

                                                <?php elseif (($field['type'] ?? '') === 'date'): ?>
                                                    <input
                                                        id="<?= $inputName ?>"
                                                        type="date"
                                                        name="<?= $inputName ?>"
                                                        <?= $requiredAttr ?>
                                                        class="w-full px-4 py-2 border rounded-lg text-sm focus:outline-none focus:ring focus:border-[#0c372a]">

                                                <?php elseif (($field['type'] ?? '') === 'textarea'): ?>
                                                    <textarea
                                                        id="<?= $inputName ?>"
                                                        name="<?= $inputName ?>"
                                                        placeholder="<?= htmlspecialchars($field['placeholder'] ?? '') ?>"
                                                        <?= $requiredAttr ?>
                                                        rows="3"
                                                        class="w-full px-4 py-2 border rounded-lg text-sm focus:outline-none focus:ring focus:border-[#0c372a]"></textarea>

                                                <?php elseif (($field['type'] ?? '') === 'checkbox'): ?>
                                                    <div class="flex items-center">
                                                        <input
                                                            id="<?= $inputName ?>"
                                                            type="checkbox"
                                                            name="<?= $inputName ?>"
                                                            <?= $requiredAttr ?>
                                                            class="h-4 w-4 text-[#0c372a] focus:ring-[#0c372a] border-gray-300 rounded">
                                                        <label for="<?= $inputName ?>" class="ml-2 block text-sm text-gray-600">
                                                            <?= htmlspecialchars($field['placeholder'] ?? $field['label'] ?? 'Option') ?>
                                                        </label>
                                                    </div>

                                                <?php elseif (($field['type'] ?? '') === 'file'): ?>
                                                    <input
                                                        id="<?= $inputName ?>"
                                                        type="file"
                                                        name="<?= $inputName ?>"
                                                        <?= $requiredAttr ?>
                                                        class="w-full px-4 py-2 border rounded-lg text-sm focus:outline-none focus:ring focus:border-[#0c372a]">
                                                <?php endif; ?>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endforeach; ?>

                                <div class="flex justify-end mt-6">
                                    <button
                                        type="submit"
                                        name="action"
                                        value="sign"
                                        class="inline-block px-6 py-2 text-sm font-semibold text-white bg-[#0c372a] rounded-lg hover:bg-[#0a2a1a]">
                                        Sign and Submit
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Accordion toggle script -->
    <script>
        function toggleAccordion(btn) {
            const content = btn.nextElementSibling;
            const icon = btn.querySelector('svg');
            content.classList.toggle('hidden');
            icon.classList.toggle('rotate-180');
        }
    </script>
</section>