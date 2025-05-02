<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once __DIR__ . '/../config/Database.php';
    require_once __DIR__ . '/../models/FormResponse.php';
    require_once __DIR__ . '/../models/FormAssignment.php';
    require_once __DIR__ . '/../models/Notification.php';

    $database = new Database();
    $db = $database->getConnection();

    $assignmentModel = new FormAssignment($db);
    $responseModel = new FormResponse($db);
    $notificationModel = new Notification($db);

    $formId = $_POST['form_id'] ?? null;

    // Add to form_assignments (template_id: form_id, status: submitted, assigned_to: user_id, assigned_by: hr_id, assigned_at: now, submitted_at: now, remarks: Submitted by user without HR assignment)
    $assignmentModel->createAssignment($formId, $this->user['ID'], 1938, 'Submitted by user without HR assignment');
    // Add to form_responses (assignment_id: form_assignment_id, field_id: field_id, response_value: field_value)
    
    // Add to notifications for HR (user_id: hr_id, assignment_id: form_assignment_id, type: submitted, message: Submitted by user without HR assignment, created_at: now)
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

        <!-- Pending Forms Section -->
        <div class="space-y-6">
            <?php
            if (empty($templates)) {
                echo '<p class="text-gray-500 text-center py-4">No pending forms available.</p>';
            } else {
                foreach ($templates as $form):
            ?>
                    <div class="bg-gray-50 rounded-lg shadow-sm overflow-hidden border">
                        <button type="button"
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
                            <form action="./views/fill.php" method="POST" class="space-y-4 mt-4">
                                <input type="hidden" name="form_id" value="<?= $form['id'] ?>">

                                <?php
                                // Sort and group fields
                                usort($form['fields'], fn($a, $b) => $a['field_order'] - $b['field_order']);
                                $fieldGroups = [];
                                foreach ($form['fields'] as $field) {
                                    $fieldGroups[$field['field_order']][] = $field;
                                }

                                // Check if first group has usable fields
                                $firstGroup = reset($fieldGroups);
                                $hasFields = false;
                                foreach ($firstGroup as $field) {
                                    if (!empty($field['label']) || !empty($field['type'])) {
                                        $hasFields = true;
                                        break;
                                    }
                                }

                                // Render field groups
                                foreach ($fieldGroups as $order => $fields):
                                ?>
                                    <div class="grid grid-cols-<?= count($fields) ?> gap-6">
                                        <?php if (empty($fields)): ?>
                                            <div class="col-span-1">
                                                <p class="text-gray-500">No fields available.</p>
                                            </div>
                                        <?php endif; ?>

                                        <?php foreach ($fields as $field):
                                            if (empty($field['label']) && empty($field['type'])) {
                                                echo '<p class="text-red-500">This form has no fields.</p>';
                                                continue;
                                            }

                                            $required = $field['is_required'] ? 'required' : '';
                                            $asterisk = $field['is_required'] ? '<span class="text-red-500">*</span>' : '';
                                            $colSpan = ($field['type'] === 'textarea' || count($fields) === 1) ? 'col-span-' . count($fields) : '';
                                        ?>
                                            <div class="<?= $colSpan ?>">
                                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                                    <?= htmlspecialchars($field['label']) ?> <?= $asterisk ?>
                                                </label>

                                                <?php if (in_array($field['type'], ['text', 'number', 'currency', 'percentage'])): ?>
                                                    <input
                                                        type="<?= in_array($field['type'], ['currency', 'percentage']) ? 'number' : $field['type'] ?>"
                                                        name="field_<?= $field['field_order'] ?>_<?= $field['id'] ?>_<?= array_search($field, $fields) ?>"
                                                        placeholder="<?= htmlspecialchars($field['placeholder'] ?? "Please enter {$field['label']}") ?>"
                                                        <?= $required ?>
                                                        class="w-full px-4 py-2 border rounded-lg text-sm focus:outline-none focus:ring focus:border-[#0c372a]"
                                                        <?php if ($field['type'] === 'currency'): ?>
                                                        step="0.01" min="0" data-type="currency"
                                                        <?php elseif ($field['type'] === 'percentage'): ?>
                                                        step="0.01" min="0" max="100" data-type="percentage"
                                                        <?php endif; ?>>
                                                <?php elseif ($field['type'] === 'date'): ?>
                                                    <input
                                                        type="date"
                                                        name="field_<?= $field['field_order'] ?>_<?= $field['id'] ?>_<?= array_search($field, $fields) ?>"
                                                        <?= $required ?>
                                                        class="w-full px-4 py-2 border rounded-lg text-sm focus:outline-none focus:ring focus:border-[#0c372a]">
                                                <?php elseif ($field['type'] === 'textarea'): ?>
                                                    <textarea
                                                        name="field_<?= $field['field_order'] ?>_<?= $field['id'] ?>_<?= array_search($field, $fields) ?>"
                                                        placeholder="<?= htmlspecialchars($field['placeholder']) ?>"
                                                        <?= $required ?>
                                                        rows="3"
                                                        class="w-full px-4 py-2 border rounded-lg text-sm focus:outline-none focus:ring focus:border-[#0c372a]"></textarea>
                                                <?php elseif ($field['type'] === 'checkbox'): ?>
                                                    <div class="flex items-center">
                                                        <input
                                                            type="checkbox"
                                                            id="field_<?= $field['field_order'] ?>_<?= $field['id'] ?>_<?= array_search($field, $fields) ?>"
                                                            name="field_<?= $field['field_order'] ?>_<?= $field['id'] ?>_<?= array_search($field, $fields) ?>"
                                                            <?= $required ?>
                                                            class="h-4 w-4 text-[#0c372a] focus:ring-[#0c372a] border-gray-300 rounded">
                                                        <label for="field_<?= $field['field_order'] ?>_<?= $field['id'] ?>_<?= array_search($field, $fields) ?>" class="ml-2 block text-sm text-gray-600">
                                                            <?= htmlspecialchars($field['placeholder']) ?>
                                                        </label>
                                                    </div>
                                                <?php elseif ($field['type'] === 'file'): ?>
                                                    <input
                                                        type="file"
                                                        name="field_<?= $field['field_order'] ?>_<?= $field['id'] ?>_<?= array_search($field, $fields) ?>"
                                                        <?= $required ?>
                                                        class="w-full px-4 py-2 border rounded-lg text-sm focus:outline-none focus:ring focus:border-[#0c372a]">
                                                <?php endif; ?>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endforeach; ?>

                                <?php if ($hasFields): ?>
                                    <div class="flex justify-between items-center mt-6">
                                        <button type="submit" name="action" value="sign" class="inline-block px-6 py-2 text-sm font-semibold text-white bg-[#0c372a] rounded-lg hover:bg-[#0a2a1a]">
                                            Sign and Submit
                                        </button>
                                    </div>
                                <?php endif; ?>
                            </form>
                        </div>
                    </div>
            <?php
                endforeach;
            }
            ?>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        function toggleAccordion(button) {
            const content = button.nextElementSibling;
            const icon = button.querySelector('svg');
            content.classList.toggle('hidden');
            icon.classList.toggle('rotate-180');
        }
    </script>
</section>