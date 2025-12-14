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

?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/icons/thumbnail.png" type="image/png">
    <title><?php echo htmlspecialchars(($planet['english_name'] ?? $planet['name'] ?? '')); ?> - Galaxy Explorer</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/planetarium.css">
    <link rel="stylesheet" href="../assets/css/planet-detail.css">
</head>

<body>
    <div class="container login-page">
        <div class="bg"></div>
    </div>

    <div class="planet-detail-container">
        <a href="planetarium.php" class="back-btn">
            <img src="../assets/icons/ui/back.png" class="icon" alt="Back">Back
        </a>

        <div class="planet-detail-header">
            <div class="planet-detail-image">
                <?php
                $img = $planet['image'] ?? '';
                $img_src = '';
                if (!empty($img)) {
                    if (strpos($img, '/') !== false) {
                        // New uploaded format: full relative path
                        $img_src = '../' . $img;
                    } else {
                        // Old format: filename only - convert to .webp for backward compatibility
                        $converted = preg_replace('/\.(png|jpg|jpeg)$/i', '.webp', $img);
                        $img_src = '../assets/images/planets/' . $converted;
                    }
                }
                ?>
                <img src="<?php echo htmlspecialchars($img_src); ?>"
                    alt="<?php echo htmlspecialchars(($planet['english_name'] ?? $planet['name'] ?? '')); ?>">
            </div>
            <div class="planet-detail-info">
                <div class="planet-detail-title">
                    <?php echo htmlspecialchars(($planet['english_name'] ?? $planet['name'] ?? '')); ?>
                </div>
                <div class="planet-detail-subtitle"><?php echo htmlspecialchars($planet['type'] ?? ''); ?></div>

                <div class="planet-stats">
                    <?php if (!empty($planet['diameter'])): ?>
                        <div class="stat">
                            <div class="stat-label">Diameter</div>
                            <div class="stat-value"><?php echo htmlspecialchars($planet['diameter'] ?? ''); ?></div>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($planet['mass'])): ?>
                        <div class="stat">
                            <div class="stat-label">Massa</div>
                            <div class="stat-value"><?php echo htmlspecialchars($planet['mass'] ?? ''); ?></div>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($planet['distance'])): ?>
                        <div class="stat">
                            <div class="stat-label">Jarak dari Matahari</div>
                            <div class="stat-value"><?php echo htmlspecialchars($planet['distance'] ?? ''); ?></div>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($planet['temperature'])): ?>
                        <div class="stat">
                            <div class="stat-label">Suhu</div>
                            <div class="stat-value"><?php echo htmlspecialchars($planet['temperature'] ?? ''); ?></div>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($planet['gravity'])): ?>
                        <div class="stat">
                            <div class="stat-label">Gravitasi</div>
                            <div class="stat-value"><?php echo htmlspecialchars($planet['gravity'] ?? ''); ?></div>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($planet['day_length'])): ?>
                        <div class="stat">
                            <div class="stat-label">Panjang Hari</div>
                            <div class="stat-value"><?php echo htmlspecialchars($planet['day_length'] ?? ''); ?></div>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($planet['year_length'])): ?>
                        <div class="stat">
                            <div class="stat-label">Panjang Tahun</div>
                            <div class="stat-value"><?php echo htmlspecialchars($planet['year_length'] ?? ''); ?></div>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($planet['moons'])): ?>
                        <div class="stat">
                            <div class="stat-label">Bulan</div>
                            <div class="stat-value"><?php echo htmlspecialchars($planet['moons'] ?? ''); ?></div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="section">
            <div class="section-title">Deskripsi</div>
            <div class="section-content">
                <?php echo htmlspecialchars($planet['description'] ?? ''); ?>
            </div>
        </div>

        <?php if (!empty($planet['history'])): ?>
            <div class="section">
                <div class="section-title">Sejarah</div>
                <div class="section-content">
                    <?php echo htmlspecialchars($planet['history'] ?? ''); ?>
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
                        <strong>Misi Terkait:</strong> <?php echo htmlspecialchars($planet['missions'] ?? ''); ?><br><br>
                    <?php endif; ?>
                    <?php if (!empty($planet['exploration'])): ?>
                        <?php echo htmlspecialchars($planet['exploration'] ?? ''); ?>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <script>
        const currentPlanetName = '<?php echo htmlspecialchars($_GET['planet'] ?? 'unknown'); ?>';
        let hasTracked = false;

        function trackPlanetView(planetName) {
            if (hasTracked) return;

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