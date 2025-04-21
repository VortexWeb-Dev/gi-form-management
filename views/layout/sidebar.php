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
        <a href="?page=dashboard" class="flex items-center px-3 py-2 rounded-lg hover:bg-[#0c372a]/10 transition <?= active('dashboard') ?>">
            <i class="fas fa-chart-line w-5 mr-3"></i>Dashboard
        </a>
        <a href="?page=inbox" class="flex items-center px-3 py-2 rounded-lg hover:bg-[#0c372a]/10 transition <?= active('inbox') ?>">
            <i class="fas fa-inbox w-5 mr-3"></i>Form Inbox
        </a>
        <a href="?page=archive" class="flex items-center px-3 py-2 rounded-lg hover:bg-[#0c372a]/10 transition <?= active('archive') ?>">
            <i class="fas fa-archive w-5 mr-3"></i>Archive
        </a>
        <a href="?page=templates" class="flex items-center px-3 py-2 rounded-lg hover:bg-[#0c372a]/10 transition <?= active('templates') ?>">
            <i class="fas fa-layer-group w-5 mr-3"></i>Templates
        </a>
        <a href="?page=config" class="flex items-center px-3 py-2 rounded-lg hover:bg-[#0c372a]/10 transition <?= active('config') ?>">
            <i class="fas fa-cogs w-5 mr-3"></i>Config
        </a>
    </nav>

    <div class="mt-6 text-center text-xs text-gray-500">
        &copy; <?= date('Y') ?> GI Properties<br />
        Developed by <a href="https://vortexweb.cloud/" class="text-[#0c372a] font-medium">VortexWeb</a>
    </div>
</aside>