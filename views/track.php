<section id="track" class="mb-10">
    <div class="bg-white p-6 rounded-2xl shadow">
        <div class="mb-4">
            <h2 class="text-xl font-semibold"><?= htmlspecialchars($title ?? 'Track Signatures') ?></h2>
            <p class="text-sm text-gray-500"><?= htmlspecialchars($description ?? 'View which users have signed or are pending.') ?></p>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left border border-gray-200 rounded-lg overflow-hidden">
                <thead class="bg-gray-50 text-gray-700">
                    <tr>
                        <th class="px-4 py-2">Form</th>
                        <th class="px-4 py-2">User</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Sent</th>
                        <th class="px-4 py-2">Signed</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    <tr>
                        <td class="px-4 py-2">NDA Agreement</td>
                        <td class="px-4 py-2">Jane Smith</td>
                        <td class="px-4 py-2">
                            <span class="inline-block bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs">Signed</span>
                        </td>
                        <td class="px-4 py-2">2025-04-20</td>
                        <td class="px-4 py-2">2025-04-21</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2">Leave Application</td>
                        <td class="px-4 py-2">John Doe</td>
                        <td class="px-4 py-2">
                            <span class="inline-block bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs">Pending</span>
                        </td>
                        <td class="px-4 py-2">2025-04-19</td>
                        <td class="px-4 py-2">—</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2">Employment Contract</td>
                        <td class="px-4 py-2">Lisa Adams</td>
                        <td class="px-4 py-2">
                            <span class="inline-block bg-red-100 text-red-700 px-2 py-1 rounded-full text-xs">Declined</span>
                        </td>
                        <td class="px-4 py-2">2025-04-18</td>
                        <td class="px-4 py-2">—</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>