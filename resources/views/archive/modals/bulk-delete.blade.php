<!-- Bulk Delete Modal -->
<div id="bulk-delete-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-xl p-6 w-full max-w-md">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Delete Selected Items</h3>
            <button id="close-bulk-delete-modal" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="mb-4">
        <input type="hidden" id="bulk-delete-ids">
            <p class="text-gray-600">Are you sure you want to delete the selected items? This action cannot be undone.</p>
        </div>
        <div class="flex justify-end space-x-3">
            <button id="cancel-bulk-delete" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">Cancel</button>
            <button id="confirm-bulk-delete" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">Delete</button>
        </div>
    </div>
</div>
<script>
document.getElementById('confirm-bulk-delete').addEventListener('click', function () {
    const ids = JSON.parse(document.getElementById('bulk-delete-ids').value); // bentuk array

    fetch(`/folders/bulk-delete`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ ids: ids })
    }).then(res => res.json())
      .then(response => {
         console.log(response);
      }).catch(err => {
          alert('ada yang salah');
      });
});

</script>
