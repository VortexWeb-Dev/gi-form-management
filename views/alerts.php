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
                <?php foreach (range(1, 5) as $i): ?>
                    <li class="flex justify-between items-center py-3 px-4 rounded-lg shadow-sm bg-gray-50 hover:bg-gray-100">
                        <div>
                            <p class="font-medium text-gray-800">New Form Assigned - NDA Agreement</p>
                            <p class="text-sm text-gray-500">You have been assigned the NDA agreement form for completion and signing.</p>
                        </div>
                        <div class="space-x-2">
                            <button class="text-[#0c372a] hover:underline text-sm">View</button>
                            <button class="text-gray-600 hover:underline text-sm">Dismiss</button>
                        </div>
                    </li>
                <?php endforeach ?>
            </ul>
        </div>
    </div>
</section>