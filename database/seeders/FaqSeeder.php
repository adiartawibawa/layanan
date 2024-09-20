<?php

namespace Database\Seeders;

use App\Models\Faq;
use App\Models\FaqCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Membuat kategori FAQ
        $categories = [
            ['name' => 'Layanan'],
            ['name' => 'Penggunaan Aplikasi'],
            ['name' => 'Peta Sebaran Sekolah'],
        ];

        // Insert ke dalam tabel faq_categories
        foreach ($categories as $category) {
            FaqCategory::create($category);
        }

        // Ambil kategori
        $layanan = FaqCategory::where('name', 'Layanan')->first();
        $penggunaanAplikasi = FaqCategory::where('name', 'Penggunaan Aplikasi')->first();
        $petaSebaranSekolah = FaqCategory::where('name', 'Peta Sebaran Sekolah')->first();

        // Pertanyaan dan jawaban untuk kategori Layanan
        Faq::create([
            'faq_category_id' => $layanan->id,
            'question' => 'Bagaimana cara legalisir ijazah?',
            'answer' => 'Untuk mengajukan legalisir ijazah, Anda dapat mengunjungi halaman legalisir di website ini atau datang langsung ke kantor Dinas Pendidikan dengan membawa ijazah asli dan fotokopinya. Layanan ini juga bisa dilakukan secara online dengan mengunggah dokumen yang diperlukan.'
        ]);

        Faq::create([
            'faq_category_id' => $layanan->id,
            'question' => 'Bagaimana cara memperpanjang izin operasional sekolah?',
            'answer' => 'Untuk memperpanjang izin operasional sekolah, Anda perlu mengajukan permohonan melalui sistem online di website ini. Pastikan semua dokumen yang diperlukan sudah diunggah sesuai panduan yang ada. Setelah pengajuan, permohonan akan diverifikasi oleh petugas terkait.'
        ]);

        Faq::create([
            'faq_category_id' => $layanan->id,
            'question' => 'Apakah legalisir rapor bisa dilakukan secara online?',
            'answer' => 'Ya, legalisir rapor bisa dilakukan secara online. Silakan unggah dokumen rapor yang ingin dilegalisir melalui portal legalisir di website ini, dan dokumen yang sudah dilegalisir akan dikirimkan kepada Anda setelah diverifikasi oleh pihak Dinas Pendidikan.'
        ]);

        Faq::create([
            'faq_category_id' => $layanan->id,
            'question' => 'Apakah saya perlu datang langsung untuk mengambil dokumen yang sudah dilegalisir?',
            'answer' => 'Tidak perlu, dokumen yang sudah dilegalisir bisa dikirimkan melalui layanan pengiriman ke alamat Anda. Namun, jika Anda ingin mengambilnya langsung, Anda juga bisa datang ke kantor Dinas Pendidikan pada jam kerja.'
        ]);

        Faq::create([
            'faq_category_id' => $layanan->id,
            'question' => 'Bagaimana cara mendapatkan surat rekomendasi pindah sekolah?',
            'answer' => 'Untuk mendapatkan surat rekomendasi pindah sekolah, ajukan permohonan melalui halaman layanan pindah sekolah di website ini. Sertakan dokumen pendukung seperti surat permohonan dan data siswa. Permohonan akan diproses oleh petugas setelah semua persyaratan dipenuhi.'
        ]);

        Faq::create([
            'faq_category_id' => $layanan->id,
            'question' => 'Bagaimana cara mengajukan izin mendirikan sekolah baru?',
            'answer' => 'Untuk mendirikan sekolah baru, Anda perlu melengkapi persyaratan administratif seperti rencana pembangunan, tenaga pengajar, dan fasilitas yang tersedia. Pengajuan dapat dilakukan melalui sistem online di website ini dan akan diverifikasi oleh pihak terkait.'
        ]);

        // Pertanyaan dan jawaban untuk kategori Penggunaan Aplikasi
        Faq::create([
            'faq_category_id' => $penggunaanAplikasi->id,
            'question' => 'Bagaimana cara mendaftar akun di aplikasi layanan?',
            'answer' => 'Untuk mendaftar di aplikasi layanan ini, klik tombol "Daftar" di halaman utama, lalu lengkapi form pendaftaran dengan data yang valid seperti nama, email, dan kata sandi. Setelah itu, Anda akan menerima email konfirmasi untuk mengaktifkan akun Anda.'
        ]);

        Faq::create([
            'faq_category_id' => $penggunaanAplikasi->id,
            'question' => 'Apakah saya bisa mengakses layanan tanpa akun?',
            'answer' => 'Beberapa layanan dapat diakses tanpa akun, seperti peta sebaran sekolah dan statistik umum. Namun, untuk layanan yang memerlukan pengajuan dokumen, seperti legalisir atau perpanjangan izin, Anda harus membuat akun terlebih dahulu.'
        ]);

        Faq::create([
            'faq_category_id' => $penggunaanAplikasi->id,
            'question' => ' Bagaimana cara mengubah informasi akun saya?',
            'answer' => 'Untuk mengubah informasi akun Anda, login terlebih dahulu ke aplikasi layanan, lalu buka bagian "Profil" di menu. Di sana, Anda dapat memperbarui data seperti nama, alamat, atau kata sandi.'
        ]);

        Faq::create([
            'faq_category_id' => $penggunaanAplikasi->id,
            'question' => 'Bagaimana cara mengajukan layanan melalui aplikasi?',
            'answer' => 'Setelah login, pilih layanan yang ingin Anda ajukan, seperti legalisir atau perpanjangan izin, melalui dashboard aplikasi. Lengkapi form yang disediakan dan unggah dokumen yang dibutuhkan. Status pengajuan Anda akan muncul di halaman riwayat layanan.'
        ]);

        Faq::create([
            'faq_category_id' => $penggunaanAplikasi->id,
            'question' => 'Apakah saya dapat memantau status pengajuan layanan?',
            'answer' => 'Ya, Anda dapat memantau status pengajuan layanan melalui dashboard akun Anda. Setiap perubahan status, seperti "Diproses", "Disetujui", atau "Ditolak", akan diperbarui di riwayat layanan Anda, dan Anda akan menerima notifikasi melalui email.'
        ]);

        Faq::create([
            'faq_category_id' => $penggunaanAplikasi->id,
            'question' => 'Bagaimana jika saya lupa kata sandi akun saya?',
            'answer' => 'Jika Anda lupa kata sandi, klik tombol "Lupa Kata Sandi" di halaman login. Masukkan email yang Anda gunakan untuk mendaftar, dan tautan untuk mereset kata sandi akan dikirimkan ke email Anda.'
        ]);

        Faq::create([
            'faq_category_id' => $penggunaanAplikasi->id,
            'question' => 'Apakah aplikasi ini dapat diakses melalui ponsel?',
            'answer' => 'Ya, aplikasi layanan ini sepenuhnya responsif dan dapat diakses melalui browser di perangkat ponsel atau tablet. Semua fitur yang tersedia di desktop juga dapat diakses melalui perangkat mobile.'
        ]);

        Faq::create([
            'faq_category_id' => $penggunaanAplikasi->id,
            'question' => 'Apakah saya akan dikenakan biaya untuk menggunakan aplikasi layanan ini?',
            'answer' => 'Penggunaan aplikasi layanan ini gratis untuk semua layanan yang disediakan oleh Dinas Pendidikan. Namun, jika Anda memilih untuk menggunakan layanan pengiriman untuk dokumen, Anda mungkin dikenakan biaya pengiriman.'
        ]);

        Faq::create([
            'faq_category_id' => $penggunaanAplikasi->id,
            'question' => 'Bagaimana cara menghubungi bantuan jika saya mengalami masalah dengan aplikasi?',
            'answer' => 'Jika Anda mengalami masalah saat menggunakan aplikasi, Anda dapat menghubungi tim dukungan melalui menu "Bantuan" di dashboard. Anda juga bisa mengirimkan email ke layanan bantuan dengan menyertakan deskripsi masalah yang dihadapi.'
        ]);

        // Pertanyaan dan jawaban untuk kategori Peta Sebaran Sekolah
        Faq::create([
            'faq_category_id' => $petaSebaranSekolah->id,
            'question' => 'Bagaimana cara mengakses peta sebaran sekolah di website ini?',
            'answer' => 'Untuk mengakses peta sebaran sekolah, kunjungi menu "Sekolah" yang ada di halaman utama. Anda akan diarahkan ke halaman yang menampilkan peta interaktif dengan lokasi sekolah di Kabupaten Badung.'
        ]);

        Faq::create([
            'faq_category_id' => $petaSebaranSekolah->id,
            'question' => 'Informasi apa saja yang dapat dilihat pada peta sebaran sekolah?',
            'answer' => 'Pada peta sebaran sekolah, Anda dapat melihat informasi seperti nama sekolah, alamat, jumlah siswa, jumlah guru, dan fasilitas yang tersedia di sekolah tersebut. Informasi ini dapat diakses dengan mengklik titik lokasi sekolah di peta.'
        ]);

        Faq::create([
            'faq_category_id' => $petaSebaranSekolah->id,
            'question' => 'Apakah saya bisa mencari sekolah tertentu di peta sebaran?',
            'answer' => 'Ya, Anda dapat menggunakan fitur pencarian di peta sebaran sekolah. Cukup masukkan nama sekolah atau lokasi yang ingin dicari, dan sistem akan menampilkan sekolah yang sesuai dengan pencarian Anda.'
        ]);

        Faq::create([
            'faq_category_id' => $petaSebaranSekolah->id,
            'question' => 'Bagaimana cara mengetahui sekolah terdekat dari lokasi saya?',
            'answer' => 'Peta sebaran sekolah memiliki fitur pencarian sekolah berdasarkan lokasi. Anda bisa mengaktifkan fitur ini untuk melihat sekolah-sekolah terdekat dari posisi Anda saat ini, lengkap dengan informasi jarak dan petunjuk arah.'
        ]);

        Faq::create([
            'faq_category_id' => $petaSebaranSekolah->id,
            'question' => 'Apakah peta sebaran sekolah ini menampilkan semua jenis sekolah?',
            'answer' => 'Peta sebaran sekolah ini menampilkan semua sekolah dasar yang ada di bawah pengawasan Dinas Pendidikan Kabupaten Badung. Untuk jenis sekolah lainnya, seperti SMP atau SMA, Anda dapat menggunakan peta sebaran yang disediakan oleh dinas terkait.'
        ]);

        Faq::create([
            'faq_category_id' => $petaSebaranSekolah->id,
            'question' => 'Apakah peta sebaran sekolah ini selalu diperbarui?',
            'answer' => 'Ya, peta sebaran sekolah ini diperbarui secara berkala oleh Dinas Pendidikan Kabupaten Badung untuk memastikan informasi yang disajikan selalu akurat dan terbaru, termasuk data jumlah siswa dan fasilitas sekolah.'
        ]);

        Faq::create([
            'faq_category_id' => $petaSebaranSekolah->id,
            'question' => 'Apakah saya bisa mengunduh data sekolah dari peta sebaran ini?',
            'answer' => 'Saat ini, peta sebaran sekolah hanya menampilkan informasi secara online. Namun, jika Anda membutuhkan data lebih lanjut, silakan hubungi Dinas Pendidikan untuk mendapatkan informasi yang lebih lengkap dan resmi.'
        ]);

        Faq::create([
            'faq_category_id' => $petaSebaranSekolah->id,
            'question' => 'Bagaimana cara memberikan laporan jika informasi di peta sebaran salah?',
            'answer' => 'Jika Anda menemukan kesalahan informasi di peta sebaran sekolah, Anda dapat melaporkannya melalui fitur "Laporkan Kesalahan" yang tersedia di halaman peta. Tim Dinas Pendidikan akan segera memverifikasi dan memperbaiki data yang salah.'
        ]);

        Faq::create([
            'faq_category_id' => $petaSebaranSekolah->id,
            'question' => 'Apakah peta sebaran sekolah dapat diakses melalui perangkat mobile?',
            'answer' => 'Ya, peta sebaran sekolah di website ini sepenuhnya responsif dan dapat diakses melalui perangkat mobile. Anda bisa melihat peta dan informasi sekolah dengan tampilan yang disesuaikan untuk ponsel dan tablet.'
        ]);

        Faq::create([
            'faq_category_id' => $petaSebaranSekolah->id,
            'question' => 'Apa yang harus dilakukan jika peta tidak muncul atau mengalami kendala?',
            'answer' => 'Jika peta sebaran tidak muncul atau mengalami kendala teknis, cobalah untuk menyegarkan halaman atau menggunakan browser yang berbeda. Jika masalah masih berlanjut, Anda dapat menghubungi layanan dukungan teknis di website ini.'
        ]);
    }
}
