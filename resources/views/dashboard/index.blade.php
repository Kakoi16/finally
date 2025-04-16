@extends('layouts.app')

@section('content')
@php
    // Get authenticated user or use default values
    $authUser = Auth::user();
    $userName = $authUser ? $authUser->name : 'Guest';
    $userEmail = $authUser ? $authUser->email : 'guest@example.com';
    $emailVerified = $authUser ? ($authUser->email_verified_at ? true : false) : false;
    $initial = strtoupper(substr($userName, 0, 1));
@endphp

<div class="container mx-auto px-4 py-8">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-white">Dashboard</h1>
            <p class="text-gray-300">Welcome back, {{ $userName }}!</p>
        </div>
        <div class="mt-4 md:mt-0 flex items-center space-x-4">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input type="text" class="bg-gray-800 border border-gray-700 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5" placeholder="Search...">
            </div>
            <div class="relative">
                <button class="flex items-center space-x-2 bg-gray-800 hover:bg-gray-700 rounded-full p-2 transition-colors">
                    <div class="w-8 h-8 rounded-full bg-indigo-500 flex items-center justify-center text-white font-medium">
                        {{ $initial }}
                    </div>
                </button>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="glass-card rounded-xl p-6">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-300 text-sm font-medium">Total Events</p>
                    <h3 class="text-2xl font-bold mt-2">24</h3>
                </div>
                <div class="p-3 rounded-lg bg-indigo-500/20 text-indigo-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
            <p class="text-sm text-gray-400 mt-4"><span class="text-green-400">↑ 12%</span> from last month</p>
        </div>

        <div class="glass-card rounded-xl p-6">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-300 text-sm font-medium">Upcoming</p>
                    <h3 class="text-2xl font-bold mt-2">5</h3>
                </div>
                <div class="p-3 rounded-lg bg-blue-500/20 text-blue-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <p class="text-sm text-gray-400 mt-4"><span class="text-green-400">↑ 3%</span> from last month</p>
        </div>

        <div class="glass-card rounded-xl p-6">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-300 text-sm font-medium">Completed</p>
                    <h3 class="text-2xl font-bold mt-2">16</h3>
                </div>
                <div class="p-3 rounded-lg bg-green-500/20 text-green-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <p class="text-sm text-gray-400 mt-4"><span class="text-red-400">↓ 2%</span> from last month</p>
        </div>

        <div class="glass-card rounded-xl p-6">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-300 text-sm font-medium">Account Status</p>
                    <h3 class="text-2xl font-bold mt-2">{{ $emailVerified ? 'Verified' : 'Pending' }}</h3>
                </div>
                <div class="p-3 rounded-lg bg-purple-500/20 text-purple-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <p class="text-sm text-gray-400 mt-4">{{ $userEmail }}</p>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recent Events -->
        <div class="lg:col-span-2">
            <div class="glass-card rounded-xl p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold">Recent Events</h2>
                    <button class="text-sm text-indigo-400 hover:text-indigo-300">View All</button>
                </div>
                
                <div class="space-y-4">
                    <!-- Event items remain the same -->
                    <!-- ... -->
                </div>
            </div>
        </div>
        
        <!-- Quick Actions & Profile -->
        <div class="space-y-6">
            <!-- Quick Actions -->
            <div class="glass-card rounded-xl p-6">
                <h2 class="text-xl font-bold mb-6">Quick Actions</h2>
                <div class="grid grid-cols-2 gap-4">
                    <!-- Quick action buttons remain the same -->
                    <!-- ... -->
                </div>
            </div>
            
            <!-- Profile Summary -->
            <div class="glass-card rounded-xl p-6">
                <h2 class="text-xl font-bold mb-6">Your Profile</h2>
                <div class="flex items-center space-x-4 mb-4">
                    <div class="w-16 h-16 rounded-full bg-indigo-500 flex items-center justify-center text-white text-2xl font-medium">
                        {{ $initial }}
                    </div>
                    <div>
                        <h3 class="font-bold">{{ $userName }}</h3>
                        <p class="text-sm text-gray-400">{{ $userEmail }}</p>
                    </div>
                </div>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-400">Status</span>
                        <span class="{{ $emailVerified ? 'text-green-400' : 'text-yellow-400' }} font-medium">
                            {{ $emailVerified ? 'Verified' : 'Pending Verification' }}
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">Member Since</span>
                        <span class="text-white">2023</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">Events Created</span>
                        <span class="text-white">24</span>
                    </div>
                </div>
                <button class="w-full mt-6 py-2 px-4 bg-indigo-600 hover:bg-indigo-700 rounded-lg text-white font-medium transition-colors">
                    Edit Profile
                </button>
            </div>
        </div>
    </div>
</div>
@endsection