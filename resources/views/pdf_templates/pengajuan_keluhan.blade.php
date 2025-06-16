<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Pengajuan Keluhan - {{ $name ?? '' }}</title>
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
      <h1>SURAT PENGAJUAN KELUHAN</h1>
      <p>Nomor Surat: {{ $surat_number ?? 'Belum Ada Nomor' }}</p>
    </div>

    <div class="date-location">
      <p>Jakarta, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
    </div>

    <div class="content">
      <p>Kepada Yth.,</p>
      <p>Manajer/Divisi Terkait</p>
      <p>PT. [Nama Perusahaan Anda]</p>
      <p>Di Tempat</p><br>

      <p>Dengan hormat,</p>
      <p>Saya yang bertanda tangan di bawah ini:</p>
      <p><strong>Nama</strong>: {{ $name ?? 'Tidak Ada Data' }}</p>
      <p><strong>Email</strong>: {{ $email ?? 'Tidak Ada Data' }}</p>

      <p>Menyampaikan keluhan yang berkaitan dengan:</p>
      <p><strong>Departemen</strong>: {{ $department ?? 'Tidak Ada Data' }}</p>
      <p><strong>Kategori Keluhan</strong>: {{ $complaintCategory ?? 'Tidak Ada Data' }}</p>
      <p><strong>Deskripsi</strong>: {{ $complaintDescription ?? 'Tidak Ada Data' }}</p>

      <p>Saya berharap keluhan ini dapat segera ditindaklanjuti. Terima kasih atas perhatian Bapak/Ibu.</p>
    </div>

    <div class="signature-section">
      <div class="signature-block" style="float: right;">
        <p>Hormat saya,</p><br><br><br>
        <p>( {{ $name ?? 'Nama Pengaju' }} )</p>
      </div>
      <div style="clear: both;"></div>
    </div>
  </div>
</body>
</html>
