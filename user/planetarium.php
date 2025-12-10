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
        'temperature' => '5,500°C (surface)',
        'orbit_period' => '-',
        'moons' => 'N/A',
        'description' => 'Matahari adalah bintang di pusat Tata Surya kita. Merupakan bola plasma panas yang dipanaskan oleh reaksi fusi nuklir di intinya, Matahari adalah sumber energi utama bagi semua kehidupan di Bumi.',
        'facts' => [
            'Mengandung 99.86% massa Tata Surya',
            'Cahaya dari Matahari membutuhkan waktu sekitar 8 menit untuk mencapai Bumi',
            'Umur Matahari sekitar 4.6 miliar tahun',
            'Diameter Matahari sekitar 109 kali lebih besar dari Bumi'
        ]
    ],
    [
        'name' => 'Mercury',
        'image' => 'mercury.png',
        'type' => 'Terrestrial Planet',
        'diameter' => '4,879 km',
        'mass' => '3.285 × 10²³ kg',
        'distance' => '57.9 million km from Sun',
        'temperature' => '-173°C to 427°C',
        'orbit_period' => '88 Earth days',
        'moons' => 'None',
        'description' => 'Mercury adalah planet terkecil dan terdekat dengan Matahari dalam Tata Surya kita. Dengan permukaan yang dipenuhi kawah dan atmosfer yang sangat tipis, Mercury mengalami variasi suhu ekstrem yang merupakan yang terbesar di antara semua planet.',
        'facts' => [
            'Satu hari di Mercury berlangsung 59 hari Bumi',
            'Dinamai sesuai dewa pesan Romawi, Mercury',
            'Memiliki inti besi yang sangat besar dibandingkan dengan ukurannya',
            'Kecepatan orbitalnya adalah yang tercepat di Tata Surya'
        ]
    ],
    [
        'name' => 'Venus',
        'image' => 'venus.png',
        'type' => 'Terrestrial Planet',
        'diameter' => '12,104 km',
        'mass' => '4.867 × 10²⁴ kg',
        'distance' => '108.2 million km from Sun',
        'temperature' => '462°C average',
        'orbit_period' => '225 Earth days',
        'moons' => 'None',
        'description' => 'Venus adalah planet tergoyang dengan suhu permukaan tertinggi di Tata Surya. Dengan atmosfer yang sangat tebal terdiri dari karbon dioksida dan asam sulfat, Venus menciptakan efek rumah kaca yang ekstrem. Planet ini berputar mundur dibandingkan dengan planet lainnya.',
        'facts' => [
            'Venus berputar mundur (rotasi retrograde) dibandingkan planet lain',
            'Satu hari di Venus lebih panjang daripada tahunnya',
            'Sering disebut "saudara kembar Earth" karena ukuran yang serupa',
            'Tekanan atmosfernya 92 kali lebih besar dari Bumi'
        ]
    ],
    [
        'name' => 'Earth',
        'image' => 'earth.png',
        'type' => 'Terrestrial Planet',
        'diameter' => '12,742 km',
        'mass' => '5.972 × 10²⁴ kg',
        'distance' => '149.6 million km from Sun',
        'temperature' => '15°C average',
        'orbit_period' => '365.25 days',
        'moons' => '1 (The Moon)',
        'description' => 'Bumi adalah planet ketiga dari Matahari dan satu-satunya yang diketahui memiliki kehidupan. Dengan air cair, atmosfer pelindung, dan ekosistem yang beragam, Bumi adalah rumah bagi miliaran makhluk hidup.',
        'facts' => [
            'Sekitar 71% permukaan Bumi ditutupi air',
            'Memiliki satu satelit alami: Bulan',
            'Rotasi Bumi memperlambat sekitar 1,7 milidetik per abad',
            'Memiliki medan magnet yang melindungi dari radiasi Matahari'
        ]
    ],
    [
        'name' => 'Mars',
        'image' => 'mars.png',
        'type' => 'Terrestrial Planet',
        'diameter' => '6,779 km',
        'mass' => '6.417 × 10²³ kg',
        'distance' => '227.9 million km from Sun',
        'temperature' => '-65°C average',
        'orbit_period' => '687 Earth days',
        'moons' => '2 (Phobos & Deimos)',
        'description' => 'Mars adalah planet keempat dari Matahari dan dikenal sebagai "Planet Merah" karena permukaan yang berkarat. Dengan atmosfer tipis dan bukti air di masa lalu, Mars menjadi target utama eksplorasi manusia di masa depan.',
        'facts' => [
            'Mars memiliki dua bulan kecil: Phobos dan Deimos',
            'Gunung Olympus Mons adalah gunung berapi terbesar di Tata Surya',
            'Valles Marineris adalah ngarai terbesar di Tata Surya',
            'Satu tahun di Mars adalah 687 hari Bumi'
        ]
    ],
    [
        'name' => 'Jupiter',
        'image' => 'jupiter.png',
        'type' => 'Gas Giant',
        'diameter' => '139,820 km',
        'mass' => '1.898 × 10²⁷ kg',
        'distance' => '778.5 million km from Sun',
        'temperature' => '-108°C average',
        'orbit_period' => '12 Earth years',
        'moons' => '95 (known)',
        'description' => 'Jupiter adalah planet terbesar dalam Tata Surya kami. Sebagai gas giant, Jupiter terdiri dari hidrogen dan helium dengan inti berbatu. Fitur terkenalnya adalah Great Red Spot, sebuah badai raksasa yang berlangsung lebih lama dari usia Bumi.',
        'facts' => [
            'Jupiter memiliki setidaknya 95 bulan yang diketahui',
            'Great Red Spot adalah badai yang lebih besar dari Bumi',
            'Hari di Jupiter hanya berlangsung 10 jam',
            'Jupiter memiliki sistem cincin yang lemah dan medan magnetik yang sangat kuat'
        ]
    ],
    [
        'name' => 'Saturn',
        'image' => 'saturn.png',
        'type' => 'Gas Giant',
        'diameter' => '116,460 km',
        'mass' => '5.683 × 10²⁶ kg',
        'distance' => '1.4 billion km from Sun',
        'temperature' => '-138°C average',
        'orbit_period' => '29 Earth years',
        'moons' => '146 (known)',
        'description' => 'Saturn terkenal karena sistem cincin spektakulernya yang terbuat dari es dan partikel batu. Sebagai gas giant kedua terbesar, Saturn memiliki komposisi serupa dengan Jupiter tetapi dengan kepadatan yang jauh lebih rendah.',
        'facts' => [
            'Saturn memiliki sistem cincin paling ekstensif dari semua planet',
            'Saturn memiliki setidaknya 146 bulan yang diketahui',
            'Bisa mengapung di air karena kepadatannya yang rendah',
            'Kecepatan angin di Saturn dapat mencapai 1,800 km/jam'
        ]
    ],
    [
        'name' => 'Uranus',
        'image' => 'uranus.png',
        'type' => 'Ice Giant',
        'diameter' => '50,724 km',
        'mass' => '8.681 × 10²⁵ kg',
        'distance' => '2.9 billion km from Sun',
        'temperature' => '-197°C average',
        'orbit_period' => '84 Earth years',
        'moons' => '28 (known)',
        'description' => 'Uranus adalah planet ketujuh dari Matahari dan merupakan ice giant dengan warna biru kehijauan. Planet ini memiliki karakteristik unik yaitu rotasi aksialnya hampir 98 derajat, membuatnya berputar pada sisinya.',
        'facts' => [
            'Uranus berputar pada sisinya (rotasi 98 derajat)',
            'Memiliki 28 bulan yang diketahui, termasuk Miranda dan Titania',
            'Atmosfer Uranus terdiri dari hidrogen, helium, dan methane',
            'Uranus ditemukan pada tahun 1781, planet pertama yang ditemukan di era modern'
        ]
    ],
    [
        'name' => 'Neptune',
        'image' => 'neptune.png',
        'type' => 'Ice Giant',
        'diameter' => '49,244 km',
        'mass' => '1.024 × 10²⁶ kg',
        'distance' => '4.5 billion km from Sun',
        'temperature' => '-214°C average',
        'orbit_period' => '165 Earth years',
        'moons' => '16 (known)',
        'description' => 'Neptune adalah planet kedelapan dan terjauh dari Matahari dalam Tata Surya kita. Merupakan ice giant dengan angin tercepat di Tata Surya, Neptune memiliki warna biru yang indah karena kandungan methane di atmosfernya.',
        'facts' => [
            'Neptune memiliki 16 bulan yang diketahui, terbesar adalah Triton',
            'Kecepatan angin di Neptune dapat mencapai 2,100 km/jam',
            'Membutuhkan 165 tahun Bumi untuk mengorbit Matahari sekali',
            'Neptune ditemukan secara matematis sebelum observasi visual'
        ]
    ],
    [
        'name' => 'Celester',
        'image' => 'celester.png',
        'type' => 'Dwarf Planet',
        'diameter' => '~2,400 km (estimated)',
        'mass' => 'Unknown',
        'distance' => 'Beyond Neptune (Kuiper Belt)',
        'temperature' => '-230°C (estimated)',
        'orbit_period' => '~250 Earth years',
        'moons' => 'Potentially 1-2',
        'description' => 'Celester adalah benda langit misterius di pinggiran Tata Surya kami. Sebagai benda yang baru ditemukan, Celester masih dipelajari oleh astronom dan mungkin memiliki komposisi unik dengan banyak es dan mineral.',
        'facts' => [
            'Salah satu penemuan terbaru di Tata Surya',
            'Terletak di wilayah Kuiper Belt yang gelap',
            'Kemungkinan memiliki komposisi es dan mineral yang unik',
            'Mungkin memiliki satu atau dua satelit alami'
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
                    <div class="planet-card" onclick="showPlanetDetail(<?php echo $index; ?>)">
                        <div class="planet-image-wrapper">
                            <img src="../assets/images/planets/<?php echo $planet['image']; ?>"
                                alt="<?php echo $planet['name']; ?>" class="planet-img">
                        </div>
                        <h3 class="planet-name"><?php echo $planet['name']; ?></h3>
                        <p class="planet-type"><?php echo $planet['type']; ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Modal untuk detail planet -->
    <div id="planetModal" class="modal">
        <div class="modal-content glass-card">
            <span class="close-modal" onclick="closeModal()">&times;</span>
            <div class="modal-body">
                <div class="modal-left">
                    <img id="modalPlanetImage" src="" alt="" class="modal-planet-img">
                    <h2 id="modalPlanetName" class="modal-planet-name"></h2>
                    <p id="modalPlanetType" class="modal-planet-type"></p>
                </div>
                <div class="modal-right">
                    <div class="planet-specs">
                        <div class="spec-item">
                            <span class="spec-label">Diameter:</span>
                            <span id="modalDiameter" class="spec-value"></span>
                        </div>
                        <div class="spec-item">
                            <span class="spec-label">Mass:</span>
                            <span id="modalMass" class="spec-value"></span>
                        </div>
                        <div class="spec-item" id="distanceSpec">
                            <span class="spec-label">Distance from Sun:</span>
                            <span id="modalDistance" class="spec-value"></span>
                        </div>
                        <div class="spec-item">
                            <span class="spec-label">Temperature:</span>
                            <span id="modalTemperature" class="spec-value"></span>
                        </div>
                        <div class="spec-item">
                            <span class="spec-label">Orbit Period:</span>
                            <span id="modalOrbitPeriod" class="spec-value"></span>
                        </div>
                        <div class="spec-item">
                            <span class="spec-label">Moons:</span>
                            <span id="modalMoons" class="spec-value"></span>
                        </div>
                    </div>
                    <div class="planet-description">
                        <h3>Description</h3>
                        <p id="modalDescription"></p>
                    </div>
                    <div class="planet-facts">
                        <h3>Interesting Facts</h3>
                        <ul id="modalFacts"></ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const planetsData = <?php echo json_encode($planets); ?>;

        function showPlanetDetail(index) {
            const planet = planetsData[index];
            const modal = document.getElementById('planetModal');

            document.getElementById('modalPlanetImage').src = '../assets/images/planets/' + planet.image;
            document.getElementById('modalPlanetImage').alt = planet.name;
            document.getElementById('modalPlanetName').textContent = planet.name;
            document.getElementById('modalPlanetType').textContent = planet.type;
            document.getElementById('modalDiameter').textContent = planet.diameter;
            document.getElementById('modalMass').textContent = planet.mass;
            document.getElementById('modalTemperature').textContent = planet.temperature;
            document.getElementById('modalOrbitPeriod').textContent = planet.orbit_period;
            document.getElementById('modalMoons').textContent = planet.moons;
            document.getElementById('modalDescription').textContent = planet.description;

            // Hide distance for Sun
            const distanceSpec = document.getElementById('distanceSpec');
            if (planet.distance) {
                distanceSpec.style.display = 'flex';
                document.getElementById('modalDistance').textContent = planet.distance;
            } else {
                distanceSpec.style.display = 'none';
            }

            // Add facts
            const factsList = document.getElementById('modalFacts');
            factsList.innerHTML = '';
            planet.facts.forEach(fact => {
                const li = document.createElement('li');
                li.textContent = fact;
                factsList.appendChild(li);
            });

            modal.style.display = 'flex';
        }

        function closeModal() {
            document.getElementById('planetModal').style.display = 'none';
        }

        // Close modal when clicking outside
        window.onclick = function (event) {
            const modal = document.getElementById('planetModal');
            if (event.target === modal) {
                closeModal();
            }
        }

        // Close modal with Escape key
        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                closeModal();
            }
        });
    </script>
</body>

</html>