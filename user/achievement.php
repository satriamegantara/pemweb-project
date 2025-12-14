<?php
session_start();
include("../config/koneksi.php");

if (!isset($_SESSION['username']) || !isset($_SESSION['role'])) {
    header("Location: ../auth/login.php");
    exit;
}

if ($_SESSION['role'] !== 'user') {
    header("Location: ../error.php");
    exit;
}

$userId = isset($_SESSION['userId']) ? (int) $_SESSION['userId'] : 0;

// Fetch achievements and user progress from DB (fallback to empty)
$achievements = [];

$sql = "
    SELECT a.code, a.title, a.description, a.target_label, a.accent,
           up.progress_value, up.progress_label, up.status_label
    FROM achievements a
    LEFT JOIN user_achievement_progress up
      ON up.achievement_code = a.code AND up.user_id = $userId
    WHERE a.is_active = 1
    ORDER BY a.id ASC
";

if ($result = mysqli_query($koneksi, $sql)) {
    while ($row = mysqli_fetch_assoc($result)) {
        $progress = isset($row['progress_value']) ? (float) $row['progress_value'] : 0.0;
        $achievements[] = [
            'title' => $row['title'],
            'description' => $row['description'],
            'progress' => $progress,
            'progress_label' => $row['progress_label'] ?: '-',
            'status' => $row['status_label'] ?: '-',
            'target' => $row['target_label'],
            'accent' => $row['accent'],
            'code' => $row['code']
        ];
    }
    mysqli_free_result($result);
}

$total_achievements = count($achievements);
$completed_count = 0;
$progress_sum = 0;

foreach ($achievements as $item) {
    $progress_value = max(0, min(1, (float) ($item['progress'] ?? 0)));
    $progress_sum += $progress_value;
    if ($progress_value >= 1) {
        $completed_count++;
    }
}

$average_progress = $total_achievements > 0 ? $progress_sum / $total_achievements : 0;
$overall_percent = (int) round($average_progress * 100);
$completion_label = $total_achievements > 0 ? $completed_count . ' / ' . $total_achievements : '0';
$next_goal = 'Fokus selesaikan pencapaian berikutnya.';
$next_goal_title = $total_achievements > 0 ? $achievements[0]['title'] : '-';

foreach ($achievements as $item) {
    $value = max(0, min(1, (float) ($item['progress'] ?? 0)));
    if ($value < 1) {
        $next_goal_title = $item['title'];
        $next_goal = 'Fokus selesaikan ' . $item['title'] . ' untuk lencana berikutnya.';
        break;
    }
}

if ($completed_count === $total_achievements && $total_achievements > 0) {
    $next_goal_title = 'Selesai';
    $next_goal = 'Semua pencapaian sudah tuntas.';
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/icons/thumbnail.png" type="image/png">
    <title>Achievement - Galaxy Explorer</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/achievement.css">
</head>

<body>
    <div class="container login-page">
        <div class="bg"></div>
    </div>

    <div class="achievement-page">
        <a href="dashboard.php" class="back-btn">
            <img src="../assets/icons/ui/back.png" class="icon" alt="Back">Back
        </a>

        <section class="achievements-hero">
            <div class="hero-copy">
                <p class="inner-shadow">Galaxy Explorer</p>
                <h1 class="hero-title">Achievement Board</h1>
                <p class="hero-subtitle">Pantau progres belajarmu, kumpulkan lencana, dan lanjutkan perjalanan di
                    Planetarium.</p>
                <div class="hero-metrics">
                    <div class="metric-card">
                        <div class="metric-label">Selesai</div>
                        <div class="metric-value"><?php echo htmlspecialchars($completion_label); ?></div>
                        <div class="metric-note">Total pencapaian</div>
                    </div>
                    <div class="metric-card">
                        <div class="metric-label">Rata-rata progres</div>
                        <div class="metric-value"><?php echo htmlspecialchars($overall_percent); ?>%</div>
                        <div class="metric-note">Semua pencapaian</div>
                    </div>
                    <div class="metric-card">
                        <div class="metric-label">Next goal</div>
                        <div class="metric-value"><?php echo htmlspecialchars($next_goal_title); ?></div>
                        <div class="metric-note"><?php echo htmlspecialchars($next_goal); ?></div>
                    </div>
                </div>
            </div>
            <div class="hero-badge">
                <div class="badge-label">Current tier</div>
                <div class="badge-rank">Rising Astronomer</div>
                <div class="badge-progress">
                    <div class="progress-track">
                        <div class="progress-fill" style="width: <?php echo $overall_percent; ?>%; --accent: #7dc4ff;">
                        </div>
                    </div>
                    <div class="progress-label">
                        <span>Progress keseluruhan</span>
                        <span><?php echo htmlspecialchars($overall_percent); ?>%</span>
                    </div>
                </div>
            </div>
        </section>

        <section class="achievements-grid">
            <?php foreach ($achievements as $achievement): ?>
                <?php
                $progress_value = max(0, min(1, (float) ($achievement['progress'] ?? 0)));
                $progress_percent = (int) round($progress_value * 100);
                ?>
                <article class="achievement-card"
                    style="--accent: <?php echo htmlspecialchars($achievement['accent']); ?>;">
                    <header class="card-header">
                        <h2 class="card-title inner-shadow"><?php echo htmlspecialchars($achievement['title']); ?></h2>
                    </header>
                    <div class="card-body">
                        <p class="card-desc"><?php echo htmlspecialchars($achievement['description']); ?></p>
                        <div class="progress-track">
                            <div class="progress-fill" style="width: <?php echo $progress_percent; ?>%"></div>
                        </div>
                        <div class="progress-label">
                            <span><?php echo htmlspecialchars($achievement['progress_label']); ?></span>
                            <span><?php echo htmlspecialchars($progress_percent); ?>%</span>
                        </div>
                        <div class="card-footer">
                            <div class="pill">
                                <span class="accent-label"><?php echo htmlspecialchars($achievement['target']); ?></span>
                            </div>
                            <div class="accent-dot"><?php echo htmlspecialchars($achievement['code']); ?></div>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </section>
    </div>
</body>

</html>