<section id="inbox" class="mb-10">
    <div class="bg-white p-6 rounded-2xl shadow">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="text-xl font-semibold"><?= htmlspecialchars($title ?? 'Inbox') ?></h2>
                <p class="text-sm text-gray-500"><?= htmlspecialchars($description ?? 'View all submitted forms pending HR approval.') ?></p>
            </div>
            <input id="searchInput" type="text" placeholder="Search..." class="border border-gray-300 rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring focus:border-[#0c372a]">
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="bg-gray-50 border-b text-xs text-gray-500 uppercase">
                    <tr>
                        <th class="px-4 py-3">#</th>
                        <th class="px-4 py-3">Assigned To</th>
                        <th class="px-4 py-3">Assigned By</th>
                        <th class="px-4 py-3">Form Template</th>
                        <th class="px-4 py-3">Date Submitted</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php foreach ($assignments as $index => $assignment): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 font-medium text-gray-800"><?= $index + 1 ?></td>
                            <td class="px-4 py-3"><?= htmlspecialchars($assignment['assigned_to'] ?? 'N/A') ?></td>
                            <td class="px-4 py-3"><?= htmlspecialchars($assignment['assigned_by'] ?? 'N/A') ?></td>
                            <td class="px-4 py-3"><?= htmlspecialchars($assignment['template_name'] ?? 'N/A') ?></td>
                            <td class="px-4 py-3">
                                <?= $assignment['submitted_at'] ? $assignment['submitted_at'] : '—' ?>
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
                            <td class="px-4 py-3 text-right space-x-2">
                                <button
                                    class="text-[#0c372a] hover:underline text-sm view-btn"
                                    data-id="<?= $assignment['id'] ?>"
                                    data-to="<?= htmlspecialchars($assignment['assigned_to'] ?? 'N/A') ?>"
                                    data-by="<?= htmlspecialchars($assignment['assigned_by'] ?? 'N/A') ?>"
                                    data-form="<?= htmlspecialchars($assignment['template_name'] ?? 'N/A') ?>"
                                    data-date="<?= $assignment['submitted_at'] ?? '—' ?>"
                                    data-status="<?= ucfirst($assignment['status']) ?>">
                                    View
                                </button>
                                <button class="text-green-600 hover:underline text-sm">Approve</button>
                                <button class="text-red-500 hover:underline text-sm">Reject</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Modal -->
            <div id="assignmentModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-40">
                <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl p-6 relative">
                    <button id="closeModalBtn" class="absolute top-4 right-4 text-gray-500 hover:text-black text-xl">&times;</button>
                    <h3 class="text-lg font-semibold mb-4">Assignment Details</h3>
                    <div id="modalContent" class="text-sm text-gray-700 space-y-2">
                        <!-- Content gets filled via JS -->
                    </div>
                </div>
            </div>

            <script>
                document.querySelectorAll('.view-btn').forEach(button => {
                    button.addEventListener('click', () => {
                        const modal = document.getElementById('assignmentModal');
                        const content = document.getElementById('modalContent');
                        content.innerHTML = `
            <p><strong>Assigned To:</strong> ${button.dataset.to}</p>
            <p><strong>Assigned By:</strong> ${button.dataset.by}</p>
            <p><strong>Form Template:</strong> ${button.dataset.form}</p>
            <p><strong>Date Submitted:</strong> ${button.dataset.date}</p>
            <p><strong>Status:</strong> ${button.dataset.status}</p>
        `;
                        modal.classList.remove('hidden');
                        modal.classList.add('flex');
                    });
                });

                document.getElementById('closeModalBtn').addEventListener('click', () => {
                    const modal = document.getElementById('assignmentModal');
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                });

                window.addEventListener('click', (e) => {
                    const modal = document.getElementById('assignmentModal');
                    if (e.target === modal) {
                        modal.classList.add('hidden');
                        modal.classList.remove('flex');
                    }
                });
            </script>

            <script>
                // Modal logic (already present)
                document.querySelectorAll('.view-btn').forEach(button => {
                    button.addEventListener('click', () => {
                        const modal = document.getElementById('assignmentModal');
                        const content = document.getElementById('modalContent');
                        content.innerHTML = `
                <p><strong>Assigned To:</strong> ${button.dataset.to}</p>
                <p><strong>Assigned By:</strong> ${button.dataset.by}</p>
                <p><strong>Form Template:</strong> ${button.dataset.form}</p>
                <p><strong>Date Submitted:</strong> ${button.dataset.date}</p>
                <p><strong>Status:</strong> ${button.dataset.status}</p>
            `;
                        modal.classList.remove('hidden');
                        modal.classList.add('flex');
                    });
                });

                document.getElementById('closeModalBtn').addEventListener('click', () => {
                    document.getElementById('assignmentModal').classList.add('hidden');
                    document.getElementById('assignmentModal').classList.remove('flex');
                });

                window.addEventListener('click', (e) => {
                    const modal = document.getElementById('assignmentModal');
                    if (e.target === modal) {
                        modal.classList.add('hidden');
                        modal.classList.remove('flex');
                    }
                });

                document.getElementById('searchInput').addEventListener('input', function() {
                    const filter = this.value.toLowerCase();
                    const rows = document.querySelectorAll('tbody tr');

                    rows.forEach(row => {
                        const text = row.textContent.toLowerCase();
                        row.style.display = text.includes(filter) ? '' : 'none';
                    });
                });
            </script>


        </div>
    </div>
</section>