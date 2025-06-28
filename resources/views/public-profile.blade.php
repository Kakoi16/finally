<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Publik</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">

    <div class="max-w-xl mx-auto mt-10 p-6 bg-white rounded-2xl shadow-md">
        <div class="flex items-center space-x-4">
           <img src="https://simpap.my.id/storage/app/public/{{ $profile->profile_picture_path }}" alt="Foto Profil"
     class="w-24 h-24 rounded-full object-cover border-2 border-indigo-500">

            <div>
                <h2 class="text-xl font-bold text-gray-800">{{ $user->name }}</h2>
                <p class="text-sm text-gray-500">{{ $user->email }}</p>
            </div>
        </div>

        <div class="mt-6 space-y-3">
            <p><strong>Tanggal Lahir:</strong> {{ $profile->tanggal_lahir }}</p>
            <p><strong>No HP:</strong> {{ $profile->phone_number }}</p>
            <p><strong>Alamat:</strong> {{ $profile->address }}</p>
            <p><strong>Departemen:</strong> {{ $profile->departemen }}</p>
            <p><strong>Tanggal Bergabung:</strong> {{ \Carbon\Carbon::parse($user->created_at)->translatedFormat('d F Y') }}</p>
            <p><strong>Status:</strong> {{ $profile->status_karyawan }}</p>
            <p class="text-gray-700 italic">"{{ $profile->bio }}"</p>
        </div>

        <div class="mt-6 text-center">
            <button onclick="copyUrl()" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                Salin URL Profil Ini
            </button>
        </div>
    </div>

    <script>
        function copyUrl() {
            const url = window.location.href;
            navigator.clipboard.writeText(url).then(() => {
                alert('URL profil berhasil disalin!');
            }).catch(() => {
                alert('Gagal menyalin URL.');
            });
        }
    </script>

</body>
</html>
