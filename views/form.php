<section class="max-w-3xl mx-auto my-12">
  <!-- Card Container -->
  <div class="bg-white shadow-lg rounded-2xl ring-1 ring-gray-200 overflow-hidden">
    
    <!-- Header -->
    <div class="px-8 py-6 border-b border-gray-100">
      <h1 class="text-2xl font-semibold text-gray-900">
        <?= htmlspecialchars($title) ?>
      </h1>
    </div>

    <!-- Content -->
    <div class="px-8 py-6 space-y-6">
      <?php if (!empty($assignment)): ?>
        <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4">
          
          <div>
            <dt class="text-sm font-medium text-gray-500">Form Name</dt>
            <dd class="mt-1 text-lg font-semibold text-gray-800">
              <?= htmlspecialchars($assignment['template_name']) ?>
            </dd>
          </div>

          <div>
            <dt class="text-sm font-medium text-gray-500">Status</dt>
            <?php
              $status = strtolower($assignment['status']);
              $statusStyles = [
                'pending'   => 'bg-yellow-100 text-yellow-800',
                'submitted' => 'bg-blue-100 text-blue-800',
                'approved'  => 'bg-green-100 text-green-800',
                'rejected'  => 'bg-red-100 text-red-800',
              ];
              $badge = $statusStyles[$status] ?? 'bg-gray-100 text-gray-800';
            ?>
            <dd class="mt-1">
              <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium <?= $badge ?>">
                <?= ucfirst($status) ?>
              </span>
            </dd>
          </div>

          <div>
            <dt class="text-sm font-medium text-gray-500">Assigned By</dt>
            <dd class="mt-1 text-gray-700">
              <?= htmlspecialchars($assignment['assigned_by_name']) ?>
            </dd>
          </div>

          <div>
            <dt class="text-sm font-medium text-gray-500">Assigned To</dt>
            <dd class="mt-1 text-gray-700">
              <?= htmlspecialchars($assignment['assigned_to_name']) ?>
            </dd>
          </div>

          <div>
            <dt class="text-sm font-medium text-gray-500">Assigned At</dt>
            <dd class="mt-1 text-gray-700">
              <?= htmlspecialchars($assignment['assigned_at']) ?>
            </dd>
          </div>

          <?php if (!empty($assignment['remarks'])): ?>
            <div class="md:col-span-2">
              <dt class="text-sm font-medium text-gray-500">Remarks</dt>
              <dd class="mt-1 text-gray-700">
                <?= htmlspecialchars($assignment['remarks']) ?>
              </dd>
            </div>
          <?php endif; ?>

          <?php if (!isset($assignment['template_description']) || $assignment['template_description']): ?>
            <div class="md:col-span-2">
              <dt class="text-sm font-medium text-gray-500">Template Description</dt>
              <dd class="mt-1 text-gray-700">
                <?= htmlspecialchars($assignment['template_description'] ?? '—') ?>
              </dd>
            </div>
          <?php endif; ?>

        </dl>

        <!-- Actions -->
        <div class="pt-6 border-t border-gray-100 flex justify-end space-x-4">
          <a href="?page=myforms" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg">
            ← Back
          </a>
          <a href="?page=form&action=edit&id=<?= $assignment['id'] ?>"
             class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-green-600 hover:bg-green-700 rounded-lg">
            Fill & Sign
          </a>
        </div>

      <?php else: ?>
        <p class="text-center text-red-500">No form data available.</p>
      <?php endif; ?>
    </div>
  </div>
</section>
