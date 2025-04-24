<section id="send" class="mb-10">
    <div class="bg-white p-6 rounded-2xl shadow">
        <div class="mb-4">
            <h2 class="text-xl font-semibold"><?= htmlspecialchars($title ?? 'Send Forms') ?></h2>
            <p class="text-sm text-gray-500"><?= htmlspecialchars($description ?? 'Assign specific forms to individual users for completion and signature.') ?></p>
        </div>

        <form class="space-y-4" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Select Form</label>
                <select class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring focus:border-[#0c372a]">
                    <option value="">Choose a form</option>
                    <?php foreach ($templates as $template): ?>
                        <option value="<?= htmlspecialchars($template['id']) ?>"><?= htmlspecialchars($template['title']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Select User</label>
                <select class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring focus:border-[#0c372a]">
                    <option value="">Choose a user</option>
                    <?php foreach ($users as $userId => $userName): ?>
                        <option value="<?= htmlspecialchars($userId) ?>"><?= htmlspecialchars($userName) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Optional Message</label>
                <textarea rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring focus:border-[#0c372a]" placeholder="Add a note or instructions..."></textarea>
            </div>

            <div>
                <button type="submit" class="bg-[#0c372a] text-white text-sm px-5 py-2 rounded-lg hover:bg-[#0a2f24] transition">Send Form</button>
            </div>
        </form>
    </div>
</section>