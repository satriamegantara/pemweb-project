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

    // Get planet name from POST or JSON
    $planet_name = null;

    // Check for JSON data
    $json_data = json_decode(file_get_contents('php://input'), true);
    if (isset($json_data['planet_name'])) {
        $planet_name = $json_data['planet_name'];
    }
    // Fall back to POST data
    elseif (isset($_POST['planet_name'])) {
        $planet_name = $_POST['planet_name'];
    }

    if (!$planet_name) {
        echo json_encode(['success' => false, 'message' => 'Planet name required']);
        exit;
    }

    $user_id = $_SESSION['userId'];
    $planet_name = htmlspecialchars($planet_name, ENT_QUOTES, 'UTF-8');

    // Insert into planet_history (tanpa duration)
    $query = "INSERT INTO planet_history (user_id, planet_name) VALUES (?, ?)";
    $stmt = $koneksi->prepare($query);

    if (!$stmt) {
        echo json_encode(['success' => false, 'message' => 'Prepare statement failed', 'error' => $koneksi->error]);
        exit;
    }

    $stmt->bind_param('is', $user_id, $planet_name);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Planet view recorded']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to record view', 'error' => $stmt->error]);
    }

    $stmt->close();
    $koneksi->close();

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Exception occurred', 'error' => $e->getMessage()]);
}
?>