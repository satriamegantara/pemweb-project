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
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/icons/thumbnail.png" type="image/png">
    <title>Galaxy Explorer</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/user-dashboard.css">
</head>

<body>
    <div class="container login-page">
        <div class="bg"></div>
    </div>
    <div class="content-dashboard">
        <a href="../auth/logout.php" class="logout-btn">
            <img src="../assets/icons/ui/logout.png" class="icon" alt="Logout">Logout
        </a>
        <div class="planet-gallery">
            <div class="welcome-text inner-shadow">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!
            </div>
            <div class="planet-item" onclick="window.location.href='history.php'" data-name="Mercury">
                <img src="../assets/images/planets/mercury.webp" alt="Mercury">
                <span class="planet-caption">History</span>
            </div>
            <div class="planet-item" onclick="window.location.href='planetarium.php'" data-name="Venus">
                <img src="../assets/images/planets/venus.webp" alt="Venus">
                <span class="planet-caption">Planetarium</span>
            </div>
            <div class="planet-item" onclick="window.location.href='profile.php'" data-name="Earth">
                <img src="../assets/images/planets/earth.webp" alt="Earth">
                <span class="planet-caption">Profile</span>
            </div>
            <div class="planet-item" onclick="window.location.href='achievement.php'" data-name="Achievement">
                <img src="../assets/images/planets/mars.webp" alt="Achievement">
                <span class="planet-caption">Achievement</span>
            </div>
            <div class="planet-item" onclick="window.location.href='quiz.php'" data-name="Neptune">
                <img src="../assets/images/planets/jupiter.webp" alt="Neptune">
                <span class="planet-caption">Quiz</span>
            </div>
        </div>
    </div>
</body>

</html>