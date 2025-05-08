<section id="myforms" class="mb-10">
    <div class="bg-white p-6 rounded-2xl shadow">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="text-xl font-semibold"><?= htmlspecialchars($title) ?></h2>
                <p class="text-sm text-gray-500"><?= htmlspecialchars($description) ?></p>
            </div>
            <select class="border border-gray-300 rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring focus:border-[#0c372a]">
                <option value="">Filter by Form Status</option>
                <option>Pending</option>
                <option>Signed</option>
                <option>In Progress</option>
            </select>
        </div>

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
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php foreach ($assignments as $i => $a): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 font-medium text-gray-800"><?= $i + 1 ?></td>
                            <td class="px-4 py-3"><?= htmlspecialchars($a['template_name']) ?></td>
                            <td class="px-4 py-3"><?= htmlspecialchars($a['assigned_to']) ?></td>
                            <td class="px-4 py-3"><?= htmlspecialchars($a['assigned_by']) ?></td>
                            <td class="px-4 py-3"><?= $a['assigned_at'] ?: '—' ?></td>
                            <td class="px-4 py-3">
                                <?php
                                $status = strtolower($a['status']);
                                $statusColors = [
                                    'pending'   => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-700'],
                                    'submitted' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-700'],
                                    'approved'  => ['bg' => 'bg-green-100', 'text' => 'text-green-700'],
                                    'rejected'  => ['bg' => 'bg-red-100', 'text' => 'text-red-700'],
                                ];
                                $c = $statusColors[$status] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-700'];
                                ?>
                                <span class="inline-block px-2 py-0.5 rounded-full text-xs <?= $c['bg'] ?> <?= $c['text'] ?>">
                                    <?= ucfirst($status) ?>
                                </span>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <a href="?page=form&action=view&id=<?= $a['id'] ?>"
                                    class="text-blue-600 hover:text-blue-800">View</a>
                                <button
                                    data-modal-target="modal-<?= $a['id'] ?>"
                                    class="text-green-600 hover:text-green-800 ml-2">Fill &amp; Sign</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modals: render *after* the table -->
    <?php foreach ($assignments as $a): ?>
        <div
            id="modal-<?= $a['id'] ?>"
            class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-start overflow-y-auto">
            <div class="bg-white rounded-lg max-w-2xl w-full my-8 p-6 relative max-h-[80vh] overflow-y-auto">
                <button
                    class="absolute top-2 right-2 text-gray-500 text-2xl"
                    onclick="toggleModal('modal-<?= $a['id'] ?>')">&times;</button>

                <h3 class="text-xl font-semibold mb-4"><?= htmlspecialchars($a['template_name']) ?></h3>

                <form
                    action="?page=fill&action=submit"
                    method="POST"
                    class="space-y-4">
                    <input type="hidden" name="assignment_id" value="<?= $a['id'] ?>">

                    <?php
                    usort($a['fields'], fn($x, $y) => $x['field_order'] <=> $y['field_order']);
                    foreach ($a['fields'] as $f):
                        $fname = "field_{$a['id']}_{$f['id']}";
                        $req   = $f['is_required'] ? 'required' : '';
                        $star  = $f['is_required'] ? '<span class="text-red-500">*</span>' : '';
                    ?>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                <?= htmlspecialchars($f['label']) ?> <?= $star ?>
                            </label>
                            <?php if (in_array($f['type'], ['text', 'number', 'currency', 'percentage'])): ?>
                                <input
                                    type="<?= $f['type'] === 'currency' ? 'number' : $f['type'] ?>"
                                    name="<?= $fname ?>"
                                    placeholder="<?= htmlspecialchars($f['placeholder'] ?? '') ?>"
                                    <?= $req ?>
                                    class="w-full px-4 py-2 border rounded-lg">
                            <?php elseif ($f['type'] === 'date'): ?>
                                <input
                                    type="date"
                                    name="<?= $fname ?>"
                                    <?= $req ?>
                                    class="w-full px-4 py-2 border rounded-lg">
                            <?php elseif ($f['type'] === 'textarea'): ?>
                                <textarea
                                    name="<?= $fname ?>"
                                    rows="3"
                                    <?= $req ?>
                                    class="w-full px-4 py-2 border rounded-lg"></textarea>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>

                    <div class="flex justify-end space-x-2 mt-4">
                        <button
                            type="button"
                            class="px-4 py-2 bg-gray-200 rounded"
                            onclick="toggleModal('modal-<?= $a['id'] ?>')">Cancel</button>
                        <button
                            type="submit"
                            class="px-4 py-2 bg-[#0c372a] text-white rounded">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    <?php endforeach; ?>
</section>

<script>
    function toggleModal(id) {
        const m = document.getElementById(id);
        m.classList.toggle('hidden');
        m.classList.toggle('flex');
    }

    document.querySelectorAll('[data-modal-target]').forEach(btn => {
        btn.addEventListener('click', () => {
            console.log(`Toggling modal for ${btn.getAttribute('data-modal-target')}`);
            
            toggleModal(btn.getAttribute('data-modal-target'));
        });
    });
</script>