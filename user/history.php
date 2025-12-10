<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['username']) || !isset($_SESSION['role'])) {
    header("Location: ../auth/login.php");
    exit;
}

if ($_SESSION['role'] !== 'user') {
    header("Location: ../error.php");
    exit;
}

$username = htmlspecialchars($_SESSION['username']);
$user_id = $_SESSION['userid'] ?? null;

$username = htmlspecialchars($_SESSION['username']);
$user_id = $_SESSION['userId'] ?? null;

// Initialize data
$history_data = [];
$stats = ['total_views' => 0, 'unique_planets' => 0, 'total_duration' => 0, 'last_visit' => null];
$error_message = '';


// Debug: Check user_id
if (!isset($_SESSION['userId'])) {
    $error_message = "User ID tidak ditemukan dalam session. Silakan login kembali.";
}

// Check if planet_history table exists
$table_check = $koneksi->query("SHOW TABLES LIKE 'planet_history'");
$table_exists = $table_check && $table_check->num_rows > 0;

if (!$table_exists) {
    $error_message = "Tabel history belum ada di database. Hubungi administrator.";
}

if ($table_exists && $user_id) {
    // Get user planet views history
    $history_query = "
        SELECT 
            id,
            planet_name,
            view_time,
            duration_minutes
        FROM planet_history
        WHERE user_id = ?
        ORDER BY view_time DESC
        LIMIT 50
    ";

    $stmt = $koneksi->prepare($history_query);
    if ($stmt) {
        $stmt->bind_param('i', $user_id);
        if ($stmt->execute()) {
            $history_result = $stmt->get_result();
            $history_data = $history_result->fetch_all(MYSQLI_ASSOC);
        } else {
            $error_message = "Error fetching history: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $error_message = "Prepare error: " . $koneksi->error;
    }

    // Get statistics
    $stats_query = "
        SELECT 
            COUNT(*) as total_views,
            COUNT(DISTINCT planet_name) as unique_planets,
            COALESCE(SUM(duration_minutes), 0) as total_duration,
            MAX(view_time) as last_visit
        FROM planet_history
        WHERE user_id = ?
    ";

    $stmt = $koneksi->prepare($stats_query);
    if ($stmt) {
        $stmt->bind_param('i', $user_id);
        if ($stmt->execute()) {
            $stats_result = $stmt->get_result();
            $fetched_stats = $stats_result->fetch_assoc();
            if ($fetched_stats) {
                $stats = $fetched_stats;
            }
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/icons/thumbnail.png" type="image/png">
    <title>History - Galaxy Explorer</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/user-dashboard.css">
    <link rel="stylesheet" href="../assets/css/history.css">
</head>

<body>
    <div class="container login-page">
        <div class="bg"></div>
    </div>

    <div class="content-history">
        <a href="../auth/logout.php" class="logout-btn">
            <img src="../assets/icons/ui/logout.png" class="icon" alt="Logout">Log Out
        </a>

        <a href="dashboard.php" class="back-btn">
            <img src="../assets/icons/ui/back.png" class="icon" alt="Back">Back
        </a>

        <div class="history-container">
            <!-- Error Message (if any) -->
            <?php if ($error_message): ?>
                <div class="error-alert">
                    <span class="error-icon">⚠️</span>
                    <p><?php echo $error_message; ?></p>
                </div>
            <?php endif; ?>

            <!-- Header -->
            <div class="history-header">
                <h1 class="page-title">Riwayat Penjelajahan</h1>
                <p class="page-subtitle">Lihat perjalanan Anda menjelajahi galaksi</p>
            </div>

            <!-- Statistics Cards -->
            <div class="statistics-section">
                <div class="stat-card">
                    <div class="stat-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 6 12 12 16 14"></polyline>
                        </svg>
                    </div>
                    <div class="stat-content">
                        <p class="stat-label">Total Kunjungan</p>
                        <p class="stat-value"><?php echo $stats['total_views'] ?? 0; ?></p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="1"></circle>
                            <circle cx="12" cy="5" r="1"></circle>
                            <circle cx="19" cy="12" r="1"></circle>
                            <circle cx="12" cy="19" r="1"></circle>
                            <circle cx="5" cy="12" r="1"></circle>
                        </svg>
                    </div>
                    <div class="stat-content">
                        <p class="stat-label">Planet Unik Dikunjungi</p>
                        <p class="stat-value"><?php echo $stats['unique_planets'] ?? 0; ?></p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2z"></path>
                        </svg>
                    </div>
                    <div class="stat-content">
                        <p class="stat-label">Total Durasi</p>
                        <p class="stat-value"><?php echo ($stats['total_duration'] ?? 0) . ' mnt'; ?></p>
                    </div>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="filter-section">
                <input type="text" id="searchInput" class="search-input" placeholder="🔍 Cari planet...">
                <select id="sortSelect" class="sort-select">
                    <option value="latest">Terbaru</option>
                    <option value="oldest">Terlama</option>
                    <option value="planet">Nama Planet</option>
                </select>
            </div>

            <!-- History List -->
            <div class="history-section">
                <?php if (!empty($history_data)): ?>
                    <div class="history-list">
                        <?php foreach ($history_data as $index => $entry): ?>
                            <div class="history-item" data-planet="<?php echo htmlspecialchars($entry['planet_name']); ?>">
                                <div class="history-item-index">
                                    <span class="item-number"><?php echo ($index + 1); ?></span>
                                </div>

                                <div class="history-item-content">
                                    <div class="history-planet-info">
                                        <h3 class="history-planet-name"><?php echo htmlspecialchars($entry['planet_name']); ?>
                                        </h3>
                                        <p class="history-visit-time">
                                            <?php
                                            $date = new DateTime($entry['view_time']);
                                            echo $date->format('d M Y, H:i');
                                            ?>
                                        </p>
                                    </div>

                                    <div class="history-planet-duration">
                                        <span class="duration-badge">
                                            ⏱️ <?php echo $entry['duration_minutes']; ?> menit
                                        </span>
                                    </div>
                                </div>

                                <div class="history-item-arrow">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polyline points="9 18 15 12 9 6"></polyline>
                                    </svg>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="empty-state">
                        <div class="empty-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path d="M8 14s1.5 2 4 2 4-2 4-2"></path>
                                <line x1="9" y1="9" x2="9.01" y2="9"></line>
                                <line x1="15" y1="9" x2="15.01" y2="9"></line>
                            </svg>
                        </div>
                        <h2>Belum Ada Riwayat</h2>
                        <p>Mulai penjelajahan Anda ke planetarium untuk mencatat riwayat</p>
                        <a href="planetarium.php" class="cta-button">Mulai Penjelajahan</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        // Search functionality
        const searchInput = document.getElementById('searchInput');
        const historyItems = document.querySelectorAll('.history-item');

        if (searchInput) {
            searchInput.addEventListener('input', function (e) {
                const searchTerm = e.target.value.toLowerCase();
                historyItems.forEach(item => {
                    const planetName = item.getAttribute('data-planet').toLowerCase();
                    if (planetName.includes(searchTerm)) {
                        item.style.display = 'flex';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        }

        // Sort functionality
        const sortSelect = document.getElementById('sortSelect');
        if (sortSelect) {
            sortSelect.addEventListener('change', function (e) {
                const historyList = document.querySelector('.history-list');
                const items = Array.from(document.querySelectorAll('.history-item'));

                items.sort((a, b) => {
                    const sortValue = e.target.value;

                    if (sortValue === 'latest') {
                        return 0; // Keep original order
                    } else if (sortValue === 'oldest') {
                        return 0; // Keep original order (items already sorted by latest first)
                    } else if (sortValue === 'planet') {
                        const planetA = a.getAttribute('data-planet');
                        const planetB = b.getAttribute('data-planet');
                        return planetA.localeCompare(planetB);
                    }
                });

                historyList.innerHTML = '';
                items.forEach(item => historyList.appendChild(item));
            });
        }
    </script>
</body>

</html>