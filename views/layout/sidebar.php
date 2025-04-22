<?php
function active($name)
{
    global $page;
    return $page === $name ? 'bg-[#0c372a] text-white' : '';
}
?>

<aside class="w-64 bg-white shadow-md border-r p-4 flex flex-col">
    <div class="text-xl font-bold text-[#0c372a] mb-4 text-center">GI Properties</div>

    <nav class="flex-1 space-y-2">
        <?php if ($isHR): ?>
            <a href="?page=dashboard" class="flex items-center px-3 py-2 rounded-lg hover:bg-[#0c372a]/10 transition <?= active('dashboard') ?>">
                <i class="fas fa-chart-line w-5 mr-3"></i>Dashboard
            </a>
            <a href="?page=inbox" class="flex items-center px-3 py-2 rounded-lg hover:bg-[#0c372a]/10 transition <?= active('inbox') ?>">
                <i class="fas fa-inbox w-5 mr-3"></i>Approval Inbox
            </a>
            <a href="?page=send" class="flex items-center px-3 py-2 rounded-lg hover:bg-[#0c372a]/10 transition <?= active('send') ?>">
                <i class="fas fa-paper-plane w-5 mr-3"></i>Send Forms
            </a>
            <a href="?page=track" class="flex items-center px-3 py-2 rounded-lg hover:bg-[#0c372a]/10 transition <?= active('track') ?>">
                <i class="fas fa-signature w-5 mr-3"></i>Track Signatures
            </a>
            <a href="?page=archive" class="flex items-center px-3 py-2 rounded-lg hover:bg-[#0c372a]/10 transition <?= active('archive') ?>">
                <i class="fas fa-archive w-5 mr-3"></i>Form Archive
            </a>
            <a href="?page=templates" class="flex items-center px-3 py-2 rounded-lg hover:bg-[#0c372a]/10 transition <?= active('templates') ?>">
                <i class="fas fa-layer-group w-5 mr-3"></i>Templates
            </a>
            <a href="?page=notifications" class="flex items-center px-3 py-2 rounded-lg hover:bg-[#0c372a]/10 transition <?= active('notifications') ?>">
                <i class="fas fa-bell w-5 mr-3"></i>Notifications
            </a>
            <a href="?page=config" class="flex items-center px-3 py-2 rounded-lg hover:bg-[#0c372a]/10 transition <?= active('config') ?>">
                <i class="fas fa-cogs w-5 mr-3"></i>Config
            </a>
            <a href="?page=log" class="flex items-center px-3 py-2 rounded-lg hover:bg-[#0c372a]/10 transition <?= active('log') ?>">
                <i class="fas fa-clipboard-list w-5 mr-3"></i>Audit Log
            </a>
        <?php else: ?>
            <a href="?page=myforms" class="flex items-center px-3 py-2 rounded-lg hover:bg-[#0c372a]/10 transition <?= active('myforms') ?>">
                <i class="fas fa-tasks w-5 mr-3"></i>My Forms
            </a>
            <a href="?page=fill" class="flex items-center px-3 py-2 rounded-lg hover:bg-[#0c372a]/10 transition <?= active('fill') ?>">
                <i class="fas fa-pen w-5 mr-3"></i>Fill & Sign
            </a>
            <a href="?page=submitted" class="flex items-center px-3 py-2 rounded-lg hover:bg-[#0c372a]/10 transition <?= active('submitted') ?>">
                <i class="fas fa-paper-plane w-5 mr-3"></i>Submitted Forms
            </a>
            <a href="?page=history" class="flex items-center px-3 py-2 rounded-lg hover:bg-[#0c372a]/10 transition <?= active('history') ?>">
                <i class="fas fa-history w-5 mr-3"></i>Form History
            </a>
            <a href="?page=notifications" class="flex items-center px-3 py-2 rounded-lg hover:bg-[#0c372a]/10 transition <?= active('notifications') ?>">
                <i class="fas fa-bell w-5 mr-3"></i>Notifications
            </a>
        <?php endif; ?>
    </nav>

    <div class="mt-6 text-center text-xs text-gray-500">
        &copy; <?= date('Y') ?> GI Properties<br />
        Developed by <a href="https://vortexweb.cloud/" class="text-[#0c372a] font-medium">VortexWeb</a>
    </div>
</aside>