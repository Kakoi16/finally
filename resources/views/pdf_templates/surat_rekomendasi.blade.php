<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Surat Rekomendasi - {{ $recommended_name ?? '' }}</title>
  <style>
    body { font-family: 'Helvetica', sans-serif; line-height: 1.6; color: #333; }
    .container { width: 90%; margin: 0 auto; position: relative; } /* Tambahkan position: relative */
    .header, .footer { text-align: center; }
    .header h1 { margin: 0; font-size: 24px; }
    .header p { margin: 0; font-size: 12px; }
    .content { margin-bottom: 30px; }
    .content p { margin: 5px 0; }
    .content strong { display: inline-block; width: 220px; } /* Sesuaikan lebar label agar rapi */
    .date-location { text-align: right; margin-bottom: 40px; }
    .signature-section { margin-top: 50px; }
    .signature-block { display: inline-block; width: 45%; text-align: center; float: right; } /* Tambahkan float: right */
    .approved-stamp {
      position: absolute; /* Atur posisi absolut */
      top: 50%; /* Posisikan di tengah vertikal */
      left: 50%; /* Posisikan di tengah horizontal */
      transform: translate(-50%, -50%) rotate(-25deg); /* Geser ke tengah dan putar */
      font-size: 5em; /* Ukuran font besar */
      color: rgba(0, 128, 0, 0.4); /* Warna hijau transparan */
      font-weight: bold;
      text-transform: uppercase;
      border: 5px solid rgba(0, 128, 0, 0.4);
      padding: 10px 20px;
      border-radius: 10px;
      opacity: 0.7; /* Sedikit transparan */
      pointer-events: none; /* Agar tidak mengganggu interaksi lain jika ada */
      white-space: nowrap; /* Mencegah teks patah baris */
      z-index: 1000; /* Pastikan di atas konten lain */
    }
  </style>
</head>
<body>
  <div class="container">
    {{-- Logika untuk menampilkan stempel persetujuan --}}
    @if(isset($status) && $status === \App\Models\PengajuanSurat::STATUS_DISETUJUI)
      <div class="approved-stamp">
        TELAH DISETUJUI
      </div>
    @endif

    <div class="header">
      <h1>SURAT REKOMENDASI</h1>
      <p>Nomor Surat: {{ $surat_number ?? 'Belum Ada Nomor' }}</p>
    </div>

    <div class="date-location">
      <p>Jakarta, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
    </div>

    <div class="content">
      <p>Dengan ini saya menyatakan bahwa:</p>
      <p><strong>Nama yang Direkomendasikan</strong>: {{ $recommended_name ?? 'Tidak Ada Data' }}</p> {{-- Ubah recommendedName menjadi recommended_name --}}

      <p>Adalah individu yang saya kenal dan telah menunjukkan kinerja serta etika kerja yang baik selama bekerja di perusahaan ini.</p>

      <p>Saya, <strong>{{ $recommender_name ?? 'Nama Pemberi Rekomendasi' }}</strong>, selaku <strong>{{ $recommender_position ?? 'Jabatan' }}</strong>, memberikan rekomendasi ini berdasarkan:</p> {{-- Ubah recommenderPosition menjadi recommender_position --}}
      <p>{{ $recommendation_reason ?? 'Tidak Ada Data' }}</p> {{-- Ubah recommendationReason menjadi recommendation_reason --}}

      <p>Semoga surat rekomendasi ini dapat bermanfaat sebagaimana mestinya. Terima kasih.</p>
    </div>

    <div class="signature-section">
      <div class="signature-block">
        <p>Hormat saya,</p>
        {{-- Tambahkan QR Code di sini --}}
        @if(isset($qr_code))
          <img src="{!! $qr_code !!}" width="150" alt="QR Code Profil">
        @else
          <br><br><br> {{-- Jaga jarak jika QR Code tidak ada --}}
        @endif
        <p>( {{ $recommender_name ?? 'Nama Pemberi Rekomendasi' }} )</p> {{-- Gunakan recommender_name di tanda tangan --}}
      </div>
      <div style="clear: both;"></div>
    </div>
  </div>
</body>
</html>