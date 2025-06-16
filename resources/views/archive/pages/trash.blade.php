<div id="trash-page" class="page-content">
    <div class="bg-red-50 border border-red-200 rounded-lg p-6 text-center">
        <i class="fas fa-trash text-red-500 text-4xl mb-3"></i>
        <h3 class="text-xl font-medium text-gray-800 mb-2">Tong Sampah</h3>
        <p class="text-gray-600 mb-6">File yang telah dihapus akan disimpan di sini selama 30 hari</p>

        @if($trashedItems->isEmpty())
            <p class="text-gray-400">Tidak ada file di sampah.</p>
        @else
            <div class="overflow-x-auto">
                <table class="table-auto w-full text-left text-sm">
                    <thead>
                        <tr class="bg-red-100 text-gray-700">
                            <th class="px-4 py-2">Nama</th>
                            <th class="px-4 py-2">Path</th>
                            <th class="px-4 py-2">Dihapus Pada</th>
                            <th class="px-4 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($trashedItems as $item)
                            <tr class="border-b">
                                <td class="px-4 py-2">{{ $item->name }}</td>
                                <td class="px-4 py-2">{{ $item->path }}</td>
                                <td class="px-4 py-2">{{ $item->deleted_at->diffForHumans() }}</td>
                                <td class="px-4 py-2 space-x-2">
                                    <form action="{{ route('archive.restore') }}" method="POST" class="inline">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $item->id }}">
                                        <button class="text-green-500 hover:underline">Pulihkan</button>
                                    </form>
                                    <form action="{{ route('archive.deletePermanent') }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus permanen?');">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $item->id }}">
                                        <button class="text-red-600 hover:underline">Hapus Permanen</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
