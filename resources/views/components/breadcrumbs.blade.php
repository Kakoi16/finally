<nav aria-label="Breadcrumb" class="py-1">
    <ol class="flex items-center space-x-1.5 text-sm font-medium text-slate-500">
        {{-- Item Home --}}
        <li>
            <div class="flex items-center">
                <a href="{{ route('archive') }}" class="hover:text-indigo-600 hover:underline transition-colors duration-150 flex items-center">
                    {{-- Ikon Home (Opsional, menggunakan Heroicons SVG) --}}
                    <svg class="w-4 h-4 mr-1.5 flex-shrink-0 text-slate-400 group-hover:text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h7.5"/>
                    </svg>
                    Beranda
                </a>
            </div>
        </li>

        {{-- Loop untuk item breadcrumb lainnya --}}
        @if(isset($breadcrumbs) && is_array($breadcrumbs))
            @foreach ($breadcrumbs as $index => $crumb)
            <li>
                <div class="flex items-center">
                    {{-- Ikon Separator (Heroicons SVG) --}}
                    <svg class="w-5 h-5 text-slate-400 flex-shrink-0 mx-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                    </svg>

                    @if ($loop->last && (!isset($isCurrentPageLinkable) || !$isCurrentPageLinkable)) {{-- Anggap item terakhir adalah halaman saat ini dan tidak bisa diklik --}}
                        <span class="font-semibold text-slate-700" aria-current="page">
                            {{ $crumb['name'] }}
                        </span>
                    @else
                        <a href="{{ route('folders.open', ['folderName' => $crumb['path']]) }}" class="hover:text-indigo-600 hover:underline transition-colors duration-150">
                            {{ $crumb['name'] }}
                        </a>
                    @endif
                </div>
            </li>
            @endforeach
        @endif
    </ol>
</nav>