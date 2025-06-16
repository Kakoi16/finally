@php
    $activities = \App\Models\Activity::where('user_id', auth()->id())
        ->latest() // Mengambil data terbaru
        ->take(10) // Batasi 10 aktivitas
        ->get();
    $displayedCount = $activities->count();
@endphp

<div id="recent-page" class="page-content hidden p-4 md:p-6">
    <div class="max-w-3xl mx-auto bg-white shadow-xl rounded-xl overflow-hidden border border-gray-200">
        <div class="px-6 py-5 bg-gradient-to-r from-slate-50 to-gray-100 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-xl font-semibold text-gray-800">
                        Aktivitas Terkini
                    </h3>
                    <p class="mt-1 text-sm text-gray-600">
                        Menampilkan {{ $displayedCount }} riwayat aktivitas terbaru Anda.
                    </p>
                </div>
                <div class="flex-shrink-0 bg-white p-2.5 rounded-full shadow-md border border-gray-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>
        
        @if($displayedCount > 0)
            <ul class="divide-y divide-gray-200">
                @foreach($activities as $activity)
                    <li class="px-6 py-4 hover:bg-indigo-50/60 transition-colors duration-150 ease-in-out">
                        <div class="flex items-start space-x-4">
                            {{-- Ikon Aktivitas --}}
                            <div class="flex-shrink-0 pt-1">
                                <span class="flex items-center justify-center h-10 w-10 rounded-full bg-indigo-100 text-indigo-600 shadow-sm border border-indigo-200">
                                    {{-- Ikon "trend" dari kode asli Anda --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                    </svg>
                                    {{-- Alternatif ikon (misal, jika ingin berdasarkan tipe aktivitas di masa depan):
                                    @if($activity->type === 'login')
                                        <svg>...</svg>
                                    @else
                                        <svg>...</svg>
                                    @endif
                                    --}}
                                </span>
                            </div>
                            {{-- Detail Aktivitas --}}
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-800 leading-snug">
                                    {{ $activity->activity }}
                                </p>
                                <div class="mt-1.5 flex items-center text-xs text-gray-500">
                                    <svg class="flex-shrink-0 mr-1.5 h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="font-medium" title="{{ $activity->created_at->format('d F Y, H:i:s P') }}">
                                        {{ $activity->created_at->diffForHumans() }}
                                    </span>
                                    <span class="mx-1.5 text-gray-400" aria-hidden="true">•</span>
                                    <span class="text-gray-500">
                                        {{ $activity->created_at->translatedFormat('d M Y, H:i') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <div class="px-6 py-16 text-center">
                <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-slate-100 text-slate-400 border-2 border-dashed border-slate-200 shadow-inner">
                    {{-- Ikon yang lebih relevan untuk "tidak ada aktivitas" --}}
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h7.5M8.25 12h7.5m-7.5 5.25h7.5M3.75 6.75h.007v.008H3.75V6.75zm.375 0a3.001 3.001 0 00-3 0M3.75 12h.007v.008H3.75V12zm.375 0a3.001 3.001 0 00-3 0M3.75 17.25h.007v.008H3.75v-1.725zm.375 0a3.001 3.001 0 00-3 0m6-16.5V6M6.75 6H20.25a1.5 1.5 0 011.5 1.5v10.5a1.5 1.5 0 01-1.5 1.5H3.75a1.5 1.5 0 01-1.5-1.5V7.5a1.5 1.5 0 011.5-1.5H6.75" />
                    </svg>
                </div>
                <h3 class="mt-5 text-lg font-semibold text-gray-800">Belum Ada Aktivitas</h3>
                <p class="mt-2 text-sm text-gray-500 max-w-md mx-auto">
                    Segala aktivitas yang Anda lakukan akan tercatat di sini untuk memudahkan Anda melacaknya kembali.
                </p>
                <div class="mt-8">
                    {{-- Tombol ini bisa diarahkan ke halaman utama atau halaman terkait untuk memulai aktivitas --}}
                    <button type="button" onclick="window.location.href='{{ route('dashboard') }}'" {{-- Ganti 'dashboard' dengan route yang sesuai --}}
                            class="inline-flex items-center px-4 py-2.5 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-150">
                        <svg class="w-5 h-5 mr-2 -ml-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                           <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" /> {{-- Panah ke kanan, atau plus jika lebih sesuai --}}
                        </svg>
                        Jelajahi Aplikasi
                    </button>
                </div>
            </div>
        @endif
        
        @if($displayedCount > 0)
        <div class="px-6 py-4 bg-slate-50 border-t border-gray-200 text-center">
            <p class="text-xs text-gray-500">
                Menampilkan {{ $displayedCount }} aktivitas terbaru.
                {{-- Jika ada halaman untuk melihat semua aktivitas:
                <a href="{{ route('activities.index') }}" class="ml-1 text-indigo-600 hover:text-indigo-800 font-medium">
                    Lihat Semua
                </a>
                --}}
            </p>
        </div>
        @endif
    </div>
</div>