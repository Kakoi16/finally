@extends('layouts.app') {{-- Sesuaikan dengan layout utama kamu --}}

@section('content')
<div class="p-4 md:p-6 bg-slate-50 min-h-screen">

    @if ($errors->any())
    <div class="max-w-xl mx-auto mb-6">
        <div class="bg-red-50 border-l-4 border-red-400 text-red-700 p-4 rounded-md shadow-md" role="alert">
            <div class="flex">
                <div class="py-1">
                    <svg class="fill-current h-6 w-6 text-red-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zM10 14.5a.75.75 0 0 0 .75-.75v-3a.75.75 0 0 0-1.5 0v3a.75.75 0 0 0 .75.75zM10 7.5a.75.75 0 0 0 .75.75h.008a.75.75 0 1 0 0-1.5H10a.75.75 0 0 0-.75.75z"/></svg>
                </div>
                <div>
                    <p class="font-bold">Oops! Ada beberapa kesalahan:</p>
                    <ul class="list-disc list-inside text-sm mt-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="max-w-xl mx-auto bg-white shadow-xl rounded-xl p-6 md:p-8 border border-slate-200">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 border-b border-slate-200 pb-4">
            <h2 class="text-2xl font-semibold text-slate-800">Edit Profil</h2>
            <a href="{{ route("profile") }}" {{-- Atau ganti dengan route spesifik misal: route('profile') --}}
               class="mt-4 sm:mt-0 inline-flex items-center px-4 py-2 border border-slate-300 text-sm font-medium rounded-lg text-slate-700 bg-white hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-150 shadow-sm">
                <svg class="w-4 h-4 mr-2 -ml-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
                Kembali
            </a>
        </div>

        <form method="POST" action="{{ route('profile.update') }}" class="space-y-5">
            @csrf
            @method('PUT') {{-- Umumnya update menggunakan method PUT atau PATCH --}}

            <div>
                <label for="name" class="block text-sm font-medium text-slate-700 mb-1.5">Nama</label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                       class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm p-2.5 placeholder-slate-400"
                       required>
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-slate-700 mb-1.5">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                       class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm p-2.5 placeholder-slate-400"
                       required>
            </div>

            <div>
    <label for="password" class="block text-sm font-medium text-slate-700 mb-1.5">Password Baru <span class="text-xs text-slate-500">(Opsional)</span></label>
    <input type="password" name="password" id="password" autocomplete="new-password"
           class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm p-2.5 placeholder-slate-400">
    <p class="mt-1 text-xs text-slate-500" id="password-help">Biarkan kosong jika tidak ingin mengubah password.</p>
</div>

<div>
    <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-1.5">Konfirmasi Password Baru</label>
    <input type="password" name="password_confirmation" id="password_confirmation" autocomplete="new-password"
           class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm p-2.5 placeholder-slate-400">
</div>


            <div class="flex justify-end pt-3">
                <button type="submit"
                        class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-2.5 border border-transparent text-sm font-medium rounded-lg shadow-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-150">
                    <svg class="w-4 h-4 mr-2 -ml-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                    </svg>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection