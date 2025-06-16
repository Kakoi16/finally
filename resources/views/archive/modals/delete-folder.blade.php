<!-- Delete Folder Modal -->
<div id="delete-folder-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-xl p-6 w-full max-w-md">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Delete Folder</h3>
            <button id="close-delete-folder-modal" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <input type="hidden" id="delete-folder-id">
        </div>
        <div class="mb-4">
            <p class="text-gray-600">Are you sure you want to delete this folder and all its contents? This action cannot be undone.</p>
        </div>
        <div class="flex justify-end space-x-3">
            <button id="cancel-delete-folder" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">Cancel</button>
            <button id="confirm-delete-folder" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">Delete</button>
        </div>
    </div>
</div>
<script>
document.getElementById('confirm-delete-folder').addEventListener('click', function () {
    const folderId = document.getElementById('delete-folder-id').value;

    fetch(`/folders/${folderId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    }).then(res => res.json())
      .then(response => {
          alert(response.message);
      }).catch(err => {
          alert('ada yang salah');
      });
});

</script>
