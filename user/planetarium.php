<?php
session_start();

if (!isset($_SESSION['username']) || !isset($_SESSION['role'])) {
    header("Location: ../auth/login.php");
    exit;
}

if ($_SESSION['role'] !== 'user') {
    header("Location: ../error.php");
    exit;
}

$planets = [
    [
        'name' => 'Sun',
        'image' => 'sun.png',
        'type' => 'Star',
        'diameter' => '1,391,000 km',
        'mass' => '1.989 × 10³⁰ kg',
        'temperature' => '5,500°C (surface), 15 million°C (core)',
        'orbit_period' => '-',
        'moons' => 'N/A',
        'gravity' => '274 m/s² (28x Earth)',
        'composition' => '73% Hydrogen, 25% Helium, 2% others',
        'age' => '4.6 billion years',
        'description' => 'Matahari adalah bintang di pusat Tata Surya kita. Merupakan bola plasma panas yang dipanaskan oleh reaksi fusi nuklir di intinya, Matahari adalah sumber energi utama bagi semua kehidupan di Bumi. Setiap detik, 600 juta ton hidrogen diubah menjadi helium, memancarkan energi yang luar biasa ke seluruh Tata Surya.',
        'facts' => [
            'Mengandung 99.86% massa Tata Surya',
            'Cahaya dari Matahari membutuhkan waktu sekitar 8 menit untuk mencapai Bumi',
            'Umur Matahari sekitar 4.6 miliar tahun dan akan bersinar 5 miliar tahun lagi',
            'Diameter Matahari sekitar 109 kali lebih besar dari Bumi',
            'Suhu inti mencapai 15 juta derajat Celsius',
            'Berputar lebih cepat di ekuator (25 hari) daripada di kutub (35 hari)',
            'Badai Matahari dapat mengganggu komunikasi satelit di Bumi',
            'Massa Matahari akan terus berkurang 4 juta ton per detik karena fusi nuklir'
        ]
    ],
    [
        'name' => 'Mercury',
        'image' => 'mercury.png',
        'type' => 'Terrestrial Planet',
        'diameter' => '4,879 km',
        'mass' => '3.285 × 10²³ kg',
        'distance' => '57.9 million km from Sun',
        'temperature' => '-173°C (night) to 427°C (day)',
        'orbit_period' => '88 Earth days',
        'moons' => 'None',
        'gravity' => '3.7 m/s² (0.38x Earth)',
        'day_length' => '176 Earth days',
        'atmosphere' => 'Almost none (exosphere)',
        'description' => 'Mercury adalah planet terkecil dan terdekat dengan Matahari dalam Tata Surya kita. Dengan permukaan yang dipenuhi kawah mirip Bulan dan hampir tanpa atmosfer, Mercury mengalami variasi suhu ekstrem - sangat panas di siang hari dan sangat dingin di malam hari. Planet ini memiliki inti besi yang sangat besar.',
        'facts' => [
            'Satu hari di Mercury (59 hari Bumi) tetapi satu tahunnya hanya 88 hari Bumi',
            'Dinamai sesuai dewa pesan Romawi yang terkenal karena kecepatannya',
            'Memiliki inti besi yang mencakup 75% dari diameternya',
            'Kecepatan orbital 47 km/detik, tercepat di Tata Surya',
            'Permukaan penuh kawah akibat tumbukan asteroid',
            'Medan magnetnya hanya 1% dari medan magnet Bumi',
            'Misi MESSENGER menemukan es air di kawah kutubnya',
            'Variasi suhu mencapai 600°C antara siang dan malam'
        ]
    ],
    [
        'name' => 'Venus',
        'image' => 'venus.png',
        'type' => 'Terrestrial Planet',
        'diameter' => '12,104 km',
        'mass' => '4.867 × 10²⁴ kg',
        'distance' => '108.2 million km from Sun',
        'temperature' => '462°C average (hottest planet)',
        'orbit_period' => '225 Earth days',
        'moons' => 'None',
        'gravity' => '8.87 m/s² (0.9x Earth)',
        'day_length' => '243 Earth days (retrograde)',
        'atmosphere' => '96% CO₂, clouds of sulfuric acid',
        'description' => 'Venus adalah planet terpanas di Tata Surya dengan suhu lebih tinggi dari Mercury meskipun lebih jauh dari Matahari. Atmosfer tebal menciptakan efek rumah kaca ekstrem. Planet ini berputar mundur dan satu harinya lebih panjang dari satu tahunnya. Awan asam sulfat menutupi seluruh permukaan.',
        'facts' => [
            'Venus berputar mundur (rotasi retrograde) - satu-satunya dengan rotasi seperti ini',
            'Satu hari (243 hari Bumi) lebih panjang dari satu tahunnya (225 hari Bumi)',
            'Dijuluki "saudara kembar Bumi" karena ukuran dan komposisi hampir sama',
            'Tekanan atmosfer 92 kali Bumi (setara 900m di bawah laut)',
            'Objek paling terang di langit malam setelah Bulan',
            'Suhu cukup panas untuk melelehkan timah',
            'Hujan asam sulfat terjadi tapi menguap sebelum mencapai permukaan',
            'Angin atmosfer atas 60x lebih cepat dari rotasi planet',
            'Lebih dari 1,600 gunung berapi besar teridentifikasi'
        ]
    ],
    [
        'name' => 'Earth',
        'image' => 'earth.png',
        'type' => 'Terrestrial Planet',
        'diameter' => '12,742 km',
        'mass' => '5.972 × 10²⁴ kg',
        'distance' => '149.6 million km from Sun',
        'temperature' => '-88°C to 58°C (average 15°C)',
        'orbit_period' => '365.25 days',
        'moons' => '1 (The Moon)',
        'gravity' => '9.8 m/s²',
        'day_length' => '24 hours',
        'atmosphere' => '78% N₂, 21% O₂, 1% others',
        'description' => 'Bumi adalah planet ketiga dari Matahari dan satu-satunya tempat di alam semesta yang diketahui mendukung kehidupan. Dengan kombinasi unik air cair, atmosfer kaya oksigen, medan magnet kuat, dan posisi ideal di zona layak huni, Bumi adalah rumah bagi jutaan spesies makhluk hidup.',
        'facts' => [
            '71% permukaan ditutupi air (97% air asin, 3% air tawar)',
            'Atmosfer melindungi kehidupan dari radiasi berbahaya Matahari',
            'Rotasi melambat 17 milidetik per 100 tahun karena efek Bulan',
            'Medan magnet melindungi dari angin Matahari dan radiasi kosmik',
            'Satu-satunya planet dengan lempeng tektonik aktif',
            'Titik tertinggi: Everest (8,849m), terendah: Palung Mariana (-10,994m)',
            'Lebih dari 8.7 juta spesies makhluk hidup',
            '70% oksigen dihasilkan oleh fitoplankton di lautan',
            'Inti Bumi sepanas permukaan Matahari'
        ]
    ],
    [
        'name' => 'Mars',
        'image' => 'mars.png',
        'type' => 'Terrestrial Planet',
        'diameter' => '6,779 km',
        'mass' => '6.417 × 10²³ kg',
        'distance' => '227.9 million km from Sun',
        'temperature' => '-140°C to 20°C (average -65°C)',
        'orbit_period' => '687 Earth days (1.9 Earth years)',
        'moons' => '2 (Phobos & Deimos)',
        'gravity' => '3.71 m/s² (0.38x Earth)',
        'day_length' => '24.6 hours (very similar to Earth)',
        'atmosphere' => '95% CO₂, very thin (1% of Earth)',
        'description' => 'Mars dijuluki "Planet Merah" karena permukaan kaya oksida besi (karat). Dengan atmosfer tipis dan bukti kuat air cair di masa lalu, Mars menjadi target utama eksplorasi dan kolonisasi manusia. Planet ini memiliki musim, kutub es, dan badai debu yang bisa menutupi seluruh planet.',
        'facts' => [
            'Dua bulan kecil: Phobos dan Deimos (kemungkinan asteroid yang tertangkap)',
            'Olympus Mons: gunung berapi tertinggi di Tata Surya (21km, 2.5x Everest)',
            'Valles Marineris: ngarai terbesar (4,000km panjang, 7km dalam)',
            'Kutub es terbuat dari air dan CO₂ beku',
            'Badai debu bisa berlangsung berbulan-bulan dan menutupi seluruh planet',
            'Jejak sungai dan danau kuno menunjukkan air pernah mengalir',
            'NASA menemukan bukti air asin mengalir musiman',
            'Target kolonisasi manusia di masa depan',
            'Rover Curiosity dan Perseverance sedang menjelajahi Mars'
        ]
    ],
    [
        'name' => 'Jupiter',
        'image' => 'jupiter.png',
        'type' => 'Gas Giant',
        'diameter' => '139,820 km',
        'mass' => '1.898 × 10²⁷ kg',
        'distance' => '778.5 million km from Sun',
        'temperature' => '-108°C average (cloud tops)',
        'orbit_period' => '12 Earth years',
        'moons' => '95 (known, including 4 Galilean moons)',
        'gravity' => '24.8 m/s² (2.5x Earth)',
        'day_length' => '10 hours (fastest rotation)',
        'atmosphere' => '90% H₂, 10% He, traces of CH₄, NH₃',
        'description' => 'Jupiter adalah planet terbesar dalam Tata Surya. Sebagai gas giant, Jupiter terdiri dari hidrogen dan helium dengan kemungkinan inti berbatu. Fitur terkenalnya adalah Great Red Spot, badai raksasa yang telah berlangsung setidaknya 400 tahun. Jupiter memiliki medan magnet terkuat dan sistem bulan yang luar biasa.',
        'facts' => [
            '95 bulan diketahui, termasuk 4 bulan Galilean: Io, Europa, Ganymede, Callisto',
            'Great Red Spot: badai antisiklon 2x lebih besar dari Bumi',
            'Hari terpendek di Tata Surya: hanya 10 jam',
            'Medan magnet 20,000x lebih kuat dari Bumi',
            'Massa Jupiter 2.5x massa semua planet lain digabungkan',
            'Melindungi Bumi dengan menarik asteroid dan komet',
            'Memiliki cincin tipis yang sulit dilihat',
            'Europa kemungkinan memiliki lautan di bawah permukaannya',
            'Jika 80x lebih masif, Jupiter bisa menjadi bintang'
        ]
    ],
    [
        'name' => 'Saturn',
        'image' => 'saturn.png',
        'type' => 'Gas Giant',
        'diameter' => '116,460 km',
        'mass' => '5.683 × 10²⁶ kg',
        'distance' => '1.4 billion km from Sun',
        'temperature' => '-138°C average (cloud tops)',
        'orbit_period' => '29 Earth years',
        'moons' => '146 (known, Titan is largest)',
        'gravity' => '10.4 m/s² (1.1x Earth)',
        'day_length' => '10.7 hours',
        'atmosphere' => '96% H₂, 3% He, traces of CH₄, NH₃',
        'description' => 'Saturn terkenal karena sistem cincin spektakulernya yang terbuat dari miliaran partikel es dan batu. Sebagai gas giant kedua terbesar, Saturn memiliki komposisi serupa dengan Jupiter. Kepadatannya sangat rendah - bisa mengapung di air! Titan, bulan terbesarnya, adalah satu-satunya bulan dengan atmosfer tebal.',
        'facts' => [
            'Sistem cincin paling ekstensif: lebar 280,000 km tapi tebal hanya 10-100m',
            '146 bulan diketahui, Titan memiliki atmosfer lebih tebal dari Bumi',
            'Kepadatan paling rendah: 0.687 g/cm³ (bisa mengapung di air!)',
            'Angin mencapai 1,800 km/jam di ekuator',
            'Cincin terbuat dari 99% es air dengan sedikit batu',
            'Enceladus menyemburkan geyser air dari lautan bawah permukaannya',
            'Hexagon misterius di kutub utara: badai berbentuk segi enam',
            'Musim berlangsung 7 tahun (seperempat dari orbitnya)',
            'Misi Cassini mengorbit Saturn selama 13 tahun'
        ]
    ],
    [
        'name' => 'Uranus',
        'image' => 'uranus.png',
        'type' => 'Ice Giant',
        'diameter' => '50,724 km',
        'mass' => '8.681 × 10²⁵ kg',
        'distance' => '2.9 billion km from Sun',
        'temperature' => '-197°C average (coldest planet)',
        'orbit_period' => '84 Earth years',
        'moons' => '28 (known, including Miranda, Titania)',
        'gravity' => '8.7 m/s² (0.9x Earth)',
        'day_length' => '17.2 hours (retrograde)',
        'atmosphere' => '83% H₂, 15% He, 2% CH₄ (methane)',
        'description' => 'Uranus adalah ice giant dengan warna biru-hijau karena methane di atmosfernya. Yang paling unik: rotasi aksial 98 derajat membuat planet ini berputar "miring" atau pada sisinya. Musim ekstrem terjadi dimana satu kutub menghadap Matahari selama 42 tahun, sementara kutub lain dalam kegelapan.',
        'facts' => [
            'Berputar pada sisinya dengan kemiringan 98 derajat (hampir horizontal)',
            '28 bulan diketahui, dinamai berdasarkan karakter Shakespeare dan Pope',
            'Warna biru-hijau karena methane menyerap cahaya merah',
            'Planet pertama ditemukan dengan teleskop (1781 oleh William Herschel)',
            'Satu musim berlangsung 21 tahun - kutub dalam kegelapan/terang berkelanjutan',
            'Suhu terendah di Tata Surya: -224°C tercatat',
            'Memiliki 13 cincin tipis dan redup',
            'Miranda (bulan) memiliki permukaan paling aneh di Tata Surya',
            'Hanya dikunjungi sekali: Voyager 2 pada 1986'
        ]
    ],
    [
        'name' => 'Neptune',
        'image' => 'neptune.png',
        'type' => 'Ice Giant',
        'diameter' => '49,244 km',
        'mass' => '1.024 × 10²⁶ kg',
        'distance' => '4.5 billion km from Sun',
        'temperature' => '-214°C average (cloud tops)',
        'orbit_period' => '165 Earth years',
        'moons' => '16 (known, Triton is largest)',
        'gravity' => '11.2 m/s² (1.1x Earth)',
        'day_length' => '16 hours',
        'atmosphere' => '80% H₂, 19% He, 1.5% CH₄, traces of H₂O, NH₃',
        'description' => 'Neptune adalah planet terjauh dari Matahari dan ice giant dengan warna biru cerah karena methane. Planet ini memiliki angin tercepat di Tata Surya dengan kecepatan hingga 2,100 km/jam. Neptune memancarkan 2.6x lebih banyak energi daripada yang diterimanya dari Matahari, menunjukkan sumber panas internal.',
        'facts' => [
            'Angin tercepat di Tata Surya: hingga 2,100 km/jam',
            'Ditemukan melalui perhitungan matematis (1846) sebelum observasi visual',
            'Triton: bulan terbesar dengan orbit retrograde (unik!)',
            'Triton perlahan jatuh ke Neptune dan akan hancur dalam 3.6 miliar tahun',
            'Great Dark Spot: badai seukuran Bumi yang muncul dan menghilang',
            'Warna biru lebih gelap dari Uranus karena konsentrasi methane lebih tinggi',
            'Memiliki 6 cincin redup dan tidak lengkap',
            'Satu tahun Neptune = 165 tahun Bumi (baru menyelesaikan 1 orbit sejak ditemukan)',
            'Triton adalah objek terdingin yang pernah diukur di Tata Surya: -235°C'
        ]
    ],
    [
        'name' => 'Celester',
        'image' => 'celester.png',
        'type' => 'Dwarf Planet',
        'diameter' => '~2,400 km (estimated)',
        'mass' => 'Unknown',
        'distance' => 'Beyond Neptune (Kuiper Belt)',
        'temperature' => '-230°C to -240°C (estimated)',
        'orbit_period' => '~250 Earth years (estimated)',
        'moons' => 'Potentially 1-2 (unconfirmed)',
        'gravity' => '~0.4 m/s² (estimated)',
        'composition' => 'Ice (H₂O, CH₄, N₂) and rock',
        'discovery' => 'Recently discovered (fictional)',
        'description' => 'Celester adalah benda langit misterius di pinggiran Tata Surya dalam wilayah Kuiper Belt. Sebagai salah satu penemuan terbaru, Celester masih dipelajari oleh astronom untuk memahami komposisi dan karakteristiknya. Kemungkinan terbuat dari es dan batuan dengan permukaan yang sangat dingin dan gelap.',
        'facts' => [
            'Terletak di wilayah Kuiper Belt yang gelap dan dingin',
            'Salah satu dari ribuan objek trans-Neptunian yang baru ditemukan',
            'Kemungkinan memiliki komposisi es dan mineral yang unik',
            'Permukaan mungkin tertutup methane, nitrogen, dan es air',
            'Orbitnya sangat elips dan memakan waktu ratusan tahun',
            'Cahaya Matahari 1,600x lebih redup dibanding di Bumi',
            'Bisa memiliki satu atau dua satelit kecil',
            'Studi lebih lanjut diperlukan untuk mengonfirmasi karakteristiknya',
            'Representasi dari banyak objek misterius di pinggiran Tata Surya'
        ]
    ]
];
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/icons/thumbnail.png" type="image/png">
    <title>Planetarium - Galaxy Explorer</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/planetarium.css">
</head>

<body>
    <div class="container login-page">
        <div class="bg"></div>
    </div>

    <div class="content-dashboard">
        <a href="dashboard.php" class="back-btn">
            <img src="../assets/icons/ui/back.png" class="icon" alt="Back">Back
        </a>

        <div class="planetarium-container">
            <h1 class="page-title inner-shadow">Planetarium</h1>
            <p class="page-subtitle">Explore the wonders of our Solar System</p>

            <div class="planet-grid">
                <?php foreach ($planets as $index => $planet): ?>
                    <a href="planet_detail.php?planet=<?php echo strtolower($planet['name']); ?>" class="planet-card">
                        <div class="planet-image-wrapper">
                            <img src="../assets/images/planets/<?php echo $planet['image']; ?>"
                                alt="<?php echo $planet['name']; ?>" class="planet-img">
                        </div>
                        <h3 class="planet-name"><?php echo $planet['name']; ?></h3>
                        <p class="planet-type"><?php echo $planet['type']; ?></p>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>


</body>

</html>