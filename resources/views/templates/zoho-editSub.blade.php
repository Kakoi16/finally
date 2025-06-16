<!DOCTYPE html>
<html>
<head>
    <title>Edit Document</title>
</head>
<body>

    @if($documentUrl)
        <iframe src="{{ $documentUrl }}" width="100%" height="800px" frameborder="0"></iframe>
    @else
        <p>Failed to load document editor.</p>
    @endif

</body>
</html>
