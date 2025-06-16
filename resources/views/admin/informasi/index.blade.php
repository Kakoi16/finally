 <div class="container mx-auto p-8">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">Manajemen Informasi Admin</h1>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="mb-4">
            <a href="{{ route('admin.informasi.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                + Tambah Informasi Baru
            </a>
        </div>

       {{-- ... bagian atas file ... --}}
<div class="bg-white shadow-md rounded-lg overflow-hidden">
    <table class="min-w-full leading-normal">
        <thead>
            <tr>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Judul</th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Caption</th>
                {{-- Kolom Ikon Dihapus --}}
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($informasi as $item)
            <tr class="hover:bg-gray-50">
                <td class="px-5 py-4 border-b border-gray-200 bg-white text-sm">{{ $item->judul }}</td>
                <td class="px-5 py-4 border-b border-gray-200 bg-white text-sm">{{ $item->caption }}</td>
                {{-- Kolom Ikon Dihapus --}}
                <td class="px-5 py-4 border-b border-gray-200 bg-white text-sm">
                    <a href="{{ route('admin.informasi.edit', $item->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-4">Edit</a>
                    <form action="{{ route('admin.informasi.destroy', $item->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
               <td colspan="3" class="text-center py-10 text-gray-500">Tidak ada data informasi.</td> {{-- Colspan diubah menjadi 3 --}}
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
{{-- ... bagian bawah file ... --}}
 <div class="mt-6">
            {{ $informasi->links() }}
        </div>
    </div>