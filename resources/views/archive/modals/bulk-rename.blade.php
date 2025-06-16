<!-- Bulk Rename Modal -->
<div id="bulk-rename-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-xl p-6 w-full max-w-md">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Rename Selected Items</h3>
            <button id="close-bulk-rename-modal" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="mb-4">
            <label for="bulk-rename-pattern" class="block text-sm font-medium text-gray-700 mb-1">Naming Pattern</label>
            <select id="bulk-rename-pattern" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 mb-2">
                <option value="prefix">Add Prefix</option>
                <option value="suffix">Add Suffix</option>
                <option value="replace">Find and Replace</option>
                <option value="custom">Custom Pattern</option>
            </select>
            <div id="prefix-options" class="rename-option">
                <input type="text" id="prefix-text" placeholder="Enter prefix" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 mt-2">
            </div>
            <div id="suffix-options" class="rename-option hidden">
                <input type="text" id="suffix-text" placeholder="Enter suffix" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 mt-2">
            </div>
            <div id="replace-options" class="rename-option hidden">
                <input type="text" id="find-text" placeholder="Find text" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 mt-2">
                <input type="text" id="replace-with" placeholder="Replace with" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 mt-2">
            </div>
            <div id="custom-options" class="rename-option hidden">
                <input type="text" id="custom-pattern" placeholder="Custom pattern (use {n} for number)" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 mt-2">
            </div>
        </div>
        <div class="flex justify-end space-x-3">
            <button id="cancel-bulk-rename" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">Cancel</button>
            <button id="confirm-bulk-rename" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">Rename</button>
        </div>
    </div>
</div>