<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Surat Keterangan Karyawan - {{ $name ?? '' }}</title>
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
      <h1>SURAT KETERANGAN KARYAWAN</h1>
      <p>Nomor Surat: {{ $surat_number ?? 'Belum Ada Nomor' }}</p>
    </div>

    <div class="date-location">
      <p>Jakarta, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
    </div>

    <div class="content">
      <p>Yang bertanda tangan di bawah ini:</p>
      <p><strong>Nama</strong>: {{ $name ?? 'Tidak Ada Data' }}</p>
      <p><strong>Email</strong>: {{ $email ?? 'Tidak Ada Data' }}</p>
      <p><strong>Jabatan</strong>: {{ $position ?? 'Tidak Ada Data' }}</p>

      <p>Dengan ini menerangkan bahwa yang bersangkutan adalah karyawan tetap di perusahaan kami sejak tanggal <strong>{{ \Carbon\Carbon::parse($joinDate ?? now())->translatedFormat('d F Y') }}</strong> hingga saat ini.</p>

      <p>Surat ini dibuat untuk keperluan: <strong>{{ $purpose ?? 'Tidak Ada Data' }}</strong>.</p>

      <p>Demikian surat keterangan ini dibuat dengan sebenar-benarnya untuk dipergunakan sebagaimana mestinya.</p>
    </div>

    <div class="signature-section">
      <div class="signature-block" style="float: right;">
        <p>Hormat kami,</p><br><br><br>
        <p>( {{ $name ?? 'Nama' }} )</p>
      </div>
      <div style="clear: both;"></div>
    </div>
  </div>
</body>
</html>
