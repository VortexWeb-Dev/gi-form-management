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
            // Example array of pending forms. Replace this with actual dynamic data.
            $pendingForms = [
                ['form_name' => 'NDA Agreement', 'employee_name' => 'Jane Smith', 'form_id' => 1],
                ['form_name' => 'Leave Request', 'employee_name' => 'John Doe', 'form_id' => 2],
            ];

            foreach ($pendingForms as $form):
            ?>
                <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                    <h3 class="text-lg font-semibold"><?= htmlspecialchars($form['form_name']) ?></h3>
                    <p class="text-sm text-gray-600">Assigned to: <?= htmlspecialchars($form['employee_name']) ?></p>
                    <form action="submit_form.php" method="POST" class="space-y-4">
                        <input type="hidden" name="form_id" value="<?= $form['form_id'] ?>">

                        <!-- Example Form Fields (You can adjust these fields as per the form structure) -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Employee Name</label>
                                <input type="text" name="employee_name" value="<?= htmlspecialchars($form['employee_name']) ?>" required class="w-full px-4 py-2 border rounded-lg text-sm focus:outline-none focus:ring focus:border-[#0c372a]" readonly>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                                <input type="date" name="date" required class="w-full px-4 py-2 border rounded-lg text-sm focus:outline-none focus:ring focus:border-[#0c372a]">
                            </div>
                        </div>

                        <!-- Signature Section -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Your Digital Signature</label>
                            <div class="border-2 border-gray-300 p-6 rounded-lg">
                                <p class="text-gray-600 text-sm">Use the area below to apply your signature.</p>
                                <!-- Placeholder for digital signature input (e.g., canvas or signature field) -->
                                <canvas id="signature-pad-<?= $form['form_id'] ?>" class="w-full h-32 bg-gray-100 rounded-lg"></canvas>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div>
                            <button type="submit" name="action" value="sign" class="inline-block px-6 py-2 text-sm font-semibold text-white bg-[#0c372a] rounded-lg hover:bg-[#0a2a1a]">
                                Sign and Submit
                            </button>
                        </div>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>