<?php
// File untuk menampilkan planetarium dari database atau hardcoded data

function getPlanets($koneksi)
{
    // Coba ambil dari database
    $query = "SELECT * FROM planetarium WHERE is_active = 1 ORDER BY name ASC";
    $result = mysqli_query($koneksi, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $planets = [];
        while ($row = mysqli_fetch_assoc($result)) {
            // Ambil facts dari database
            $facts_query = "SELECT fact FROM planetarium_facts WHERE planet_id = {$row['id']} ORDER BY id ASC";
            $facts_result = mysqli_query($koneksi, $facts_query);
            $facts = [];

            while ($fact_row = mysqli_fetch_assoc($facts_result)) {
                $facts[] = $fact_row['fact'];
            }

            $row['facts'] = $facts;
            $planets[] = $row;
        }
        return $planets;
    }

    // Jika database kosong, gunakan hardcoded data
    return getDefaultPlanets();
}

function getDefaultPlanets()
{
    return [
        [
            'id' => 1,
            'name' => 'Sun',
            'image' => 'sun.png',
            'type' => 'Star',
            'diameter' => '1,391,000 km',
            'mass' => '1.989 × 10³⁰ kg',
            'distance' => '',
            'temperature' => '5,500°C (surface), 15 million°C (core)',
            'orbit_period' => '-',
            'moons' => 'N/A',
            'gravity' => '274 m/s² (28x Earth)',
            'day_length' => '',
            'atmosphere' => '',
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
            'id' => 2,
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
            'composition' => '',
            'age' => '',
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
            'id' => 3,
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
            'composition' => '',
            'age' => '',
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
        ]
    ];
}

function getPlanetByName($koneksi, $name)
{
    $name = mysqli_real_escape_string($koneksi, $name);
    $query = "SELECT * FROM planetarium WHERE name = '$name' AND is_active = 1";
    $result = mysqli_query($koneksi, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $planet = mysqli_fetch_assoc($result);

        // Ambil facts
        $facts_query = "SELECT fact FROM planetarium_facts WHERE planet_id = {$planet['id']} ORDER BY id ASC";
        $facts_result = mysqli_query($koneksi, $facts_query);
        $facts = [];

        while ($fact_row = mysqli_fetch_assoc($facts_result)) {
            $facts[] = $fact_row['fact'];
        }

        $planet['facts'] = $facts;
        return $planet;
    }

    // Jika tidak ditemukan di database, cari di default planets
    $default = getDefaultPlanets();
    foreach ($default as $planet) {
        if ($planet['name'] === $name) {
            return $planet;
        }
    }

    return null;
}
?>