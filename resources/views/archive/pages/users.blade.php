<div id="user-page" class="page-content hidden p-4 md:p-6 w-full">
    <div class="bg-white shadow-md rounded-lg p-4 md:p-6 w-full">
        <h2 class="text-2xl font-semibold mb-6 text-gray-700">Daftar Pengguna</h2>

        {{-- Tampilkan pesan sukses/error jika ada --}}
        @if (session('success_user_delete'))
            <div class="bg-green-50 border-l-4 border-green-400 text-green-700 px-4 py-3 rounded-md relative mb-4 shadow-sm" role="alert">
                <div class="flex">
                    <div class="py-1">
                        <svg class="fill-current h-6 w-6 text-green-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/>
                        </svg>
                    </div>
                    <div>
                        <strong class="font-bold">Berhasil!</strong>
                        <span class="block sm:inline">{{ session('success_user_delete') }}</span>
                    </div>
                </div>
            </div>
        @endif
        @if (session('error_user_delete'))
            <div class="bg-red-50 border-l-4 border-red-400 text-red-700 px-4 py-3 rounded-md relative mb-4 shadow-sm" role="alert">
                <div class="flex">
                    <div class="py-1">
                        <svg class="fill-current h-6 w-6 text-red-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/>
                        </svg>
                    </div>
                    <div>
                        <strong class="font-bold">Gagal!</strong>
                        <span class="block sm:inline">{{ session('error_user_delete') }}</span>
                    </div>
                </div>
            </div>
        @endif

        <div class="w-full overflow-x-auto rounded-lg shadow-lg border border-gray-200">
            <div class="sm:hidden p-4 bg-gray-50 border-b">
                <p class="text-sm font-medium text-gray-600">Geser ke kanan untuk melihat semua data</p>
            </div>
            <table class="w-full text-sm bg-white table-auto">
                <thead class="bg-gradient-to-r from-blue-50 to-indigo-50">
                    <tr>
                        <th class="px-2 sm:px-4 py-2 sm:py-3 border-b-2 border-blue-200 text-left font-semibold text-indigo-700 uppercase tracking-wider">ID</th>
                        <th class="px-2 sm:px-4 py-2 sm:py-3 border-b-2 border-blue-200 text-left font-semibold text-indigo-700 uppercase tracking-wider">Nama</th>
                        <th class="px-2 sm:px-4 py-2 sm:py-3 border-b-2 border-blue-200 text-left font-semibold text-indigo-700 uppercase tracking-wider">Email</th>
                        <th class="px-2 sm:px-4 py-2 sm:py-3 border-b-2 border-blue-200 text-left font-semibold text-indigo-700 uppercase tracking-wider">Role</th>
                        <th class="hidden md:table-cell px-2 sm:px-4 py-2 sm:py-3 border-b-2 border-blue-200 text-left font-semibold text-indigo-700 uppercase tracking-wider">Tanggal Dibuat</th>
                        <th class="px-2 sm:px-4 py-2 sm:py-3 border-b-2 border-blue-200 text-left font-semibold text-indigo-700 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($users as $user)
                        <tr class="hover:bg-blue-50 transition-colors duration-200 ease-in-out">
                            <td class="px-2 sm:px-4 py-2 sm:py-3 whitespace-nowrap font-medium text-gray-700">{{ $user->id }}</td>
                            <td class="px-2 sm:px-4 py-2 sm:py-3 whitespace-nowrap font-medium text-gray-800">{{ $user->name }}</td>
                            <td class="px-2 sm:px-4 py-2 sm:py-3 break-words max-w-[120px] sm:max-w-[200px] text-gray-600 truncate">{{ $user->email }}</td>
                            <td class="px-2 sm:px-4 py-2 sm:py-3 whitespace-nowrap">
                                <span class="px-2 sm:px-3 py-1 inline-flex text-xs font-semibold rounded-full 
                                    @if($user->role == 'admin') bg-indigo-100 text-indigo-800 border border-indigo-300 @else bg-gray-100 text-gray-800 border border-gray-300 @endif">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="hidden md:table-cell px-2 sm:px-4 py-2 sm:py-3 whitespace-nowrap text-gray-600">{{ $user->created_at ? $user->created_at->format('d M Y H:i') : '-' }}</td>
                            <td class="px-2 sm:px-4 py-2 sm:py-3 whitespace-nowrap">
                                @if (Auth::check() && Auth::user()->id !== $user->id)
                                    <button type="button"
                                        onclick="deleteUser('{{ route('users.destroy', $user->id) }}', '{{ $user->name }}', '{{ csrf_token() }}')"
                                        class="bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white font-semibold py-1 sm:py-1.5 px-2 sm:px-3 rounded-md text-xs flex items-center shadow-sm transition-all duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 sm:h-4 sm:w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Hapus
                                    </button>
                                @else
                                    <span class="text-xs text-gray-400 italic">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 sm:px-6 py-8 sm:py-12 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 sm:h-12 sm:w-12 text-gray-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01" />
                                    </svg>
                                    Tidak ada data pengguna.
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="bg-gray-50 px-4 py-3 border-t border-gray-200 text-right">
                <span class="text-xs text-gray-600">Total: {{ count($users) }} pengguna</span>
            </div>
        </div>
    </div>
</div>

<script>
    function deleteUser(url, username, csrfToken) {
        if (!confirm(`Apakah Anda yakin ingin menghapus pengguna ${username}? Tindakan ini tidak dapat diurungkan.`)) return;

        fetch(url, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(async res => {
            if (!res.ok) {
                const errorData = await res.json().catch(() => ({ message: 'Gagal memproses respons server.' }));
                throw new Error(errorData.message || `Error ${res.status}: ${res.statusText}`);
            }
            return res.json();
        })
        .then(data => {
            if (data.success) {
                alert(data.message || 'Pengguna berhasil dihapus.');
                location.reload();
            } else {
                alert(data.message || 'Terjadi kesalahan saat menghapus pengguna.');
            }
        })
        .catch(err => {
            console.error('Fetch Error:', err);
            alert(err.message || 'Gagal menghubungi server untuk menghapus pengguna.');
        });
    }
</script>
