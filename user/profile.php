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

$username = htmlspecialchars($_SESSION['username']);
$email = "Not set";
$role = htmlspecialchars($_SESSION['role']);
$initials = strtolower(substr($username, 0, 1));

$success_message = "";
if (isset($_SESSION['success_message'])) {
    $success_message = $_SESSION['success_message'];
    unset($_SESSION['success_message']);
}

if (isset($_SESSION['userId'])) {
    $user_query = "SELECT * FROM login WHERE userId = '{$_SESSION['userId']}'";
    $user_result = mysqli_query($koneksi, $user_query);
    if ($user_result && mysqli_num_rows($user_result) > 0) {
        $user_data = mysqli_fetch_assoc($user_result);
        $username = htmlspecialchars($user_data['username']);
        $email = htmlspecialchars($user_data['email'] ?? 'Not set');
        $role = htmlspecialchars($user_data['role']);
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/icons/thumbnail.png" type="image/png">
    <title>My Profile - Galaxy Explorer</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/user-profile.css">
</head>

<body>
    <?php if ($success_message): ?>
        <div class="notification-popup" id="notificationPopup">
            <div class="notification-content">
                <span class="notification-icon">✓</span>
                <span class="notification-text"><?php echo $success_message; ?></span>
            </div>
        </div>
    <?php endif; ?>

    <div class="container login-page">
        <div class="bg"></div>
    </div>
    <div class="profile-container">
        <a href="dashboard.php" class="back-to-dashboard">
            <img src="../assets/icons/ui/back.png" class="icon"> Back
        </a>

        <a href="../auth/logout.php" class="logout-btn">
            <img src="../assets/icons/ui/logout.png" class="icon"> Logout
        </a>

        <div class="profile-card">
            <div class="profile-header">
                <div class="profile-avatar"><?php echo $initials; ?></div>
                <h1 class="profile-title"><?php echo $username; ?></h1>
                <p class="profile-subtitle">Explorer</p>
            </div>

            <div class="profile-details">
                <div class="profile-item">
                    <div class="profile-label">Username</div>
                    <div class="profile-value mono-value"><?php echo $username; ?></div>
                </div>

                <div class="profile-item">
                    <div class="profile-label">Email Address</div>
                    <div class="profile-value mono-value"><?php echo $email; ?></div>
                </div>

                <div class="profile-item">
                    <div class="profile-label">Account Type</div>
                    <div class="profile-value mono-value"><?php echo ucfirst($role); ?></div>
                </div>

                <div class="profile-item">
                    <div class="profile-label">Member Since</div>
                    <div class="profile-value mono-value">2025</div>
                </div>
            </div>

            <div class="profile-actions">
                <a href="edit_profile.php" class="profile-btn edit-btn">Edit Profile</a>
            </div>
        </div>
    </div>

    <script>
        // Auto hide notification after 3 seconds
        const notification = document.getElementById('notificationPopup');
        if (notification) {
            setTimeout(() => {
                notification.classList.add('fade-out');
                setTimeout(() => {
                    notification.remove();
                }, 500);
            }, 3000);
        }
    </script>
</body>

</html>