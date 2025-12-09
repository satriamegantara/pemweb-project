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

// Data planet
$planets = [
    [
        'name' => 'Sun',
        'image' => 'sun.png',
        'type' => 'Star',
        'diameter' => '1,391,000 km',
        'mass' => '1.989 × 10³⁰ kg',
        'temperature' => '5,500°C (surface)',
        'description' => 'The Sun is the star at the center of our Solar System. It is a nearly perfect sphere of hot plasma, heated to incandescence by nuclear fusion reactions in its core.',
        'facts' => [
            'Contains 99.86% of the Solar System\'s mass',
            'Light from the Sun takes about 8 minutes to reach Earth',
            'The Sun is about 4.6 billion years old'
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
        'description' => 'Mercury is the smallest planet in our Solar System and the closest to the Sun. It has a very thin atmosphere and extreme temperature variations.',
        'facts' => [
            'One day on Mercury lasts 59 Earth days',
            'Named after the Roman messenger god',
            'Has a heavily cratered surface similar to our Moon'
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
        'description' => 'Venus is the second planet from the Sun and the hottest planet in our Solar System due to its thick atmosphere of carbon dioxide.',
        'facts' => [
            'Venus rotates backwards compared to other planets',
            'A day on Venus is longer than its year',
            'Often called Earth\'s "sister planet" due to similar size'
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
        'description' => 'Earth is our home planet, the only known planet with life. It has liquid water, a protective atmosphere, and a diverse ecosystem.',
        'facts' => [
            'About 71% of Earth\'s surface is covered with water',
            'Has one natural satellite: the Moon',
            'Takes 365.25 days to orbit the Sun'
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
        'description' => 'Neptune is the eighth and farthest planet from the Sun. It is an ice giant with the strongest winds in the Solar System.',
        'facts' => [
            'Has 14 known moons, the largest is Triton',
            'Wind speeds can reach up to 2,100 km/h',
            'Takes 165 Earth years to complete one orbit'
        ]
    ],
    [
        'name' => 'Jupiter',
        'image' => 'jupyter.png',
        'type' => 'Gas Giant',
        'diameter' => '139,820 km',
        'mass' => '1.898 × 10²⁷ kg',
        'distance' => '778.5 million km from Sun',
        'temperature' => '-108°C average',
        'description' => 'Jupiter is the largest planet in our Solar System. It is a gas giant with a famous Great Red Spot, a giant storm.',
        'facts' => [
            'Has at least 79 known moons',
            'The Great Red Spot is a storm larger than Earth',
            'Jupiter has faint rings made of dust particles'
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
        'description' => 'Saturn is famous for its spectacular ring system made of ice and rock particles. It is the second-largest planet in our Solar System.',
        'facts' => [
            'Has the most extensive ring system of any planet',
            'Saturn has at least 82 known moons',
            'Could float in water due to its low density'
        ]
    ],
    [
        'name' => 'Celester',
        'image' => 'celester.png',
        'type' => 'Dwarf Planet',
        'diameter' => '~2,400 km (estimated)',
        'mass' => 'Unknown',
        'distance' => 'Beyond Neptune',
        'temperature' => '-230°C (estimated)',
        'description' => 'Celester is a mysterious celestial body in the outer reaches of our Solar System, recently discovered and still being studied by astronomers.',
        'facts' => [
            'One of the newest discoveries in our Solar System',
            'Located in the Kuiper Belt region',
            'May have a unique composition of ice and minerals'
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