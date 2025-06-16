<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Surat Rekomendasi - {{ $recommendedName ?? '' }}</title>
  <style>
    body { font-family: 'Helvetica', sans-serif; line-height: 1.6; color: #333; }
    .container { width: 90%; margin: 0 auto; }
    .header, .footer { text-align: center; }
    .date-location { text-align: right; margin-bottom: 40px; }
    .signature-section { margin-top: 50px; }
    .signature-block { display: inline-block; width: 45%; text-align: center; }
  </style>
</head>
<body>
  <div class="container">
    <div class="header">
      <h1>SURAT REKOMENDASI</h1>
      <p>Nomor Surat: {{ $surat_number ?? 'Belum Ada Nomor' }}</p>
    </div>

    <div class="date-location">
      <p>Jakarta, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
    </div>

    <div class="content">
      <p>Dengan ini saya menyatakan bahwa:</p>
      <p><strong>Nama yang Direkomendasikan</strong>: {{ $recommendedName ?? 'Tidak Ada Data' }}</p>

      <p>Adalah individu yang saya kenal dan telah menunjukkan kinerja serta etika kerja yang baik selama bekerja di perusahaan ini.</p>

      <p>Saya, <strong>{{ $name ?? 'Nama Pemberi Rekomendasi' }}</strong>, selaku <strong>{{ $recommenderPosition ?? 'Jabatan' }}</strong>, memberikan rekomendasi ini berdasarkan:</p>
      <p>{{ $recommendationReason ?? 'Tidak Ada Data' }}</p>

      <p>Semoga surat rekomendasi ini dapat bermanfaat sebagaimana mestinya. Terima kasih.</p>
    </div>

    <div class="signature-section">
      <div class="signature-block" style="float: right;">
        <p>Hormat saya,</p><br><br><br>
        <p>( {{ $name ?? 'Nama Pemberi Rekomendasi' }} )</p>
      </div>
      <div style="clear: both;"></div>
    </div>
  </div>
</body>
</html>
