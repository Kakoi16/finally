<!-- Breadcrumbs -->
<nav>
    <ol class="breadcrumb">
        <a href="{{ route('archive') }}">Home</a>

        @foreach ($breadcrumbs as $crumb)
        <li>
            <a href="{{ route('folders.open', ['folderName' => $crumb['path']]) }}"> {{ $crumb['name'] }}
            </a>
        </li>
        @endforeach
    </ol>
</nav>