<?php
session_start();

header('Content-Type: application/json');

try {
    include '../config/koneksi.php';

    // Check if user is logged in
    if (!isset($_SESSION['userId'])) {
        echo json_encode(['success' => false, 'message' => 'User not logged in']);
        exit;
    }

    // Get data from JSON
    $json_data = json_decode(file_get_contents('php://input'), true);

    if (!isset($json_data['planet_name']) || !isset($json_data['duration_seconds'])) {
        echo json_encode(['success' => false, 'message' => 'Missing required fields']);
        exit;
    }

    $user_id = $_SESSION['userId'];
    $planet_name = htmlspecialchars($json_data['planet_name'], ENT_QUOTES, 'UTF-8');
    $duration_seconds = (int) $json_data['duration_seconds'];
    $is_final = isset($json_data['is_final']) ? (bool) $json_data['is_final'] : false;

    // Threshold untuk achievement (dalam detik)
    // 120 detik = 2 menit untuk Bronze
    // 300 detik = 5 menit untuk Silver
    // 600 detik = 10 menit untuk Gold

    if ($is_final && $duration_seconds > 0) {
        // Update planet history dengan duration
        $query = "UPDATE planet_history SET duration_seconds = ? 
                  WHERE user_id = ? AND planet_name = ? 
                  ORDER BY view_time DESC LIMIT 1";
        $stmt = $koneksi->prepare($query);

        if ($stmt) {
            $stmt->bind_param('iis', $duration_seconds, $user_id, $planet_name);
            $stmt->execute();
            $stmt->close();
        }

        // Check for achievement
        $achievement_gained = checkExplorerAchievement($koneksi, $user_id, $duration_seconds, $planet_name);

        echo json_encode([
            'success' => true,
            'message' => 'Duration recorded',
            'duration' => $duration_seconds,
            'achievement' => $achievement_gained
        ]);
    } else {
        echo json_encode(['success' => true, 'message' => 'Duration tracked']);
    }

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

function checkExplorerAchievement($koneksi, $user_id, $duration_seconds, $planet_name)
{
    // Count total unique planets visited with duration >= 120 seconds
    $query = "SELECT COUNT(DISTINCT planet_name) as total_planets
              FROM planet_history 
              WHERE user_id = ? AND duration_seconds >= 120";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $total_planets = $row['total_planets'] ?? 0;
    $stmt->close();

    $achievement_status = '';

    // Check for milestones
    if ($total_planets >= 20) {
        $achievement_status = 'Gold Explorer';
        updateOrInsertProgress($koneksi, $user_id, 'EXP', 1.0, "{$total_planets} / 20 kunjungan planet", 'Gold Pathfinder');
    } elseif ($total_planets >= 10) {
        $achievement_status = 'Silver Explorer';
        updateOrInsertProgress($koneksi, $user_id, 'EXP', 0.5, "{$total_planets} / 20 kunjungan planet", 'Silver Pathfinder');
    } elseif ($total_planets >= 5) {
        $achievement_status = 'Bronze Explorer';
        updateOrInsertProgress($koneksi, $user_id, 'EXP', 0.25, "{$total_planets} / 20 kunjungan planet", 'Bronze Pathfinder');
    } else {
        updateOrInsertProgress($koneksi, $user_id, 'EXP', $total_planets / 20, "{$total_planets} / 20 kunjungan planet", '-');
    }

    return $achievement_status;
}

function updateOrInsertProgress($koneksi, $user_id, $achievement_code, $progress_value, $progress_label, $status_label)
{
    $progress_value = max(0, min(1, $progress_value)); // Clamp between 0-1

    $query = "INSERT INTO user_achievement_progress (user_id, achievement_code, progress_value, progress_label, status_label)
              VALUES (?, ?, ?, ?, ?)
              ON DUPLICATE KEY UPDATE 
                  progress_value = VALUES(progress_value),
                  progress_label = VALUES(progress_label),
                  status_label = VALUES(status_label),
                  updated_at = CURRENT_TIMESTAMP";

    $stmt = $koneksi->prepare($query);
    if ($stmt) {
        $stmt->bind_param('isdss', $user_id, $achievement_code, $progress_value, $progress_label, $status_label);
        $stmt->execute();
        $stmt->close();
    }
}
?>