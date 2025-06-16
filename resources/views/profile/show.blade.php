@extends('layouts.app') {{-- Sesuaikan dengan layout utama kamu --}}

@section('content')
<div id="profile-page" class="p-4 md:p-6 bg-slate-50 min-h-screen">

    {{-- Tombol Kembali --}}
    <div class="max-w-2xl mx-auto mb-6">
        <a href="{{route('archive') }}" {{-- Atau ganti dengan route spesifik jika diperlukan, misal: route('dashboard') --}}
           class="inline-flex items-center px-4 py-2 border border-slate-300 text-sm font-medium rounded-lg text-slate-700 bg-white hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-150 shadow-sm">
            <svg class="w-4 h-4 mr-2 -ml-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
            Kembali
        </a>
    </div>

    {{-- Card Profil --}}
    <div class="max-w-2xl mx-auto bg-white shadow-xl rounded-xl p-6 md:p-8 border border-slate-200">
        
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 border-b border-slate-200 pb-4">
            <h2 class="text-2xl font-semibold text-slate-800">Profil Saya</h2>
            <a href="{{ route('profile.edit') }}" 
               class="mt-4 sm:mt-0 inline-flex items-center px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg shadow-md hover:shadow-lg transition-all duration-150 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <svg class="w-4 h-4 mr-2 -ml-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                </svg>
                Edit Profil
            </a>
        </div>

        <div class="space-y-4"> {{-- Jarak antar detail profil --}}
            <div class="flex items-center py-2 border-b border-slate-100">
                <p class="w-1/3 text-sm font-medium text-slate-600">Nama:</p>
                <p class="w-2/3 text-sm text-slate-800 font-semibold">{{ $user->name }}</p>
            </div>
            <div class="flex items-center py-2 border-b border-slate-100">
                <p class="w-1/3 text-sm font-medium text-slate-600">Email:</p>
                <p class="w-2/3 text-sm text-slate-800 font-semibold">{{ $user->email }}</p>
            </div>
            <div class="flex items-center py-2 border-b border-slate-100">
                <p class="w-1/3 text-sm font-medium text-slate-600">Role:</p>
                <p class="w-2/3 text-sm text-slate-800 font-semibold capitalize">{{ $user->role }}</p>
            </div>
            <div class="flex items-center py-2"> {{-- Tidak ada border-b pada item terakhir --}}
                <p class="w-1/3 text-sm font-medium text-slate-600">Terdaftar sejak:</p>
                <p class="w-2/3 text-sm text-slate-800 font-semibold">{{ $user->created_at->translatedFormat('d F Y') }}</p> {{-- Menggunakan translatedFormat --}}
            </div>
        </div>
    </div>
</div>
@endsection