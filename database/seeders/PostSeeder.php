<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\User;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        $userId = $user ? $user->id : null;

        $posts = [
            [
                'user_id' => $userId,
                'title' => 'Panduan Lengkap Wisata Kuliner dan Sejarah Cirebon 2026',
                'slug' => 'panduan-lengkap-wisata-kuliner-sejarah-cirebon',
                'category' => 'Wisata Cirebon',
                'focus_keyword' => 'wisata cirebon',
                'seo_title' => 'Panduan Wisata Cirebon Terbaik: Kuliner & Destinasi',
                'meta_description' => 'Jelajahi panduan wisata Cirebon terlengkap! Temukan kuliner khas empal gentong, sejarah Keraton Kasepuhan, dan rute perjalanan hemat serta nyaman.',
                'canonical_url' => null,
                'seo_score' => 'good',
                'readability_score' => 'good',
                'is_indexed' => true,
                'image' => 'https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?auto=format&fit=crop&w=1200&q=80',
                'image_alt' => 'Pesona destinasi wisata cirebon dan keindahan keraton bersejarah',
                'image_caption' => 'Keindahan Keraton Kasepuhan, salah satu destinasi sejarah ikonik Cirebon.',
                'excerpt' => 'Menikmati liburan akhir pekan di Cirebon kini semakin mudah dengan beragam rute kuliner autentik dan napak tilas sejarah Kesultanan.',
                'content' => '<h2>Mengenal Pesona Wisata Cirebon yang Kaya Budaya</h2>
<p>Kota Cirebon menyimpan pesona magis perpaduan tradisi Jawa, Sunda, Tionghoa, dan Arab. Bagi wisatawan yang merencanakan liburan, <strong>wisata cirebon</strong> menawarkan paket lengkap mulai dari arsitektur kesultanan, batik trusmi legendaris, hingga petualangan rasa yang memanjakan lidah.</p>

<h3>1. Napak Tilas Tiga Keraton Bersejarah</h3>
<p>Kunjungan ke Cirebon tidak lengkap tanpa menyusuri kemegahan keraton. Anda dapat mengagumi peninggalan bersejarah di Keraton Kasepuhan yang didirikan sejak abad ke-15, menyaksikan kereta kencana Singa Barong, lalu melanjutkan perjalanan ke Keraton Kanoman dan Keraton Kacirebonan. Kompleks keraton ini mudah dijangkau kendaraan roda empat dengan area parkir yang memadai.</p>

<h3>2. Eksplorasi Keunikan Gua Sunyaragi</h3>
<p>Taman Air Gua Sunyaragi menyuguhkan formasi batu karang laut yang disusun membentuk gua pertapaan dan benteng pertahanan para sultan terdahulu. Spot ini menjadi favorit fotografer berkat latar belakang batuan purba yang eksotis dan sarat nilai filosofis.</p>

<h2>Daftar Kuliner Wajib Saat Berwisata di Cirebon</h2>
<p>Setelah puas berkeliling objek sejarah, saatnya memanjakan selera kuliner khas Cirebon:</p>
<ul>
    <li><strong>Empal Gentong Mang Darma & H. Apud:</strong> Daging sapi empuk dengan kuah santan bumbu kuning yang gurih dimasak dalam gentong tanah liat.</li>
    <li><strong>Nasi Jamblang Ibu Nur:</strong> Nasi bungkus daun jati dengan aneka lauk istimewa seperti cumi saus hitam, perkedel, paru goreng krispi, dan sambal cabai merah iris.</li>
    <li><strong>Tahu Gejrot Kanoman:</strong> Camilan tahu goreng kopong yang disiram kuah asam manis pedas gula merah dan bawang ulek segar.</li>
</ul>

<h2>Tips Mobilitas Nyaman Mengelilingi Cirebon</h2>
<p>Jarak antar destinasi di Cirebon dan sekitarnya (seperti Kuningan dan Majalengka) sangat ideal ditempuh dengan kendaraan roda empat. Menyewa mobil lepas kunci atau dengan supir lokal di RentGo Cirebon adalah solusi cerdas untuk menghemat waktu serta menikmati perjalanan dengan kenyamanan maksimal bersama keluarga tercinta.</p>',
                'status' => 'published',
                'published_at' => now()->subDays(12),
                'reading_time' => 4,
                'views_count' => 542,
            ],
            [
                'user_id' => $userId,
                'title' => 'Tips Memilih Rental Mobil Lepas Kunci di Stasiun Cirebon',
                'slug' => 'tips-memilih-rental-mobil-lepas-kunci-stasiun-cirebon',
                'category' => 'Tips Rental',
                'focus_keyword' => 'rental mobil cirebon',
                'seo_title' => 'Tips Rental Mobil Cirebon Lepas Kunci di Stasiun',
                'meta_description' => 'Simak tips memilih jasa rental mobil Cirebon lepas kunci saat tiba di stasiun. Dapatkan armada terawat, syarat praktis, dan tarif transparan.',
                'canonical_url' => null,
                'seo_score' => 'good',
                'readability_score' => 'good',
                'is_indexed' => true,
                'image' => 'https://images.unsplash.com/photo-1549399542-7e3f8b79c341?auto=format&fit=crop&w=1200&q=80',
                'image_alt' => 'Tips memilih rental mobil cirebon lepas kunci di stasiun kereta api',
                'image_caption' => 'Armada mobil prima siap diantar langsung ke Stasiun Kejaksan Cirebon.',
                'excerpt' => 'Tiba di Stasiun Cirebon menggunakan kereta api dan ingin langsung melanjutkan mobilitas? Berikut panduan praktis sewa mobil tanpa ribet.',
                'content' => '<h2>Mengapa Memilih Rental Mobil Cirebon Saat Tiba di Stasiun?</h2>
<p>Bagi pelancong bisnis maupun wisatawan keluarga, moda transportasi kereta api ke Stasiun Kejaksan atau Stasiun Prujakan adalah pilihan favorit. Begitu tiba, memiliki armada pribadi dari penyedia <strong>rental mobil cirebon</strong> terpercaya memberi Anda fleksibilitas rute tanpa harus bergantung pada transportasi umum.</p>

<h3>1. Pastikan Legalitas dan Reputasi Penyedia Rental</h3>
<p>Jangan mudah tergiur harga murah yang tidak realistis. Pilihlah rental mobil yang memiliki alamat kantor fisik jelas, armada berpelat nomor resmi, dan ulasan pelanggan bintang lima. Layanan profesional selalu mengutamakan keselamatan dan transparansi kontrak.</p>

<h3>2. Cek Kebijakan Syarat Lepas Kunci</h3>
<p>Rental mobil lepas kunci umumnya memerlukan beberapa dokumen validasi untuk keamanan kedua pihak, seperti:</p>
<ul>
    <li>KTP asli & SIM A yang masih berlaku.</li>
    <li>Bukti tiket kedatangan kereta api atau reservasi hotel.</li>
    <li>Akun media sosial aktif untuk verifikasi identitas kilat.</li>
</ul>

<h3>3. Lakukan Inspeksi Fisik Bersama Saat Serah Terima</h3>
<p>Saat staf rental mengantarkan unit ke stasiun, lakukan pemeriksaan bersama: cek kondisi bodi mobil, tingkat kebersihan kabin, level bahan bakar, indikator dashboard, serta fungsi rem dan AC. Dokumentasikan foto atau video singkat sebelum menandatangani form serah terima unit.</p>

<h2>Keunggulan Antar Jemput Stasiun dari RentGo Indonesia</h2>
<p>RentGo Cirebon menyediakan fasilitas gratis antar-jemput unit langsung di area parkir stasiun kereta api Cirebon. Dengan armada yang selalu melalui inspeksi 21 titik dan steril sebelum diserahkan, Anda bisa langsung memulai petualangan tanpa hambatan.</p>',
                'status' => 'published',
                'published_at' => now()->subDays(8),
                'reading_time' => 3,
                'views_count' => 418,
            ],
            [
                'user_id' => $userId,
                'title' => 'Destinasi Wisata Alam Kuningan Dekat Kaki Gunung Ciremai',
                'slug' => 'destinasi-wisata-alam-kuningan-kaki-gunung-ciremai',
                'category' => 'Wisata Cirebon',
                'focus_keyword' => 'wisata kuningan ciremai',
                'seo_title' => 'Wisata Kuningan Ciremai: Surga Alam Dekat Cirebon',
                'meta_description' => 'Temukan pesona wisata Kuningan Ciremai dengan udara sejuk pegunungan, curug jernih, dan telaga biru. Akses mudah dari Cirebon hanya 45 menit!',
                'canonical_url' => null,
                'seo_score' => 'good',
                'readability_score' => 'good',
                'is_indexed' => true,
                'image' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1200&q=80',
                'image_alt' => 'Eksotisme wisata kuningan ciremai dan pemandangan asri pegunungan',
                'image_caption' => 'Pemandangan hijau kaki Gunung Ciremai yang menyegarkan pikiran.',
                'excerpt' => 'Hanya berjarak 45 menit berkendara dari pusat Kota Cirebon, Kabupaten Kuningan menyajikan panorama pegunungan yang asri dan sejuk.',
                'content' => '<h2>Pesona Udara Sejuk di Kaki Gunung Tertinggi Jawa Barat</h2>
<p>Jika Anda merasa suasana kota sedang terik, mengambil rute ke arah selatan menuju Kabupaten Kuningan adalah pelarian sempurna. Kawasan <strong>wisata kuningan ciremai</strong> menawarkan kesegaran hutan pinus, air terjun alami, dan deretan kafe berkonsep alam dengan latar Gunung Ciremai yang megah.</p>

<h3>1. Telaga Biru Cicerem (Danau Sebening Kaca)</h3>
<p>Terkenal sebagai danau alami dengan air biru jernih yang dihuni ribuan ikan mas hias. Pengunjung dapat berfoto di atas ayunan tepi danau atau menaiki perahu dayung kayu sambil memberi makan ikan.</p>

<h3>2. Curug Putri & Wisata Palutungan</h3>
<p>Bagi pencinta hawa dingin dan aroma cemara, Palutungan menawarkan Curug Putri dengan debit air melimpah dan spot berkemah keluarga. Di sepanjang jalur Palutungan, banyak restoran keluarga dengan pemandangan lembah Cirebon dari ketinggian.</p>

<h3>3. Gedung Perundingan Linggarjati</h3>
<p>Selain alam, Kuningan menyimpan nilai sejarah kemerdekaan Indonesia. Di Linggarjati, Anda dapat melihat tempat berlangsungnya perjanjian diplomasi bersejarah antara delegasi Indonesia dan Belanda dalam bangunan era kolonial yang terawat apik.</p>

<h2>Rekomendasi Mobil yang Tepat untuk Rute Menanjak</h2>
<p>Kontur jalan Kuningan didominasi tanjakan dan kelokan perbukitan. Kendaraan seperti Toyota Innova Zenix, Toyota Fortuner, atau Mitsubishi Pajero Sport yang memiliki torsi mesin mumpuni sangat direkomendasikan agar perjalanan tetap halus dan bertenaga.</p>',
                'status' => 'published',
                'published_at' => now()->subDays(4),
                'reading_time' => 4,
                'views_count' => 312,
            ],
            [
                'user_id' => $userId,
                'title' => 'Panduan Perawatan Mobil Transmisi Otomatis untuk Perjalanan Jauh',
                'slug' => 'panduan-perawatan-mobil-transmisi-otomatis-perjalanan-jauh',
                'category' => 'Panduan Otomotif',
                'focus_keyword' => 'perawatan mobil matic',
                'seo_title' => 'Panduan Perawatan Mobil Matic Sebelum Road Trip Jauh',
                'meta_description' => 'Ikuti panduan perawatan mobil matic agar performa transmisi tetap prima saat perjalanan jauh. Cek oli matic, sistem pendingin, dan rem.',
                'canonical_url' => null,
                'seo_score' => 'good',
                'readability_score' => 'good',
                'is_indexed' => true,
                'image' => 'https://images.unsplash.com/photo-1486006920555-c77dce18193b?auto=format&fit=crop&w=1200&q=80',
                'image_alt' => 'Pemeriksaan mesin dan panduan perawatan mobil matic untuk perjalanan aman',
                'image_caption' => 'Teknisi profesional RentGo rutin melakukan inspeksi 21 titik armada.',
                'excerpt' => 'Mobil bertransmisi otomatis memang nyaman dikemudikan saat macet maupun di tol. Namun, pastikan beberapa komponen kunci ini dicek sebelum berangkat.',
                'content' => '<h2>Kenyamanan dan Tantangan Mengendarai Mobil Matic</h2>
<p>Popularitas mobil matik kian melambung berkat kemudahan pengoperasiannya di rute tol Cipali maupun kepadatan perkotaan. Kendati demikian, <strong>perawatan mobil matic</strong> membutuhkan perhatian khusus terutama pada temperatur oli transmisi dan gaya mengemudi saat menghadapi tanjakan panjang.</p>

<h3>1. Periksa Kualitas dan Volume Oli Transmisi (ATF/CVT)</h3>
<p>Oli transmisi berfungsi melumasi sekaligus menyalurkan tekanan hidrolis. Pastikan warna oli masih merah bening atau amber terang, tidak berbau gosong, dan berada pada level garis HOT saat mesin mencapai suhu kerja optimal.</p>

<h3>2. Jangan Biarkan Rem Bekerja Terlalu Berat di Turunan</h3>
<p>Banyak pengemudi pemula hanya mengandalkan pedal rem saat menuruni bukit. Pada transmisi matik, geser tuas ke posisi L, 2, atau gunakan fitur paddle shift/manual mode untuk mendapatkan efek <em>engine brake</em> agar rem tidak mengalami <em>brake fade</em> (rem blong akibat panas berlebih).</p>

<h3>3. Periksa Kondisi Radiator dan Sistem Pendingin Mesin</h3>
<p>Pada sebagian besar mobil, pendingin oli matic terintegrasi dengan radiator bagian bawah. Kebocoran atau coolant yang kotor bisa memicu overheat pada mesin maupun gearbox.</p>

<h2>Standar Perawatan Ketat di RentGo Indonesia</h2>
<p>Seluruh armada kami, mulai dari Toyota Avanza hingga Alphard, menjalani perawatan berkala di bengkel resmi serta pembersihan kabin secara higienis sebelum dilepas ke penyewa. Anda tak perlu khawatir soal kendala mekanis di perjalanan!</p>',
                'status' => 'published',
                'published_at' => now()->subDay(),
                'reading_time' => 3,
                'views_count' => 195,
            ],
            [
                'user_id' => $userId,
                'title' => 'Wisata Kuliner Cirebon Malam Hari: 5 Lokasi Legendaris Paling Ramai',
                'slug' => 'wisata-kuliner-cirebon-malam-hari-lokasi-legendaris',
                'category' => 'Wisata Cirebon',
                'focus_keyword' => 'wisata cirebon',
                'seo_title' => 'Kuliner Malam Cirebon Legendaris yang Wajib Dicoba',
                'meta_description' => 'Jelajahi kelezatan wisata kuliner Cirebon malam hari. Dari nasi lengko legendaris hingga empal gentong buka 24 jam untuk memuaskan rasa lapar.',
                'canonical_url' => null,
                'seo_score' => 'good',
                'readability_score' => 'good',
                'is_indexed' => true,
                'image' => 'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?auto=format&fit=crop&w=1200&q=80',
                'image_alt' => 'Wisata kuliner cirebon malam hari dan aneka hidangan lezat khas kesultanan',
                'image_caption' => 'Suasana santap malam santai dengan cita rasa otentik khas Cirebon.',
                'excerpt' => 'Menjelang malam, Kota Cirebon bertransformasi menjadi surga kuliner malam yang menggoda selera dengan sajian khas yang buka hingga dini hari.',
                'content' => '<h2>Pesona Wisata Cirebon di Malam Hari</h2><p>Bagi Anda pecinta kuliner malam, <strong>wisata cirebon</strong> menyuguhkan keunikan rasa yang tak pernah tidur. Banyak kedai legendaris justru baru menyalakan api tungku saat senja berganti petang.</p><h3>1. Nasi Jamblang Mang Dul</h3><p>Berlokasi tepat di seberang Mall Grage, kedai ini menyajikan puluhan lauk pauk khas di atas daun jati hangat hingga tengah malam.</p><h3>2. Empal Gentong Mang Darma Pusat</h3><p>Rasa gurih daging sapi empuk dengan bumbu rempah kuning yang kaya cocok dinikmati saat udara malam Cirebon mulai sejuk.</p>',
                'status' => 'published',
                'published_at' => now()->subHours(18),
                'reading_time' => 3,
                'views_count' => 280,
            ],
            [
                'user_id' => $userId,
                'title' => 'Eksplorasi Keindahan Majalengka: Terasering Panyaweuyan & Curug Cipeuteuy',
                'slug' => 'eksplorasi-keindahan-majalengka-terasering-panyaweuyan',
                'category' => 'Wisata Cirebon',
                'focus_keyword' => 'wisata majalengka',
                'seo_title' => 'Wisata Majalengka Panyaweuyan: Rute Indah dari Cirebon',
                'meta_description' => 'Rute wisata Majalengka terasering Panyaweuyan dan curug eksotis. Hanya 1 jam perjalanan santai dari Kota Cirebon menggunakan rental mobil prima.',
                'canonical_url' => null,
                'seo_score' => 'good',
                'readability_score' => 'good',
                'is_indexed' => true,
                'image' => 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=1200&q=80',
                'image_alt' => 'Hamparan hijau terasering panyaweuyan destinasi wisata majalengka',
                'image_caption' => 'Terasering daun bawang Panyaweuyan nan memanjakan mata di pagi hari.',
                'excerpt' => 'Menikmati hawa sejuk perbukitan Majalengka dengan hamparan daun bawang hijau nan fotogenik serta gemericik curug alami berhawa dingin.',
                'content' => '<h2>Pesona Alam Majalengka Dekat Cirebon</h2><p>Wilayah <strong>wisata majalengka</strong> kini menjadi primadona baru pariwisata Jawa Barat. Akses jalan yang semakin mulus memudahkan mobilitas wisatawan dari arah Cirebon.</p><h3>1. Terasering Lembah Panyaweuyan</h3><p>Pemandangan kontur sawah berundak di lereng Gunung Ciremai menyajikan gradasi hijau mempesona saat fajar merekah.</p>',
                'status' => 'published',
                'published_at' => now()->subHours(12),
                'reading_time' => 4,
                'views_count' => 340,
            ],
            [
                'user_id' => $userId,
                'title' => 'Keuntungan Sewa Mobil Plus Supir untuk Wisata Keluarga di Cirebon',
                'slug' => 'keuntungan-sewa-mobil-plus-supir-wisata-keluarga',
                'category' => 'Tips Rental',
                'focus_keyword' => 'rental mobil cirebon',
                'seo_title' => 'Keuntungan Rental Mobil Cirebon Plus Driver Handal',
                'meta_description' => 'Nikmati liburan bebas lelah dengan rental mobil Cirebon plus driver berpengalaman. Driver lokal hafal rute pintas, parkir mudah, dan kuliner tersembunyi.',
                'canonical_url' => null,
                'seo_score' => 'good',
                'readability_score' => 'good',
                'is_indexed' => true,
                'image' => 'https://images.unsplash.com/photo-1449965408869-eaa3f722e40d?auto=format&fit=crop&w=1200&q=80',
                'image_alt' => 'Kenyamanan perjalanan wisata keluarga bersama rental mobil cirebon plus driver',
                'image_caption' => 'Driver ramah dan profesional siap memandu perjalanan keluarga Anda.',
                'excerpt' => 'Rencanakan liburan keluarga tanpa rasa letih di balik kemudi. Ketahui mengapa opsi sewa mobil dengan supir lokal profesional jauh lebih menyenangkan.',
                'content' => '<h2>Mengapa Memilih Driver Lokal?</h2><p>Saat berlibur bersama keluarga, memilih <strong>rental mobil cirebon</strong> dengan supir memberikan kenyamanan maksimal. Anda bisa fokus menikmati momen kebersamaan tanpa stres menghadapi kepadatan lalu lintas kota.</p>',
                'status' => 'published',
                'published_at' => now()->subHours(6),
                'reading_time' => 3,
                'views_count' => 410,
            ],
            [
                'user_id' => $userId,
                'title' => 'Rute Road Trip Tol Cipali: Tips Istirahat Nyaman Menuju Cirebon',
                'slug' => 'rute-road-trip-tol-cipali-tips-istirahat-nyaman',
                'category' => 'Panduan Otomotif',
                'focus_keyword' => 'sewa mobil cirebon',
                'seo_title' => 'Panduan Road Trip Tol Cipali ke Cirebon Aman & Nyaman',
                'meta_description' => 'Tips road trip tol Cipali menuju Cirebon. Rekomendasi rest area terbaik, pengecekan tekanan ban, dan istirahat teratur demi keselamatan berkendara.',
                'canonical_url' => null,
                'seo_score' => 'good',
                'readability_score' => 'good',
                'is_indexed' => true,
                'image' => 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?auto=format&fit=crop&w=1200&q=80',
                'image_alt' => 'Pemandangan jalan tol dan kendaraan melaju dengan nyaman',
                'image_caption' => 'Laju mulus di Tol Cipali menyambut kedatangan Anda di Kota Cirebon.',
                'excerpt' => 'Perjalanan darat Jakarta-Cirebon kini hanya memakan waktu 2.5 hingga 3 jam lewat tol Cipali. Simak panduan rest area terbaik sepanjang perjalanan.',
                'content' => '<h2>Road Trip Nyaman Menuju Kota Udang</h2><p>Dengan hadirnya tol Cipali, mobilitas menggunakan <strong>sewa mobil cirebon</strong> semakin diminati. Pastikan pengemudi bergantian istirahat setiap 2 jam berkendara demi keselamatan bersama.</p>',
                'status' => 'published',
                'published_at' => now()->subHours(2),
                'reading_time' => 3,
                'views_count' => 175,
            ]
        ];

        foreach ($posts as $data) {
            Post::updateOrCreate(
                ['slug' => $data['slug']],
                $data
            );
        }
    }
}
