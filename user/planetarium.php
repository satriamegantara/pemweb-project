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

// Ambil data planet dari database
$planets = getPlanets($koneksi);
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
                    <?php
                    $img = $planet['image'] ?? '';
                    $img_src = '';
                    if (!empty($img)) {
                        if (strpos($img, '/') !== false) {
                            // New uploaded format: full relative path like "assets/images/planets/mars_123456.png"
                            $img_src = '../' . $img;
                        } else {
                            // Old format: just filename like "sun.png" - convert to .webp for backward compatibility
                            $converted = preg_replace('/\.(png|jpg|jpeg)$/i', '.webp', $img);
                            $img_src = '../assets/images/planets/' . $converted;
                        }
                    }
                    ?>
                    <a href="planet_detail.php?planet=<?php echo htmlspecialchars($planet['name'] ?? '') ?>"
                        class="planet-card">
                        <div class="planet-image-wrapper">
                            <img src="<?php echo htmlspecialchars($img_src); ?>"
                                alt="<?php echo htmlspecialchars(($planet['english_name'] ?? $planet['name'] ?? '')) ?>"
                                class="planet-img">
                        </div>
                        <h3 class="planet-name">
                            <?php echo htmlspecialchars(($planet['english_name'] ?? $planet['name'] ?? '')) ?>
                        </h3>
                        <p class="planet-type"><?php echo htmlspecialchars($planet['type'] ?? '') ?></p>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>


</body>

</html>