@extends('layouts.app')

@section('content')
<div id="submission-page" class="page-content p-4 sm:p-6">
    <div class="max-w-6xl mx-auto">
        <h1 class="text-xl sm:text-2xl font-bold text-gray-800 mb-4 sm:mb-6">Approval Laporan Karyawan</h1>
        
        <!-- Filter Section -->
        @include('approval._filter')
        
        <!-- Submission List -->
        @include('approval._list', ['submissions' => $submissions])
    </div>
</div>

<!-- Detail Modal -->
@include('approval._modal')
@endsection

@section('scripts')
<script>
    function openDetailModal(id) {
        // In a real app, you would fetch the data for this ID from your backend
        console.log("Opening details for submission ID:", id);
        document.getElementById('detailModal').classList.remove('hidden');
    }

    function closeDetailModal() {
        document.getElementById('detailModal').classList.add('hidden');
    }
</script>
@endsection