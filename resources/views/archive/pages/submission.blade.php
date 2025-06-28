<div id="submission-page" class="page-content p-4 sm:p-6">
    <div class="max-w-7xl mx-auto">
        {{-- ... (Filter dan feedback message tetap sama) ... --}}
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Daftar Pengajuan Surat Karyawan</h2>
            <p class="text-gray-600">Kelola pengajuan surat dari karyawan.</p>
        </div>

        <div class="mb-4">
            <label for="status-filter" class="block text-sm font-medium text-gray-700">Filter berdasarkan Status:</label>
            <select id="status-filter" name="status_filter" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                <option value="">Semua Status</option>
                <option value="{{ App\Models\PengajuanSurat::STATUS_PROSES }}">{{ App\Models\PengajuanSurat::STATUS_PROSES }}</option>
                <option value="{{ App\Models\PengajuanSurat::STATUS_DISETUJUI }}">{{ App\Models\PengajuanSurat::STATUS_DISETUJUI }}</option>
                <option value="{{ App\Models\PengajuanSurat::STATUS_DITOLAK }}">{{ App\Models\PengajuanSurat::STATUS_DITOLAK }}</option>
            </select>
        </div>

        <div id="feedback-message" class="mb-4 hidden p-4 rounded-md"></div>

        <div class="bg-white shadow-md rounded-lg overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Surat</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Pengaju</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tgl Pengajuan</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lampiran</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody id="submission-table-body" class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td colspan="8" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">Memuat data...</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div id="pagination-links" class="mt-4"></div>
    </div>
</div>

<!-- Modal PDF Viewer -->
<div id="pdf-viewer-modal" class="fixed inset-0 bg-gray-800 bg-opacity-75 overflow-y-auto h-full w-full hidden flex items-center justify-center z-50 p-4">
    <div class="relative bg-white w-full max-w-3xl lg:max-w-5xl mx-auto rounded-lg shadow-xl flex flex-col" style="height: 90vh;">
        <div class="flex justify-between items-center p-4 border-b border-gray-200">
            <h4 id="pdf-modal-title" class="text-lg font-semibold text-gray-800">Pratinjau Dokumen</h4>
            <button id="close-pdf-modal-button" class="text-gray-500 hover:text-gray-800 transition-colors">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="p-1 flex-grow bg-gray-100">
            <iframe id="pdf-iframe-viewer" src="about:blank" frameborder="0" width="100%" height="100%"></iframe>
        </div>
         <div class="p-3 border-t border-gray-200 text-right">
            <a id="pdf-download-link-modal" href="#" target="_blank" download class="px-4 py-2 bg-blue-500 text-white text-sm rounded hover:bg-blue-600 transition-colors">Unduh PDF</a>
        </div>
    </div>
</div>

<!-- Modal Alasan Penolakan -->
<div id="rejection-reason-modal" class="fixed inset-0 bg-gray-800 bg-opacity-75 overflow-y-auto h-full w-full hidden flex items-center justify-center z-50 p-4">
    <div class="relative bg-white w-full max-w-md mx-auto rounded-lg shadow-xl">
        <div class="flex justify-between items-center p-4 border-b border-gray-200">
            <h4 class="text-lg font-semibold text-gray-800">Alasan Penolakan</h4>
            <button id="close-rejection-modal-button" class="text-gray-500 hover:text-gray-800 transition-colors">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="p-4">
           <form action="{{ route('pengajuan-surat.reject') }}" method="POST">
    @csrf
    <input type="hidden" name="id" id="rejection-submission-id">
    <div class="mb-4">
        <label for="rejection-reason" class="block text-sm font-medium text-gray-700 mb-1">Masukkan alasan penolakan:</label>
        <textarea name="remarks" id="rejection-reason" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required></textarea>
    </div>
    <div class="flex justify-end space-x-3">
        <button type="button" id="cancel-rejection-button" class="px-4 py-2 bg-gray-300 text-gray-700 text-sm rounded hover:bg-gray-400 transition-colors">Batal</button>
        <button type="submit" class="px-4 py-2 bg-red-500 text-white text-sm rounded hover:bg-red-600 transition-colors">Tolak Pengajuan</button>
    </div>
</form>

        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const submissionTableBody = document.getElementById('submission-table-body');
    const statusFilter = document.getElementById('status-filter');
    const feedbackMessage = document.getElementById('feedback-message');
    const paginationLinksContainer = document.getElementById('pagination-links');

    // Elemen Modal PDF
    const pdfViewerModal = document.getElementById('pdf-viewer-modal');
    const pdfIframe = document.getElementById('pdf-iframe-viewer');
    const closePdfModalButton = document.getElementById('close-pdf-modal-button');
    const pdfModalTitle = document.getElementById('pdf-modal-title');
    const pdfDownloadLinkModal = document.getElementById('pdf-download-link-modal');

    // Elemen Modal Alasan Penolakan
    const rejectionReasonModal = document.getElementById('rejection-reason-modal');
    const closeRejectionModalButton = document.getElementById('close-rejection-modal-button');
    const cancelRejectionButton = document.getElementById('cancel-rejection-button');
    const rejectionForm = document.getElementById('rejection-form');
    const rejectionReasonInput = document.getElementById('rejection-reason');
    const rejectionSubmissionIdInput = document.getElementById('rejection-submission-id');

    const STATUS_PROSES = '{{ App\Models\PengajuanSurat::STATUS_PROSES }}';
    const STATUS_DISETUJUI = '{{ App\Models\PengajuanSurat::STATUS_DISETUJUI }}';
    const STATUS_DITOLAK = '{{ App\Models\PengajuanSurat::STATUS_DITOLAK }}';

    // Fungsi untuk membuka modal alasan penolakan
    function openRejectionModal(submissionId) {
        rejectionSubmissionIdInput.value = submissionId;
        rejectionReasonInput.value = '';
        rejectionReasonModal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    // Fungsi untuk menutup modal alasan penolakan
    function closeRejectionModal() {
        rejectionReasonModal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    // Event listener untuk modal alasan penolakan
    closeRejectionModalButton.addEventListener('click', closeRejectionModal);
    cancelRejectionButton.addEventListener('click', closeRejectionModal);
    

    // Delegasi event untuk tombol "Lihat PDF" dan tombol aksi
    submissionTableBody.addEventListener('click', function(event) {
        const target = event.target.closest('.view-pdf-button');
        if (target) {
            const pdfUrl = target.dataset.pdfUrl;
            const fileName = target.dataset.fileName;
            openPdfModal(pdfUrl, fileName);
        }

        const actionButton = event.target.closest('button.approve-btn, button.reject-btn');
        if(actionButton) {
            const submissionId = actionButton.dataset.id;
            if (actionButton.classList.contains('approve-btn')) {
                if (confirm(`Anda yakin ingin menyetujui pengajuan ID: ${submissionId}?`)) {
                    updateStatus(submissionId, STATUS_DISETUJUI);
                }
            } else if (actionButton.classList.contains('reject-btn')) {
                openRejectionModal(submissionId);
            }
        }
    });

    // Fungsi updateStatus dimodifikasi untuk menerima alasan penolakan
    async function updateStatus(id, newStatus, rejectionReason = null) {
        try {
            const requestBody = { status: newStatus };
            if (newStatus === STATUS_DITOLAK && rejectionReason) {
                requestBody.rejection_reason = rejectionReason;
            }

            const response = await fetch(`{{ url('admin/submissions') }}/${id}/status`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(requestBody)
            });
            
            const result = await response.json();
            if (result.success) {
                showFeedback(result.message, 'success');
                let currentPageUrl = document.querySelector('#pagination-links a[aria-current="page"]')?.href || buildFetchUrl(1);
                if(document.querySelector('#pagination-links .bg-indigo-50')) {
                    currentPageUrl = document.querySelector('#pagination-links .bg-indigo-50').href;
                } else if (paginationLinksContainer.querySelector('a[href^="{{ route("admin.submissions.index") }}"]')) {
                    currentPageUrl = paginationLinksContainer.querySelector('a[href^="{{ route("admin.submissions.index") }}"]').href;
                } else {
                    currentPageUrl = buildFetchUrl(1);
                }
                fetchSubmissions(currentPageUrl);
            } else {
                showFeedback(result.message || 'Gagal memperbarui status.', 'error');
            }
        } catch (error) {
            console.error("Error updating status:", error);
            showFeedback('Terjadi kesalahan saat menghubungi server.', 'error');
        }
    }

    // Fungsi renderTable dimodifikasi untuk menampilkan alasan penolakan jika ada
    function renderTable(submissions) {
        submissionTableBody.innerHTML = '';
        if (submissions.length === 0) {
            submissionTableBody.innerHTML = `<tr><td colspan="8" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">Tidak ada data pengajuan.</td></tr>`;
            return;
        }

        submissions.forEach(submission => {
            const row = submissionTableBody.insertRow();
            
            // Kolom ID
            row.insertCell().textContent = submission.id;
            
            // Kolom No. Surat
            row.insertCell().textContent = submission.surat_number;
            
            // Kolom Nama Pengaju
            row.insertCell().textContent = submission.name;
            
            // Kolom Kategori
            row.insertCell().textContent = submission.category;
            
            // Kolom Tanggal Pengajuan
            row.insertCell().textContent = new Date(submission.created_at).toLocaleDateString('id-ID', { 
                year: 'numeric', 
                month: 'short', 
                day: 'numeric' 
            });

            // Kolom Lampiran
            const attachmentCell = row.insertCell();
            attachmentCell.classList.add('px-6', 'py-4', 'whitespace-nowrap', 'text-sm', 'text-gray-500');
            if (submission.attachment_path) {
                const pathParts = submission.attachment_path.split('/');
                let categoryPath = '';
                let fileName = '';

                if (pathParts.length > 1) {
                    fileName = pathParts.pop();
                    categoryPath = pathParts.join('/');
                } else {
                    fileName = submission.attachment_path;
                }
                
                const fullPdfUrl = `{{ route('file.view', ['category' => 'PLACEHOLDER_CATEGORY', 'filename' => 'PLACEHOLDER_FILENAME']) }}`
                                  .replace('PLACEHOLDER_CATEGORY', encodeURIComponent(categoryPath))
                                  .replace('PLACEHOLDER_FILENAME', encodeURIComponent(fileName));

                const originalFileName = fileName;
                const viewButton = document.createElement('button');
                let displayFileName = originalFileName;
                if (displayFileName.length > 20) {
                    displayFileName = displayFileName.substring(0, 17) + '...';
                }
                viewButton.textContent = displayFileName;
                viewButton.title = `Lihat: ${originalFileName}`;
                viewButton.classList.add('text-indigo-600', 'hover:text-indigo-900', 'hover:underline', 'focus:outline-none', 'view-pdf-button');
                viewButton.dataset.pdfUrl = fullPdfUrl;
                viewButton.dataset.fileName = originalFileName;
                attachmentCell.appendChild(viewButton);
            } else {
                attachmentCell.textContent = '-';
            }

            // Kolom Status dengan tambahan alasan penolakan jika ada
            const statusCell = row.insertCell();
            statusCell.classList.add('px-6', 'py-4', 'whitespace-nowrap');
            
            let statusBadgeColor = 'bg-yellow-100 text-yellow-800';
            if (submission.status === STATUS_DISETUJUI) {
                statusBadgeColor = 'bg-green-100 text-green-800';
            } else if (submission.status === STATUS_DITOLAK) {
                statusBadgeColor = 'bg-red-100 text-red-800';
            }
            
            let statusHtml = `<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${statusBadgeColor}">${submission.status}</span>`;
            
            // Tambahkan tooltip untuk alasan penolakan jika status ditolak dan ada alasan
            if (submission.status === STATUS_DITOLAK && submission.rejection_reason) {
                statusHtml += `
                    <div class="mt-1 relative group">
                        <svg class="h-4 w-4 text-red-500 cursor-help" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div class="absolute z-10 hidden group-hover:block w-64 p-2 text-xs bg-white border border-gray-300 rounded shadow-lg">
                            <p class="font-semibold">Alasan Penolakan:</p>
                            <p>${submission.rejection_reason}</p>
                        </div>
                    </div>
                `;
            }
            
            statusCell.innerHTML = statusHtml;

            // Kolom Aksi
            // ... (di dalam fungsi renderTable(submissions)) ...

// Kolom Aksi
const actionsCell = row.insertCell();
actionsCell.classList.add('px-6', 'py-4', 'whitespace-nowrap', 'text-right', 'text-sm', 'font-medium');

// Logika ini yang perlu kita pastikan sudah benar dan bekerja
if (submission.status === STATUS_PROSES) {
    const approveButton = document.createElement('button');
    approveButton.textContent = 'Setuju';
    approveButton.classList.add('text-indigo-600', 'hover:text-indigo-900', 'mr-3', 'approve-btn');
    approveButton.dataset.id = submission.id;
    actionsCell.appendChild(approveButton);

    const rejectButton = document.createElement('button');
    rejectButton.textContent = 'Tolak';
    rejectButton.classList.add('text-red-600', 'hover:text-red-900', 'reject-btn');
    rejectButton.dataset.id = submission.id;
    actionsCell.appendChild(rejectButton);
// ... (di dalam fungsi renderTable(submissions)) ...

} else if (submission.status === STATUS_DISETUJUI) {
    const downloadApprovedButton = document.createElement('a');
    downloadApprovedButton.textContent = 'Unduh Disetujui';
    downloadApprovedButton.classList.add('px-3', 'py-1', 'bg-green-500', 'text-white', 'rounded', 'hover:bg-green-600', 'download-approved-btn');

    // BARIS INI YANG PERLU DIPERBAIKI LAGI
    // downloadApprovedButton.href = `{{ url('api/pengajuan-surat') }}/${submission.id}/download-pdf`; // Ini penyebab error sebelumnya

    // PERBAIKANNYA: Buat URL secara dinamis di JavaScript, sesuai dengan rute BARU di api.php
    // Gunakan 'pengajuan-surats' (plural) dan akhiran '/download'
    downloadApprovedButton.href = `{{ url('api/pengajuan-surats') }}/${submission.id}/download`;

    downloadApprovedButton.download = `surat_cuti_${submission.surat_number || submission.id}_disetujui.pdf`;
    actionsCell.appendChild(downloadApprovedButton);
}
// ... (lanjutkan kode fungsi renderTable) ...
else { // Untuk status 'Ditolak'
    actionsCell.textContent = '-'; // Atau tampilkan tombol lain jika ada aksi untuk status 'ditolak'
}

// ... (lanjutkan kode fungsi renderTable) ...
        });
    }

    // ... (Fungsi-fungsi lainnya seperti fetchSubmissions, renderPagination, showFeedback, buildFetchUrl tetap sama) ...
    async function fetchSubmissions(url = '{{ route("admin.submissions.index") }}') {
        submissionTableBody.innerHTML = `<tr><td colspan="8" class="px-6 py-4 text-sm text-gray-500 text-center">Memuat data...</td></tr>`;
        try {
            const response = await fetch(url);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            const result = await response.json();
            renderTable(result.data);
            renderPagination(result);
        } catch (error) {
            console.error("Error fetching submissions:", error);
            submissionTableBody.innerHTML = `<tr><td colspan="8" class="px-6 py-4 text-sm text-red-500 text-center">Gagal memuat data. ${error.message}</td></tr>`;
            showFeedback('Gagal memuat data pengajuan.', 'error');
        }
    }

    function renderPagination(result) {
        paginationLinksContainer.innerHTML = '';

        if (result.links && result.links.length > 0) {
            const nav = document.createElement('nav');
            nav.setAttribute('aria-label', 'Pagination');
            nav.classList.add('flex', 'items-center', 'justify-between', 'pt-4', 'border-t', 'border-gray-200');

            const prevNextContainer = document.createElement('div');
            prevNextContainer.classList.add('flex-1', 'flex', 'justify-between', 'sm:hidden');

            const pageInfoContainer = document.createElement('div');
            pageInfoContainer.classList.add('hidden', 'sm:flex-1', 'sm:flex', 'sm:items-center', 'sm:justify-between');

            let prevUrl = null;
            let nextUrl = null;

            const list = document.createElement('ul');
            list.classList.add('relative', 'z-0', 'inline-flex', 'rounded-md', 'shadow-sm', '-space-x-px');

            result.links.forEach(link => {
                if (link.label.includes('Previous')) {
                    prevUrl = link.url;
                    return;
                }
                if (link.label.includes('Next')) {
                    nextUrl = link.url;
                    return;
                }

                const listItem = document.createElement('li');
                const anchor = document.createElement('a');
                anchor.href = link.url || '#';
                anchor.innerHTML = link.label;
                anchor.classList.add('relative', 'inline-flex', 'items-center', 'px-4', 'py-2', 'border', 'border-gray-300', 'bg-white', 'text-sm', 'font-medium', 'text-gray-700', 'hover:bg-gray-50');

                if (link.active) {
                    anchor.classList.remove('bg-white', 'text-gray-700', 'hover:bg-gray-50');
                    anchor.classList.add('z-10', 'bg-indigo-50', 'border-indigo-500', 'text-indigo-600');
                    anchor.setAttribute('aria-current', 'page');
                } else if (!link.url) {
                    anchor.classList.add('disabled', 'text-gray-400', 'cursor-not-allowed');
                    anchor.href = '#';
                } else {
                     anchor.addEventListener('click', function(e) {
                        e.preventDefault();
                        if(link.url) fetchSubmissions(link.url + (statusFilter.value ? `&status=${statusFilter.value}` : ''));
                    });
                }
                listItem.appendChild(anchor);
                list.appendChild(listItem);
            });

            const prevButton = document.createElement('a');
            prevButton.innerHTML = '&laquo; Sebelumnya';
            prevButton.classList.add('relative', 'inline-flex', 'items-center', 'px-4', 'py-2', 'border', 'border-gray-300', 'text-sm', 'font-medium', 'rounded-md', 'text-gray-700', 'bg-white', 'hover:bg-gray-50');
            if (prevUrl) {
                prevButton.href = prevUrl;
                prevButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    fetchSubmissions(prevUrl + (statusFilter.value ? `&status=${statusFilter.value}` : ''));
                });
            } else {
                prevButton.classList.add('cursor-not-allowed', 'opacity-50');
                prevButton.href = '#';
            }

            const nextButton = document.createElement('a');
            nextButton.innerHTML = 'Berikutnya &raquo;';
            nextButton.classList.add('relative', 'inline-flex', 'items-center', 'px-4', 'py-2', 'ml-3', 'border', 'border-gray-300', 'text-sm', 'font-medium', 'rounded-md', 'text-gray-700', 'bg-white', 'hover:bg-gray-50');
             if (nextUrl) {
                nextButton.href = nextUrl;
                nextButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    fetchSubmissions(nextUrl + (statusFilter.value ? `&status=${statusFilter.value}` : ''));
                });
            } else {
                nextButton.classList.add('cursor-not-allowed', 'opacity-50');
                nextButton.href = '#';
            }

            if (prevNextContainer.firstChild) prevNextContainer.removeChild(prevNextContainer.firstChild);
            if (prevNextContainer.firstChild) prevNextContainer.removeChild(prevNextContainer.firstChild);

            const clonedPrev = prevButton.cloneNode(true);
            const clonedNext = nextButton.cloneNode(true);

             if (prevUrl) {
                clonedPrev.addEventListener('click', function(e) { e.preventDefault(); fetchSubmissions(prevUrl + (statusFilter.value ? `&status=${statusFilter.value}` : '')); });
            }
             if (nextUrl) {
                clonedNext.addEventListener('click', function(e) { e.preventDefault(); fetchSubmissions(nextUrl + (statusFilter.value ? `&status=${statusFilter.value}` : '')); });
            }
            prevNextContainer.appendChild(clonedPrev);
            prevNextContainer.appendChild(clonedNext);

            const pageInfo = document.createElement('div');
            pageInfo.innerHTML = `<p class="text-sm text-gray-700">
                                Menampilkan <span class="font-medium">${result.from || 0}</span>
                                sampai <span class="font-medium">${result.to || 0}</span>
                                dari <span class="font-medium">${result.total || 0}</span>
                                hasil
                              </p>`;
            pageInfoContainer.appendChild(pageInfo);
            const navButtonsContainer = document.createElement('div');
            navButtonsContainer.appendChild(prevButton);
            navButtonsContainer.appendChild(list);
            navButtonsContainer.appendChild(nextButton);
            pageInfoContainer.appendChild(navButtonsContainer);

            nav.appendChild(prevNextContainer);
            nav.appendChild(pageInfoContainer);
            paginationLinksContainer.appendChild(nav);
        }
    }

    function showFeedback(message, type = 'success') {
        feedbackMessage.textContent = message;
        feedbackMessage.classList.remove('hidden', 'bg-green-100', 'text-green-700', 'bg-red-100', 'text-red-700');
        if (type === 'success') {
            feedbackMessage.classList.add('bg-green-100', 'text-green-700');
        } else {
            feedbackMessage.classList.add('bg-red-100', 'text-red-700');
        }
        feedbackMessage.classList.remove('hidden');
        setTimeout(() => {
            feedbackMessage.classList.add('hidden');
        }, 3000);
    }

    function buildFetchUrl(page = 1) {
        let url = `{{ route("admin.submissions.index") }}?page=${page}`;
        const selectedStatus = statusFilter.value;
        if (selectedStatus) {
            url += `&status=${encodeURIComponent(selectedStatus)}`;
        }
        return url;
    }

    // Fungsi untuk membuka modal PDF
    function openPdfModal(pdfUrl, fileName) {
        pdfModalTitle.textContent = `Pratinjau: ${fileName}`;
        pdfIframe.src = pdfUrl;
        pdfDownloadLinkModal.href = pdfUrl;
        pdfDownloadLinkModal.download = fileName;
        pdfViewerModal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    // Fungsi untuk menutup modal PDF
    function closePdfModal() {
        pdfIframe.src = 'about:blank';
        pdfViewerModal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    // Event listener untuk tombol close modal PDF
    closePdfModalButton.addEventListener('click', closePdfModal);

    // Event listener untuk menutup modal dengan tombol Escape
    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && !pdfViewerModal.classList.contains('hidden')) {
            closePdfModal();
        }
        if (event.key === 'Escape' && !rejectionReasonModal.classList.contains('hidden')) {
            closeRejectionModal();
        }
    });

    // Event listener untuk menutup modal dengan klik di luar area konten modal
    pdfViewerModal.addEventListener('click', function(event) {
        if (event.target === pdfViewerModal) {
            closePdfModal();
        }
    });

    rejectionReasonModal.addEventListener('click', function(event) {
        if (event.target === rejectionReasonModal) {
            closeRejectionModal();
        }
    });

    statusFilter.addEventListener('change', function() {
        fetchSubmissions(buildFetchUrl(1));
    });

    if (!document.querySelector('meta[name="csrf-token"]')) {
        console.warn('CSRF token meta tag tidak found. AJAX PATCH requests might fail.');
        const csrfTokenTag = document.createElement('meta');
        csrfTokenTag.name = "csrf-token";
        csrfTokenTag.content = "{{ csrf_token() }}";
        document.head.appendChild(csrfTokenTag);
    }

    fetchSubmissions(buildFetchUrl());
});
</script>

