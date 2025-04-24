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
                    <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                        <h3 class="text-lg font-semibold"><?= htmlspecialchars($form['title']) ?></h3>
                        <p class="text-sm text-gray-600"><?= htmlspecialchars($form['description']) ?></p>
                        <form action="submit_form.php" method="POST" class="space-y-4 mt-4">
                            <input type="hidden" name="form_id" value="<?= $form['id'] ?>">

                            <!-- Dynamic Form Fields -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <?php
                                // Sort fields by field_order
                                usort($form['fields'], function ($a, $b) {
                                    return $a['field_order'] - $b['field_order'];
                                });

                                foreach ($form['fields'] as $field):
                                    $required = $field['is_required'] ? 'required' : '';
                                    $asterisk = $field['is_required'] ? '<span class="text-red-500">*</span>' : '';
                                ?>
                                    <div class="<?= $field['type'] === 'textarea' ? 'sm:col-span-2' : '' ?>">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                            <?= htmlspecialchars($field['label']) ?> <?= $asterisk ?>
                                        </label>

                                        <?php if ($field['type'] === 'text' || $field['type'] === 'number' || $field['type'] === 'currency' || $field['type'] === 'percentage'): ?>
                                            <input
                                                type="<?= $field['type'] === 'currency' || $field['type'] === 'percentage' ? 'number' : $field['type'] ?>"
                                                name="field_<?= $field['field_order'] ?>"
                                                placeholder="<?= htmlspecialchars($field['placeholder']) ?>"
                                                <?= $required ?>
                                                class="w-full px-4 py-2 border rounded-lg text-sm focus:outline-none focus:ring focus:border-[#0c372a]"
                                                <?php if ($field['type'] === 'currency'): ?>
                                                step="0.01"
                                                min="0"
                                                data-type="currency"
                                                <?php elseif ($field['type'] === 'percentage'): ?>
                                                step="0.01"
                                                min="0"
                                                max="100"
                                                data-type="percentage"
                                                <?php endif; ?>>

                                        <?php elseif ($field['type'] === 'date'): ?>
                                            <input
                                                type="date"
                                                name="field_<?= $field['field_order'] ?>"
                                                <?= $required ?>
                                                class="w-full px-4 py-2 border rounded-lg text-sm focus:outline-none focus:ring focus:border-[#0c372a]">

                                        <?php elseif ($field['type'] === 'textarea'): ?>
                                            <textarea
                                                name="field_<?= $field['field_order'] ?>"
                                                placeholder="<?= htmlspecialchars($field['placeholder']) ?>"
                                                <?= $required ?>
                                                rows="3"
                                                class="w-full px-4 py-2 border rounded-lg text-sm focus:outline-none focus:ring focus:border-[#0c372a]"></textarea>

                                        <?php elseif ($field['type'] === 'checkbox'): ?>
                                            <div class="flex items-center">
                                                <input
                                                    type="checkbox"
                                                    id="field_<?= $field['field_order'] ?>"
                                                    name="field_<?= $field['field_order'] ?>"
                                                    <?= $required ?>
                                                    class="h-4 w-4 text-[#0c372a] focus:ring-[#0c372a] border-gray-300 rounded">
                                                <label for="field_<?= $field['field_order'] ?>" class="ml-2 block text-sm text-gray-600">
                                                    <?= htmlspecialchars($field['placeholder']) ?>
                                                </label>
                                            </div>

                                        <?php elseif ($field['type'] === 'file'): ?>
                                            <input
                                                type="file"
                                                name="field_<?= $field['field_order'] ?>"
                                                <?= $required ?>
                                                class="w-full px-4 py-2 border rounded-lg text-sm focus:outline-none focus:ring focus:border-[#0c372a]">
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <!-- Signature Section -->
                            <div class="mt-6">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Your Digital Signature <span class="text-red-500">*</span></label>
                                <div class="border-2 border-gray-300 p-6 rounded-lg">
                                    <p class="text-gray-600 text-sm">Use the area below to apply your signature.</p>
                                    <canvas id="signature-pad-<?= $form['id'] ?>" class="w-full h-32 bg-gray-100 rounded-lg mt-2"></canvas>
                                    <input type="hidden" name="signature" id="signature-data-<?= $form['id'] ?>">
                                    <div class="flex justify-end mt-2">
                                        <button type="button" class="text-sm text-[#0c372a] hover:text-[#0a2a1a]" onclick="clearSignature(<?= $form['id'] ?>)">
                                            Clear Signature
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="flex justify-between items-center mt-6">
                                <a href="#" class="inline-block px-6 py-2 text-sm font-semibold text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300">
                                    Save Draft
                                </a>
                                <button type="submit" name="action" value="sign" class="inline-block px-6 py-2 text-sm font-semibold text-white bg-[#0c372a] rounded-lg hover:bg-[#0a2a1a]">
                                    Sign and Submit
                                </button>
                            </div>
                        </form>
                    </div>
            <?php
                endforeach;
            }
            ?>
        </div>
    </div>

    <!-- JavaScript for Signature Pad -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            <?php foreach ($templates as $form): ?>
                initSignaturePad(<?= $form['id'] ?>);
            <?php endforeach; ?>
        });

        function initSignaturePad(formId) {
            const canvas = document.getElementById('signature-pad-' + formId);
            const signatureData = document.getElementById('signature-data-' + formId);
            const signaturePad = new SignaturePad(canvas, {
                backgroundColor: 'rgb(247, 247, 247)',
                penColor: 'rgb(12, 55, 42)'
            });

            // Store the signature pad instance for later use
            window['signaturePad_' + formId] = signaturePad;

            // Update hidden input when signature changes
            signaturePad.addEventListener('endStroke', () => {
                signatureData.value = signaturePad.toDataURL();
            });
        }

        function clearSignature(formId) {
            const signaturePad = window['signaturePad_' + formId];
            if (signaturePad) {
                signaturePad.clear();
                document.getElementById('signature-data-' + formId).value = '';
            }
        }
    </script>
</section>