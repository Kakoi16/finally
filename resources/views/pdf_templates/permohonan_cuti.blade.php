<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Permohonan Cuti - {{ $name ?? '' }}</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; line-height: 1.6; color: #333; }
        .container { width: 90%; margin: 0 auto; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 24px; }
        .header p { margin: 0; font-size: 12px; }
        .content { margin-bottom: 30px; }
        .content p { margin: 5px 0; }
        .content strong { display: inline-block; width: 180px; }
        .date-location { text-align: right; margin-bottom: 40px; }
        .signature-section { margin-top: 5px; }
        .signature-block { display: inline-block; width: 45%; text-align: center; }
        .footer { text-align: center; font-size: 10px; color: #777; position: fixed; bottom: 0; width: 100%; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px;}
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left;}
        th { background-color: #f2f2f2; }
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
        }
        
         .indent-text {
        margin-left: 20px; /* Sesuaikan indentasi sesuai kebutuhan */
        display: block; /* Agar teks selanjutnya mulai dari baris baru di bawah indentasi */
    }
    .label-cuti {
        display: inline-block;
        width: 150px; /* Lebar tetap untuk label, sesuaikan jika perlu */
    }
    .value-cuti {
        display: inline-block;
        /* Jika perlu lebar tertentu untuk nilai, tambahkan width di sini juga */
    }
    </style>
</head>
<body>
    <div class="container" style="position: relative;"> @if(isset($status) && $status === \App\Models\PengajuanSurat::STATUS_DISETUJUI)
            <div class="approved-stamp">
                TELAH DISETUJUI
            </div>
        @endif

        <div class="header">
            <h1>SURAT PERMOHONAN CUTI</h1>
            <p>Nomor Surat: {{ $surat_number ?? 'Belum Ada Nomor' }}</p>
        </div>

        <div class="date-location">
            <p>Jakarta, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
        </div>

        <div class="content">
            <p>Kepada Yth.,</p>
            <p>Manajer HRD / Atasan Langsung</p>
            <p>PT. <a href="https://simpap.my.id/public/">Sistem Manajemen Perusahan Arsip</a></p>
            <p>Di Tempat</p>
            <br>
           <p>Dengan hormat,</p>
<p>Yang bertanda tangan di bawah ini:</p>
<p><strong>Nama Lengkap</strong>: {{ $name ?? 'Tidak Ada Data' }}</p>
<p><strong>Email</strong>: {{ $email ?? 'Tidak Ada Data' }}</p>

<p>Dengan ini mengajukan permohonan cuti:</p>
<p class="indent-text">
    <span class="label-cuti">Selama</span>:
    <span class="value-cuti">
        {{ isset($start_date) && isset($end_date) ? \Carbon\Carbon::parse($start_date)->diffInDays(\Carbon\Carbon::parse($end_date)) + 1 : '...' }} hari
    </span>
</p>
<p class="indent-text">
    <span class="label-cuti">Terhitung mulai tanggal</span>:
    <span class="value-cuti">
        <strong>{{ isset($start_date) ? \Carbon\Carbon::parse($start_date)->translatedFormat('d F Y') : '...' }}</strong>
    </span>
</p>
<p class="indent-text">
    <span class="label-cuti">Sampai dengan tanggal</span>:
    <span class="value-cuti">
        <strong>{{ isset($end_date) ? \Carbon\Carbon::parse($end_date)->translatedFormat('d F Y') : '...' }}</strong>.
    </span>
</p>

            <p>Adapun alasan pengambilan cuti adalah sebagai berikut:</p>
            <p>{{ $reason ?? 'Tidak Ada Data' }}</p>

            <p>Demikian surat permohonan cuti ini saya ajukan. Atas perhatian dan persetujuan Bapak/Ibu, saya ucapkan terima kasih.</p>
        </div>

        <div class="signature-section">
            <div class="signature-block" style="float: right; text-align: center;">
                <p>Hormat saya,</p>
            
                <img src="{!! $qr_code !!}" width="150" alt="QR Code Profil">
                <p>( {{ $name ?? 'Nama Pemohon' }} )</p>
            </div>
            <div style="clear: both;"></div>
        </div>

    </div>
</body>
</html>