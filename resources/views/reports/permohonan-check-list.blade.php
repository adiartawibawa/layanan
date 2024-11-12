<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        @media print {
            .container {
                max-width: 100%;
            }

            .background-logo {
                opacity: 0.1;
            }

            /* Menurunkan opasitas logo saat dicetak */
            .footer {
                position: fixed;
                bottom: 0;
                width: 100%;
            }
        }

        /* Background Watermark Styling */
        body {
            position: relative;
        }

        .background-logo {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: -1;
            opacity: 0.1;
            width: 500px;
            /* Atur ukuran logo sesuai kebutuhan */
            height: auto;
        }
    </style>
</head>

<body class="bg-white text-gray-800 relative">

    <!-- Logo sebagai watermark -->
    <img src="https://upload.wikimedia.org/wikipedia/commons/d/d2/Lambang_Kabupaten_Badung.png" alt="Logo Instansi"
        class="background-logo">

    <!-- Container -->
    <div class="container mx-auto p-8 relative">
        <!-- Logo Instansi -->
        <div class="flex items-center justify-center border-gray-200 border-b mb-4">
            <div class="text-center mb-4">
                <h1 class="text-2xl font-bold uppercase">Kelengkapan Dokumen</h1>
                <h2 class="text-lg font-semibold uppercase">Layanan Legalisir Raport</h2>
            </div>
        </div>

        <!-- Informasi Layanan -->
        <div class="mb-8 space-y-2">
            <div class="flex">
                <div class="w-1/4 font-bold uppercase">Kode Layanan</div>
                <div class="w-3/4 italic font-semibold">: LGL-RPT-2341</div>
            </div>
            <div class="flex">
                <div class="w-1/4 font-bold uppercase">ID Permohonan</div>
                <div class="w-3/4 italic font-semibold">: 9c8f5cc9-4270-4683-9072-df8b71fcbe7b</div>
            </div>
            <div class="flex">
                <div class="w-1/4 font-bold uppercase">Nama Pemohon</div>
                <div class="w-3/4 italic font-semibold">: I Gede Made Adi Arta Wibawa</div>
            </div>
            <div class="flex">
                <div class="w-1/4 font-bold uppercase">Waktu Pengajuan</div>
                <div class="w-3/4 italic font-semibold">: 01 November 2024</div>
            </div>
            <div class="flex">
                <div class="w-1/4 font-bold uppercase">Waktu Selesai Diperiksa</div>
                <div class="w-3/4 italic font-semibold">: 03 November 2024</div>
            </div>
        </div>

        <!-- Checklist Prasyarat -->
        <h2 class="text-xl font-semibold mb-4">Kelengkapan Prasyarat</h2>
        <table class="w-full mb-8 border border-gray-300">
            <thead>
                <tr>
                    <th class="px-4 py-2 border-b text-left font-medium">Jenis Dokumen</th>
                    <th class="px-4 py-2 border-b text-left font-medium">Keterangan</th>
                    <th class="px-4 py-2 border-b text-center font-medium">Checklist</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="px-4 py-2 border-b">Nama</td>
                    <td class="px-4 py-2 border-b">Adi Arta Wibawa</td>
                    <td class="px-4 py-2 border-b text-center"><input type="checkbox" class="form-checkbox h-5 w-5">
                    </td>
                </tr>
                <tr>
                    <td class="px-4 py-2 border-b">Alamat</td>
                    <td class="px-4 py-2 border-b">Puri Ayodya</td>
                    <td class="px-4 py-2 border-b text-center"><input type="checkbox" class="form-checkbox h-5 w-5">
                    </td>
                </tr>
                <tr>
                    <td class="px-4 py-2 border-b">Tanggal Lahir</td>
                    <td class="px-4 py-2 border-b">2012-12-09</td>
                    <td class="px-4 py-2 border-b text-center"><input type="checkbox" class="form-checkbox h-5 w-5">
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Checklist Formulir -->
        <h2 class="text-xl font-semibold mb-4">Kelengkapan Formulir</h2>
        <table class="w-full border border-gray-300">
            <thead>
                <tr>
                    <th class="px-4 py-2 border-b text-left font-medium">Jenis Dokumen</th>
                    <th class="px-4 py-2 border-b text-left font-medium">Keterangan</th>
                    <th class="px-4 py-2 border-b text-center font-medium">Checklist</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="px-4 py-2 border-b">Scan Dokumen</td>
                    <td class="px-4 py-2 border-b">Note</td>
                    <td class="px-4 py-2 border-b text-center"><input type="checkbox" class="form-checkbox h-5 w-5">
                    </td>
                </tr>
                <tr>
                    <td class="px-4 py-2 border-b">Foto Diri</td>
                    <td class="px-4 py-2 border-b">Foto diri pemohon dengan dokumen. Note</td>
                    <td class="px-4 py-2 border-b text-center"><input type="checkbox" class="form-checkbox h-5 w-5">
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Penerima Section -->
        <div class="mt-8">
            <h2 class="text-xl font-semibold mb-4">Penerima Dokumen</h2>
            <div class="flex justify-between">
                <div>
                    <p class="font-semibold">Nama Penerima:</p>
                    <p class="italic">...........................</p>
                </div>
                <div>
                    <p class="font-semibold">Tanggal:</p>
                    <p class="italic">...........................</p>
                </div>
                <div>
                    <p class="font-semibold">Tanda Tangan:</p>
                    <p class="italic">...........................</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer dengan Footnote dan QR Code -->
    <div class="footer flex justify-between items-center px-8 py-4 border-t border-gray-300">
        <div class="text-sm text-gray-600">
            <p>Tanggal Cetak checklist: {{ tanggal_cetak }}</p>
            <p>Nama Aplikasi: Kawitan</p>
            <p>Dinas Pendidikan Kabupaten Badung</p>
        </div>
        <!-- QR Code ID Permohonan -->
        <div>
            <img src="https://chart.googleapis.com/chart?chs=150x150&cht=qr&chl=9c8f5cc9-4270-4683-9072-df8b71fcbe7b"
                alt="QR Code ID Permohonan" class="w-24 h-24">
        </div>
    </div>

</body>

</html>
