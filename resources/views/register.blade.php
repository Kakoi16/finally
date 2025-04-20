@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto bg-white rounded-lg shadow-md p-6">
    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Tambah Akun Karyawan</h2>

    <form action="{{ route('register.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm text-gray-600 mb-1" for="name">Nama Lengkap</label>
            <input type="text" name="name" id="name" class="w-full border border-gray-300 px-3 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
        </div>

        <div>
            <label class="block text-sm text-gray-600 mb-1" for="email">Email</label>
            <input type="email" name="email" id="email" class="w-full border border-gray-300 px-3 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
        </div>

        <div>
            <label class="block text-sm text-gray-600 mb-1" for="password">Password</label>
            <input type="password" name="password" id="password" class="w-full border border-gray-300 px-3 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
        </div>

        <div>
            <label class="block text-sm text-gray-600 mb-1" for="role">Role</label>
            <select name="role" id="role" class="w-full border border-gray-300 px-3 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="karyawan">Karyawan</option>
                <option value="admin">Admin</option>
            </select>
        </div>

        <div class="pt-4">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                Tambahkan Akun
            </button>
        </div>
    </form>
</div>
@endsection
