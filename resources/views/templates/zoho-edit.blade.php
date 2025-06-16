<!DOCTYPE html>
<html>
<head>
    <title>Edit Document</title>
</head>
<body>
<<<<<<< HEAD

=======
>>>>>>> 365f2682a4a0ba76b17f51277b96827dd8b5a819
    @if($documentUrl)
        <iframe src="{{ $documentUrl }}" width="100%" height="800px" frameborder="0"></iframe>
    @else
        <p>Failed to load document editor.</p>
    @endif
</body>
</html>
