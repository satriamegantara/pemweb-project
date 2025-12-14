<?php
session_start();
require_once '../config/koneksi.php';
require_once '../config/planets_helper.php';

if (!isset($_SESSION['username']) || !isset($_SESSION['role'])) {
    header("Location: ../auth/login.php");
    exit;
}

if ($_SESSION['role'] !== 'user') {
    header("Location: ../error.php");
    exit;
}

$planet_name = isset($_GET['planet']) ? htmlspecialchars($_GET['planet']) : 'sun';

// Ambil data planet dari database
$planet = getPlanetByName($koneksi, $planet_name);

// Jika planet tidak ditemukan, redirect ke planetarium
if (!$planet) {
    header("Location: planetarium.php");
    exit;
}

// Data sudah diambil dari database melalui getPlanetByName()
// Tidak perlu mapping lagi karena struktur sudah sama
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/icons/thumbnail.png" type="image/png">
    <title><?php echo htmlspecialchars($planet['english_name']); ?> - Galaxy Explorer</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/planetarium.css">
    <link rel="stylesheet" href="../assets/css/planet-detail.css">
</head>

<body>
    <div class="container login-page">
        <div class="bg"></div>
        'type' => 'Bintang',
        'image' => 'sun.png',
        'diameter' => '1,391,000 km',
        'mass' => '1.989 × 10³⁰ kg',
        'temperature' => '5,500°C (permukaan), 15 juta°C (inti)',
        'gravity' => '274 m/s² (28x Bumi)',
        'composition' => '73% Hydrogen, 25% Helium, 2% unsur lain',
        'age' => '4.6 miliar tahun',
        'rotation' => '25-35 hari (bervariasi berdasarkan latitude)',
        'description' => 'Matahari adalah bintang di pusat Tata Surya kita dan merupakan objek paling masif dalam sistem kita, mengandung 99.86% dari seluruh massa Tata Surya. Sebagai bola plasma panas yang dipanaskan oleh reaksi fusi nuklir di intinya, Matahari adalah sumber energi utama bagi semua kehidupan di Bumi dan semua planet dalam Tata Surya.',
        'history' => 'Matahari telah membentuk Tata Surya kami sekitar 4.6 miliar tahun yang lalu dari puing-puing awan molekuler raksasa. Dalam setiap detik, 600 juta ton hidrogen diubah menjadi helium melalui fusi nuklir, menghasilkan energi luar biasa yang memancar ke seluruh Tata Surya.',
        'facts' => [
            'Mengandung 99.86% dari seluruh massa Tata Surya',
            'Cahaya dari Matahari membutuhkan waktu 8 menit 20 detik untuk mencapai Bumi',
            'Umur Matahari sekitar 4.6 miliar tahun dan akan terus bersinar selama 5 miliar tahun lagi',
            'Diameter Matahari 109 kali lebih besar dari Bumi',
            'Suhu inti mencapai 15 juta derajat Celsius',
            'Matahari berputar lebih cepat di ekuator (25 hari) daripada di kutub (35 hari)',
            'Setiap detik, energi setara 100 miliar bom nuklir dihasilkan',
            'Badai Matahari dan flare dapat mengganggu komunikasi satelit di Bumi',
            'Medan magnet Matahari 1,000 kali lebih kuat dari Bumi',
            'Usia Matahari masih dalam pertengahan umurnya'
        ],
        'missions' => 'SOHO (Solar and Heliospheric Observatory), Parker Solar Probe, Hinode',
        'exploration' => 'Matahari telah dipelajari melalui berbagai teleskop dan satelit yang mengamati aktivitas Matahari, termasuk bintik Matahari, korona, dan angin Matahari. Parker Solar Probe telah menerima data paling dekat dari Matahari hingga saat ini.'
    ],
    'mercury' => [
        'name' => 'Merkurius',
        'english_name' => 'Mercury',
        'type' => 'Planet Terestrial',
        'image' => 'mercury.png',
        'diameter' => '4,879 km',
        'mass' => '3.285 × 10²³ kg',
        'distance' => '57.9 juta km dari Matahari',
        'temperature' => '-173°C (malam) hingga 427°C (siang)',
        'gravity' => '3.7 m/s² (0.38x Bumi)',
        'day_length' => '176 hari Bumi',
        'year_length' => '88 hari Bumi',
        'atmosphere' => 'Hampir tidak ada (exosphere)',
        'moons' => 'Tidak ada',
        'description' => 'Merkurius adalah planet terkecil dan terdekat dengan Matahari dalam Tata Surya kita. Dengan permukaan yang dipenuhi kawah mirip Bulan dan hampir tanpa atmosfer, Merkurius mengalami variasi suhu ekstrem yang paling besar di antara semua planet. Siang hari mencapai 427°C sedangkan malam mencapai -173°C, perbedaan 600°C!',
        'history' => 'Merkurius telah dikenal sejak zaman kuno sebagai "bintang pagi" atau "bintang sore" ketika terlihat di ufuk. Planet ini dinamai sesuai dewa pesan Romawi karena gerakannya yang cepat di langit. Para astronom telah mengamati Merkurius selama ribuan tahun, meskipun sulit untuk diamati karena selalu berada dekat dengan Matahari.',
        'facts' => [
            'Satu hari (176 hari Bumi) lebih panjang dari satu tahunnya (88 hari Bumi)',
            'Dinamai sesuai dewa pesan Romawi yang terkenal karena kecepatannya',
            'Memiliki inti besi yang mencakup 75% dari diameternya',
            'Kecepatan orbital 47 km/detik, tercepat di Tata Surya',
            'Permukaan penuh kawah akibat tumbukan asteroid selama 4 miliar tahun',
            'Tidak memiliki satelit alami atau bulan',
            'Medan magnetnya hanya 1% dari medan magnet Bumi',
            'Misi MESSENGER mengungkapkan ada es air di kawah kutub yang selalu dalam bayangan',
            'Variasi suhu mencapai 600°C antara siang dan malam',
            'Rotasinya sangat lambat - hampir selalu menunjukkan wajah yang sama ke Matahari'
        ],
        'missions' => 'Mariner 10, MESSENGER, BepiColombo',
        'exploration' => 'Merkurius telah dijelajahi oleh tiga misi: Mariner 10 (1974-1975), MESSENGER (2011-2015), dan BepiColombo (misi berkelanjutan sejak 2018). MESSENGER menemukan bukti es air yang mengejutkan di Planet paling panas ini.'
    ],
    'venus' => [
        'name' => 'Venus',
        'english_name' => 'Venus',
        'type' => 'Planet Terestrial',
        'image' => 'venus.png',
        'diameter' => '12,104 km',
        'mass' => '4.867 × 10²⁴ kg',
        'distance' => '108.2 juta km dari Matahari',
        'temperature' => '462°C (rata-rata, planet terpanas)',
        'gravity' => '8.87 m/s² (0.9x Bumi)',
        'day_length' => '243 hari Bumi (retrograde)',
        'year_length' => '225 hari Bumi',
        'atmosphere' => '96% CO₂, awan asam sulfat',
        'pressure' => '92 kali tekanan Bumi',
        'moons' => 'Tidak ada',
        'description' => 'Venus adalah planet terpanas di Tata Surya dengan suhu lebih tinggi dari Merkurius meskipun lebih jauh dari Matahari. Atmosfer tebal menciptakan efek rumah kaca ekstrem yang menjebak panas. Uniknya, Venus berputar mundur (retrograde) dan satu harinya (243 hari) lebih panjang dari satu tahunnya (225 hari).',
        'history' => 'Venus dinamai sesuai dewi cinta dan keindahan Romawi karena keindahannya di langit. Planet ini telah menarik perhatian astronom sejak zaman kuno. Pada era Uni Soviet, Venus menjadi target utama eksplorasi dengan program Venera yang melakukan lebih dari 10 pendaratan.',
        'facts' => [
            'Venus berputar mundur (retrograde) - satu-satunya planet besar dengan rotasi seperti ini',
            'Satu hari (243 hari) lebih panjang dari satu tahunnya (225 hari Bumi)',
            'Dijuluki "saudara kembar Bumi" karena ukuran dan komposisi yang hampir sama',
            'Tekanan atmosfer 92 kali Bumi (setara dengan berada 900m di bawah laut)',
            'Objek paling terang di langit malam setelah Bulan',
            'Tidak memiliki satelit alami',
            'Suhu permukaan cukup panas untuk melelehkan timah',
            'Hujan asam sulfat terjadi di atmosfer atas tetapi menguap sebelum mencapai permukaan',
            'Angin di atmosfer atas bergerak 60 kali lebih cepat dari rotasi planet',
            'Lebih dari 1,600 gunung berapi besar teridentifikasi di permukaannya'
        ],
        'missions' => 'Venera (Soviet), Mariner 2, Pioneer Venus, Magellan, Akatsuki',
        'exploration' => 'Venus telah dikunjungi oleh puluhan misi dari berbagai negara. Program Venera Uni Soviet melakukan 10 pendaratan yang berhasil di permukaan, satu-satunya yang mendarat di planet lain. Magellan menciptakan peta radar yang detail, dan Akatsuki (JAXA) saat ini mengorbit Venus untuk mempelajari atmosfernya.'
    ],
    'earth' => [
        'name' => 'Bumi',
        'english_name' => 'Earth',
        'type' => 'Planet Terestrial',
        'image' => 'earth.png',
        'diameter' => '12,742 km',
        'mass' => '5.972 × 10²⁴ kg',
        'distance' => '149.6 juta km dari Matahari (1 AU)',
        'temperature' => '-88°C hingga 58°C (rata-rata 15°C)',
        'gravity' => '9.8 m/s²',
        'day_length' => '24 jam',
        'year_length' => '365.25 hari',
        'atmosphere' => '78% N₂, 21% O₂, 1% lainnya',
        'moons' => '1 (Bulan)',
        'water_coverage' => '71% permukaan',
        'description' => 'Bumi adalah planet ketiga dari Matahari dan satu-satunya tempat di alam semesta yang diketahui mendukung kehidupan. Dengan kombinasi unik air cair, atmosfer pelindung yang kaya oksigen, medan magnet yang kuat, dan posisi ideal di zona layak huni, Bumi adalah rumah bagi jutaan spesies makhluk hidup dari mikroba hingga manusia.',
        'history' => 'Bumi terbentuk sekitar 4.54 miliar tahun yang lalu dari puing-puing cakram protoplanet. Selama jutaan tahun pertama, Bumi mengalami bombardmen asteroid yang intens. Setelah itu, Bumi berevolusi menjadi planet yang layak huni dengan munculnya kehidupan sederhana sekitar 3.8 miliar tahun yang lalu, diikuti evolusi organisme kompleks hingga manusia modern muncul sekitar 300,000 tahun yang lalu.',
        'facts' => [
            '71% permukaan ditutupi air (97% air asin laut, 3% air tawar)',
            'Atmosfer melindungi kehidupan dari radiasi berbahaya Matahari',
            'Rotasi Bumi melambat 17 milidetik per 100 tahun karena efek pasang surut Bulan',
            'Medan magnet melindungi dari angin Matahari dan radiasi kosmik',
            'Satu-satunya planet dengan lempeng tektonik aktif',
            'Titik tertinggi: Gunung Everest (8,849m), terendah: Palung Mariana (-10,994m)',
            'Memiliki lebih dari 8.7 juta spesies makhluk hidup',
            '70% oksigen dihasilkan oleh fitoplankton di lautan',
            'Inti Bumi sepanas permukaan Matahari (sekitar 5,500°C)',
            'Manusia telah mengorbit Bumi, mendarat di Bulan, dan mengirim probe ke seluruh Tata Surya'
        ],
        'missions' => 'Jutaan satelit mengorbit, ISS (International Space Station), Mars rovers (dari Bumi)',
        'exploration' => 'Bumi adalah planet yang paling banyak dieksplorasi karena merupakan rumah kita. Kami telah menjelajahi samudera, menembus gunung tertinggi, mencapai kutub, dan bahkan pergi ke luar angkasa dari planet ini. Jutaan satelit orbiting memonitor iklim, cuaca, dan komunikasi global.'
    ],
    'mars' => [
        'name' => 'Mars',
        'english_name' => 'Mars',
        'type' => 'Planet Terestrial',
        'image' => 'mars.png',
        'diameter' => '6,779 km',
        'mass' => '6.417 × 10²³ kg',
        'distance' => '227.9 juta km dari Matahari',
        'temperature' => '-140°C hingga 20°C (rata-rata -65°C)',
        'gravity' => '3.71 m/s² (0.38x Bumi)',
        'day_length' => '24.6 jam (sangat mirip Bumi)',
        'year_length' => '687 hari Bumi',
        'atmosphere' => '95% CO₂, sangat tipis (1% Bumi)',
        'moons' => '2 (Phobos & Deimos)',
        'description' => 'Mars dijuluki "Planet Merah" karena permukaan yang kaya akan oksida besi (karat). Dengan bukti kuat adanya air cair di masa lalu, Mars menjadi target utama eksplorasi dan kolonisasi manusia di masa depan. Planet ini memiliki musim, kutub es, badai debu skala planet, dan fitur geologi paling ekstrem di Tata Surya.',
        'history' => 'Mars telah menarik imajinasi manusia selama berabad-abad, dengan mitos tentang kehidupan di planet ini. Pada abad ke-19, astronom percaya melihat "kanal-kanal" di Mars. Eksplorasi modern dimulai dengan Mariner 4 (1965). Sekarang, lebih dari 50 misi telah dikirim ke Mars, dengan beberapa masih aktif.',
        'facts' => [
            'Dua bulan kecil: Phobos dan Deimos (kemungkinan asteroid yang tertangkap)',
            'Olympus Mons: gunung berapi tertinggi (21km, 2.5x Everest)',
            'Valles Marineris: ngarai terbesar (4,000km panjang, 7km dalam)',
            'Kutub es terbuat dari air beku dan CO₂ beku (dry ice)',
            'Badai debu dapat berlangsung berbulan-bulan dan menutupi seluruh planet',
            'Jejak sungai kuno dan danau menunjukkan air pernah mengalir',
            'Methane terdeteksi di atmosfer, kemungkinan dari aktivitas geologi atau mikroba',
            'Rover Curiosity dan Perseverance sedang menjelajahi dan mencari bukti kehidupan',
            'Hari Mars (sol) hanya 39 menit lebih panjang dari hari Bumi',
            'Calon destinasi pertama untuk koloni manusia'
        ],
        'missions' => 'Mariner 4, Viking 1-2, Pathfinder, Spirit, Opportunity, Curiosity, Perseverance, Ingenuity',
        'exploration' => 'Mars adalah planet paling banyak dikunjungi selain Bumi. Rover Curiosity telah menjelajahi sejak 2012, diikuti Perseverance sejak 2021 dengan drone Ingenuity. Semua misi robotik ini mencari tanda-tanda kehidupan masa lalu dan menilai kelayakan untuk kolonisasi manusia.'
    ],
    'jupiter' => [
        'name' => 'Jupiter',
        'english_name' => 'Jupiter',
        'type' => 'Gas Giant (Planet Raksasa Gas)',
        'image' => 'jupiter.png',
        'diameter' => '139,820 km',
        'mass' => '1.898 × 10²⁷ kg',
        'distance' => '778.5 juta km dari Matahari',
        'temperature' => '-108°C (rata-rata, puncak awan)',
        'gravity' => '24.8 m/s² (2.5x Bumi)',
        'day_length' => '10 jam (tercepat di Tata Surya)',
        'year_length' => '12 tahun Bumi',
        'atmosphere' => '90% H₂, 10% He, jejak CH₄, NH₃',
        'moons' => '95 (diketahui, termasuk 4 bulan Galilean)',
        'description' => 'Jupiter adalah planet terbesar dalam Tata Surya, dengan massa 2.5 kali lebih besar dari semua planet lain digabungkan. Sebagai gas giant, Jupiter terdiri dari hidrogen dan helium dengan kemungkinan inti berbatu. Fitur paling terkenal adalah Great Red Spot, badai antisiklon raksasa yang telah berlangsung setidaknya 400 tahun dan lebih besar dari Bumi sendiri.',
        'history' => 'Jupiter telah dikenal sejak zaman kuno dan dinamai sesuai raja dewa Romawi. Galileo Galilei menemukan 4 bulan terbesar (bulan Galilean) pada 1610, menjadi bukti pertama bahwa benda langit tidak mengorbit Bumi. Jupiter menjadi target eksplorasi sejak era ruang angkasa dengan pesawat luar angkasa Pioneer dan Voyager.',
        'facts' => [
            '95 bulan diketahui, termasuk 4 bulan Galilean: Io, Europa, Ganymede, Callisto',
            'Great Red Spot: badai antisiklon 2x lebih besar dari Bumi, berlangsung 400+ tahun',
            'Hari terpendek di Tata Surya: hanya 10 jam (berputar sangat cepat)',
            'Medan magnet 20,000x lebih kuat dari Bumi',
            'Massa Jupiter 2.5x massa semua planet lain digabungkan',
            'Melindungi Bumi dengan menarik asteroid dan komet (gravitasi massive)',
            'Memiliki sistem cincin tipis yang sulit dilihat dari Bumi',
            'Europa kemungkinan memiliki lautan air di bawah permukaannya',
            'Io adalah benda yang paling vulkanis dalam Tata Surya',
            'Jika 80x lebih masif, Jupiter bisa menjadi bintang kecil'
        ],
        'missions' => 'Pioneer 10-11, Voyager 1-2, Galileo, Cassini, JUNO',
        'exploration' => 'Jupiter telah dikunjungi oleh semua pesawat luar angkasa yang dikirim ke outer solar system. JUNO (NASA) saat ini mengorbit Jupiter dan menyelami atmosfernya. Data dari misi ini mengungkapkan badai dalam skala global, medan magnet ekstrem, dan potential kehidupan di bulan-bulannya.'
    ],
    'saturn' => [
        'name' => 'Saturnus',
        'english_name' => 'Saturn',
        'type' => 'Gas Giant (Planet Raksasa Gas)',
        'image' => 'saturn.png',
        'diameter' => '116,460 km',
        'mass' => '5.683 × 10²⁶ kg',
        'distance' => '1.4 miliar km dari Matahari',
        'temperature' => '-138°C (rata-rata, puncak awan)',
        'gravity' => '10.4 m/s² (1.1x Bumi)',
        'day_length' => '10.7 jam',
        'year_length' => '29 tahun Bumi',
        'atmosphere' => '96% H₂, 3% He, jejak CH₄, NH₃, H₂O',
        'moons' => '146 (diketahui, Titan adalah terbesar)',
        'description' => 'Saturnus terkenal karena sistem cincin spektakulernya yang terbuat dari miliaran partikel es dan batu, menciptakan pemandangan paling indah di Tata Surya. Sebagai gas giant kedua terbesar, Saturnus memiliki komposisi serupa dengan Jupiter. Kepadatannya sangat rendah (0.687 g/cm³) sehingga bisa mengapung di air! Titan, bulan terbesarnya, adalah satu-satunya bulan dengan atmosfer tebal.',
        'history' => 'Saturnus telah dikenal sejak zaman kuno dan dinamai sesuai dewa pertanian Romawi. Christiaan Huygens pertama kali mengamati cincinnya pada 1655. Eksplorasi modern dimulai dengan Pioneer 11 dan Voyager 1-2, diikuti misi Cassini yang spektakuler selama 13 tahun.',
        'facts' => [
            'Sistem cincin paling spektakuler: lebar 280,000 km tapi tebal hanya 10-100 meter',
            '146 bulan diketahui, dengan Titan memiliki atmosfer lebih tebal dari Bumi',
            'Kepadatan terendah: 0.687 g/cm³ (bisa mengapung di kolam air!)',
            'Angin di ekuator mencapai 1,800 km/jam',
            'Cincin terbuat dari 99% es air dengan sedikit partikel batu',
            'Enceladus menyemburkan geyser air dari lautan bawah permukaannya',
            'Hexagon misterius di kutub utara: badai berbentuk segi enam yang stabil',
            'Satu musim berlangsung 7 tahun (seperempat dari orbitnya)',
            'Titan memiliki danau dan lautan hydrocarbon di permukaannya',
            'Cassini-Huygens mendarat di Titan dan menemukan permukaan yang kompleks'
        ],
        'missions' => 'Pioneer 11, Voyager 1-2, Cassini-Huygens',
        'exploration' => 'Misi Cassini-Huygens (2004-2017) adalah eksplorasi paling sukses Saturnus, dengan Huygens mendarat di Titan. Data terbaru menunjukkan Enceladus memiliki lautan bawah permukaan yang mungkin mendukung kehidupan, membuat Saturnus menjadi fokus pencarian kehidupan di Tata Surya.'
    ],
    'uranus' => [
        'name' => 'Uranus',
        'english_name' => 'Uranus',
        'type' => 'Ice Giant (Planet Es Raksasa)',
        'image' => 'uranus.png',
        'diameter' => '50,724 km',
        'mass' => '8.681 × 10²⁵ kg',
        'distance' => '2.9 miliar km dari Matahari',
        'temperature' => '-197°C (rata-rata)',
        'gravity' => '8.7 m/s² (0.9x Bumi)',
        'day_length' => '17.2 jam (retrograde)',
        'year_length' => '84 tahun Bumi',
        'atmosphere' => '83% H₂, 15% He, 2% CH₄ (methane)',
        'moons' => '28 (diketahui)',
        'description' => 'Uranus adalah ice giant dengan warna biru-hijau karena methane di atmosfernya yang menyerap cahaya merah. Yang paling unik dan aneh: rotasi aksial Uranus 98 derajat, membuat planet ini berputar "miring" atau pada sisinya seperti bola bowling yang digulingkan. Akibatnya, satu kutub menghadap Matahari selama 42 tahun, sementara kutub lain dalam kegelapan total.',
        'history' => 'Uranus adalah planet pertama yang ditemukan di era teleskop (1781 oleh William Herschel), memperluas batas Tata Surya yang diketahui. Ia tidak diketahui di zaman kuno karena terlalu redup untuk dilihat dengan mata telanjang. Voyager 2 adalah satu-satunya pesawat yang mengunjunginya pada 1986.',
        'facts' => [
            'Berputar pada sisinya dengan kemiringan 98 derajat (hampir horizontal)',
            'Planet pertama ditemukan dengan teleskop oleh William Herschel pada 1781',
            '28 bulan diketahui, dinamai berdasarkan karakter Shakespeare dan Pope',
            'Warna biru-hijau karena methane yang menyerap cahaya merah',
            'Satu musim berlangsung 21 tahun Bumi - kutub dalam kegelapan/terang berkelanjutan',
            'Suhu terendah di atmosfer: -224°C (tercatat oleh Voyager 2)',
            'Memiliki 13 cincin tipis dan redup',
            'Miranda (bulan): permukaan paling beragam dan aneh di Tata Surya',
            'Hanya pernah dikunjungi sekali oleh Voyager 2 pada Januari 1986',
            'Revolusi penuh membutuhkan 84 tahun Bumi'
        ],
        'missions' => 'Voyager 2',
        'exploration' => 'Uranus telah dikunjungi hanya sekali oleh Voyager 2 pada 1986, menjadi planet yang paling sedikit dieksplorasi di Tata Surya. Flyby singkat ini memberikan gambar dan data berharga, namun para ilmuwan masih menginginkan misi orbital untuk studi lebih mendalam.'
    ],
    'neptune' => [
        'name' => 'Neptunus',
        'english_name' => 'Neptune',
        'type' => 'Ice Giant (Planet Es Raksasa)',
        'image' => 'neptune.png',
        'diameter' => '49,244 km',
        'mass' => '1.024 × 10²⁶ kg',
        'distance' => '4.5 miliar km dari Matahari',
        'temperature' => '-214°C (rata-rata)',
        'gravity' => '11.2 m/s² (1.1x Bumi)',
        'day_length' => '16 jam',
        'year_length' => '165 tahun Bumi',
        'atmosphere' => '80% H₂, 19% He, 1.5% CH₄, jejak H₂O, NH₃',
        'moons' => '16 (diketahui, Triton adalah terbesar)',
        'description' => 'Neptunus adalah planet terjauh dari Matahari dalam Tata Surya dan ice giant dengan warna biru cerah karena methane. Planet ini memiliki angin tercepat di Tata Surya, dengan kecepatan hingga 2,100 km/jam (Mach 3 relatif terhadap kecepatan suara!). Neptunus memancarkan 2.6 kali lebih banyak energi daripada yang diterimanya dari Matahari, menunjukkan ada sumber panas internal.',
        'history' => 'Neptunus adalah planet pertama yang ditemukan melalui perhitungan matematis sebelum observasi visual (1846), diprediksi dari gangguan gravitasi pada orbit Uranus. Ini merupakan triumph matematika dan fisika. Voyager 2 adalah satu-satunya pesawat yang telah mengunjunginya pada 1989.',
        'facts' => [
            'Angin tercepat di Tata Surya: hingga 2,100 km/jam (lebih cepat dari suara)',
            'Ditemukan melalui perhitungan matematis (1846) sebelum observasi visual',
            'Triton (bulan terbesar) memiliki orbit retrograde (unik dan aneh)',
            'Triton perlahan jatuh ke Neptunus dan akan hancur dalam 3.6 miliar tahun',
            'Great Dark Spot: badai seukuran Bumi yang muncul dan menghilang',
            'Warna biru lebih intens daripada Uranus karena konsentrasi methane lebih tinggi',
            'Memiliki 6 cincin redup dan tidak lengkap',
            'Satu tahun Neptunus = 165 tahun Bumi (baru menyelesaikan 1 orbit sejak ditemukan)',
            'Triton adalah objek terdingin: -235°C (sesuai dengan teori bahwa ia berasal dari Kuiper Belt)',
            'Memancarkan 2.6x lebih banyak energi dari panas internal yang tidak diketahui asalnya'
        ],
        'missions' => 'Voyager 2',
        'exploration' => 'Neptunus hanya dikunjungi sekali oleh Voyager 2 pada 1989, menjadi pencapaian luar biasa saat mencapai planet terjauh yang diketahui. Misi singkat ini mengubah pemahaman kita tentang ice giants, menemukan Great Dark Spot dan badai-badai lainnya.'
    ],
    'celester' => [
        'name' => 'Celester',
        'english_name' => 'Celester',
        'type' => 'Dwarf Planet (Planet Kerdil)',
        'image' => 'celester.png',
        'diameter' => '~2,400 km (diperkirakan)',
        'mass' => 'Tidak diketahui dengan pasti',
        'distance' => 'Beyond Neptunus (Kuiper Belt)',
        'temperature' => '-230°C hingga -240°C (diperkirakan)',
        'gravity' => '~0.4 m/s² (diperkirakan)',
        'composition' => 'Es (H₂O, CH₄, N₂) dan batuan',
        'year_length' => '~250 tahun Bumi (diperkirakan)',
        'moons' => 'Berpotensi 1-2 (belum dikonfirmasi)',
        'description' => 'Celester adalah benda langit misterius yang terletak di pinggiran Tata Surya dalam wilayah Kuiper Belt. Sebagai salah satu penemuan terbaru, Celester masih menjadi misteri bagi astronom yang sedang mempelajari komposisi dan karakteristiknya lebih lanjut. Kemungkinan terbuat dari es dan batuan dengan permukaan yang sangat dingin dan gelap.',
        'history' => 'Celester adalah penemuan relatif baru yang menambah daftar objek trans-Neptunian yang telah ditemukan dalam beberapa dekade terakhir. Penemuan ini memperkaya pemahaman kita tentang struktur dan populasi Kuiper Belt, wilayah yang dipenuhi ribuan benda es di pinggiran Tata Surya.',
        'facts' => [
            'Terletak di wilayah Kuiper Belt yang gelap dan dingin',
            'Salah satu dari ribuan objek trans-Neptunian yang baru ditemukan',
            'Kemungkinan komposisi: es (air, methane, nitrogen) dan batuan',
            'Permukaan mungkin tertutup methane, nitrogen, dan es air',
            'Orbitnya sangat elips dan memakan waktu ratusan tahun',
            'Cahaya Matahari 1,600x lebih redup dibanding di Bumi',
            'Bisa memiliki satu atau dua satelit kecil (belum dikonfirmasi)',
            'Suhu ekstrem membuat planet ini beku dan stabil',
            'Perjalanan cahaya dari Matahari membutuhkan lebih dari 4 jam',
            'Representasi dari banyak objek misterius yang masih belum terjamah di pinggiran Tata Surya'
        ],
        'missions' => 'Tidak ada misi yang telah dikirim',
        <div class="bg"></div>
        <div class="bg bg2"></div>
    </div>

    <div class="planet-detail-container">
        <a href="planetarium.php" class="back-btn">
            <img src="../assets/icons/ui/back.png" class="icon" alt="Back">Back
        </a>

        <div class="planet-detail-header">
            <div class="planet-detail-image">
                <img src="../assets/images/planets/<?php echo preg_replace('/\.(png|jpg|jpeg)$/i', '.webp', $planet['image']); ?>"
                    alt="<?php echo htmlspecialchars($planet['english_name']); ?>">
            </div>
            <div class="planet-detail-info">
                <div class="planet-detail-title"><?php echo htmlspecialchars($planet['english_name']); ?></div>
                <div class="planet-detail-subtitle"><?php echo htmlspecialchars($planet['type']); ?></div>

                <div class="planet-stats">
                    <?php if (!empty($planet['diameter'])): ?>
                        <div class="stat">
                            <div class="stat-label">Diameter</div>
                            <div class="stat-value"><?php echo htmlspecialchars($planet['diameter']); ?></div>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($planet['mass'])): ?>
                        <div class="stat">
                            <div class="stat-label">Massa</div>
                            <div class="stat-value"><?php echo htmlspecialchars($planet['mass']); ?></div>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($planet['distance'])): ?>
                        <div class="stat">
                            <div class="stat-label">Jarak dari Matahari</div>
                            <div class="stat-value"><?php echo htmlspecialchars($planet['distance']); ?></div>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($planet['temperature'])): ?>
                        <div class="stat">
                            <div class="stat-label">Suhu</div>
                            <div class="stat-value"><?php echo htmlspecialchars($planet['temperature']); ?></div>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($planet['gravity'])): ?>
                        <div class="stat">
                            <div class="stat-label">Gravitasi</div>
                            <div class="stat-value"><?php echo htmlspecialchars($planet['gravity']); ?></div>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($planet['day_length'])): ?>
                        <div class="stat">
                            <div class="stat-label">Panjang Hari</div>
                            <div class="stat-value"><?php echo htmlspecialchars($planet['day_length']); ?></div>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($planet['year_length'])): ?>
                        <div class="stat">
                            <div class="stat-label">Panjang Tahun</div>
                            <div class="stat-value"><?php echo htmlspecialchars($planet['year_length']); ?></div>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($planet['moons'])): ?>
                        <div class="stat">
                            <div class="stat-label">Bulan</div>
                            <div class="stat-value"><?php echo htmlspecialchars($planet['moons']); ?></div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="section">
            <div class="section-title">Deskripsi</div>
            <div class="section-content">
                <?php echo htmlspecialchars($planet['description']); ?>
            </div>
        </div>

        <?php if (!empty($planet['history'])): ?>
        <div class="section">
            <div class="section-title">Sejarah</div>
            <div class="section-content">
                <?php echo htmlspecialchars($planet['history']); ?>
            </div>
        </div>
        <?php endif; ?>

        <?php if (!empty($planet['facts'])): ?>
        <div class="section">
            <div class="section-title">Fakta Menarik</div>
            <div class="section-content">
                <?php foreach ($planet['facts'] as $fact): ?>
                    <div class="fact-item">✦ <?php echo htmlspecialchars($fact); ?></div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <?php if (!empty($planet['missions']) || !empty($planet['exploration'])): ?>
        <div class="section">
            <div class="section-title">Eksplorasi</div>
            <div class="section-content">
                <?php if (!empty($planet['missions'])): ?>
                    <strong>Misi Terkait:</strong> <?php echo htmlspecialchars($planet['missions']); ?><br><br>
                <?php endif; ?>
                <?php if (!empty($planet['exploration'])): ?>
                    <?php echo htmlspecialchars($planet['exploration']); ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        // Track planet view - recorded ketika user buka halaman ini
        const currentPlanetName = '<?php echo htmlspecialchars($_GET['planet'] ?? 'unknown'); ?>';
        let hasTracked = false;

        // Function to record planet view click
        function trackPlanetView(planetName) {
            if (hasTracked) return; // Prevent double tracking

            hasTracked = true;

            fetch('track_planet_view.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    planet_name: planetName
                })
            })
                .then(response => response.json())
                .then(data => console.log('Planet view recorded:', data))
                .catch(error => console.error('Tracking error:', error));
        }

        // Record view when page loads
        document.addEventListener('DOMContentLoaded', function () {
            trackPlanetView(currentPlanetName);
        });
    </script>
</body>

</html>