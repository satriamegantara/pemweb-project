<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'user') {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

include '../config/koneksi.php';

$userId = (int) $_SESSION['userId'];
$scorePercent = isset($_POST['score']) ? (int) $_POST['score'] : 0;
$duration = isset($_POST['duration']) ? (int) $_POST['duration'] : 0;

// Validate input
if ($scorePercent < 0 || $scorePercent > 100) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid score']);
    exit;
}

// Save quiz result
$stmt = $koneksi->prepare("
    INSERT INTO quiz_results (user_id, score_percent, duration_seconds)
    VALUES (?, ?, ?)
");

if (!$stmt) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database error']);
    exit;
}

$stmt->bind_param('iii', $userId, $scorePercent, $duration);

if ($stmt->execute()) {
    // Update achievement progress for 'Quiz Master'
    updateQuizMasterAchievement($koneksi, $userId);

    echo json_encode([
        'success' => true,
        'message' => 'Quiz result saved successfully',
        'score' => $scorePercent
    ]);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Failed to save result']);
}

$stmt->close();

function updateQuizMasterAchievement($koneksi, $userId)
{
    // Get all quiz results with score >= 80
    $result = $koneksi->query("
        SELECT COUNT(*) as count_high_scores
        FROM quiz_results
        WHERE user_id = $userId AND score_percent >= 80
    ");

    if ($result) {
        $row = $result->fetch_assoc();
        $highScoreCount = $row['count_high_scores'];

        // Check if progress already exists
        $checkResult = $koneksi->query("
            SELECT id FROM user_achievement_progress
            WHERE user_id = $userId AND achievement_code = 'QM'
        ");

        if ($checkResult && $checkResult->num_rows > 0) {
            // Update existing progress
            $koneksi->query("
                UPDATE user_achievement_progress
                SET progress_value = LEAST(1.0, $highScoreCount / 5.0),
                    progress_label = '$highScoreCount / 5 skor >= 80%',
                    status_label = " . ($highScoreCount >= 5 ? "'Gold Quiz Master'" : "'Silver Quiz Master'") . ",
                    updated_at = NOW()
                WHERE user_id = $userId AND achievement_code = 'QM'
            ");
        } else {
            // Insert new progress
            $progressValue = min(1.0, $highScoreCount / 5.0);
            $statusLabel = $highScoreCount >= 5 ? 'Gold Quiz Master' : 'Silver Quiz Master';
            $progressLabel = "$highScoreCount / 5 skor >= 80%";

            $koneksi->query("
                INSERT INTO user_achievement_progress (user_id, achievement_code, progress_value, progress_label, status_label)
                VALUES ($userId, 'QM', $progressValue, '$progressLabel', '$statusLabel')
            ");
        }
    }
}
?>