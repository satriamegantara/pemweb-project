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

// Create announcements table if not exists
$create_table_sql = "CREATE TABLE IF NOT EXISTS announcements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NULL,
    content TEXT NOT NULL,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    start_at TIMESTAMP NULL,
    end_at TIMESTAMP NULL,
    created_by INT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES login(userId) ON DELETE SET NULL
) ENGINE=InnoDB";
mysqli_query($koneksi, $create_table_sql);

// Get announcement count
$announcement_query = "SELECT COUNT(*) as total FROM announcements WHERE is_active = 1";
$announcement_result = mysqli_query($koneksi, $announcement_query);
$announcement_count = mysqli_fetch_assoc($announcement_result)['total'] ?? 0;

// Get all announcements for popup
$announcements_query = "SELECT id, title, content, created_at FROM announcements WHERE is_active = 1 ORDER BY created_at DESC";
$announcements_result = mysqli_query($koneksi, $announcements_query);
$announcements = mysqli_fetch_all($announcements_result, MYSQLI_ASSOC);
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .message-btn {
            position: fixed;
            top: 20px;
            right: 180px;
            width: 45px;
            height: 45px;
            padding: 0;
            font-size: 20px;
            color: #ffffff;
            background: rgba(255, 255, 255, 0.3);
            border: 2px solid rgba(0, 0, 0, 0.1);
            border-radius: 50px;
            cursor: pointer;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            transition: all 0.4s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            z-index: 50;
        }

        .message-btn:hover {
            background: rgba(255, 255, 255, 0.18);
            border: 2px solid rgba(255, 255, 255, 0.05);
            box-shadow: 0 0 32px 8px rgba(255, 255, 255, 0.18), 0 2px 12px rgba(0, 0, 0, 0.12);
            text-shadow: 0 0 10px #fff, 0 0 2px #fff;
            backdrop-filter: blur(16px) saturate(180%);
            -webkit-backdrop-filter: blur(16px) saturate(180%);
        }

        .badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #ff4757;
            color: white;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: bold;
            border: 2px solid rgba(255, 71, 87, 0.5);
            animation: badgePulse 2s infinite;
        }

        @keyframes badgePulse {

            0%,
            100% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(255, 71, 87, 0.7);
            }

            50% {
                transform: scale(1.05);
                box-shadow: 0 0 0 8px rgba(255, 71, 87, 0);
            }
        }

        .notification-popup {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.85);
            z-index: 1000;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(8px);
            animation: fadeIn 0.3s ease;
        }

        .notification-popup.active {
            display: flex;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .popup-content {
            background: rgba(255, 255, 255, 0.15);
            border: 2px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 35px;
            max-width: 550px;
            width: 90%;
            max-height: 75vh;
            overflow-y: auto;
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            box-shadow:
                0 8px 32px rgba(0, 0, 0, 0.5),
                0 0 48px rgba(106, 200, 255, 0.15),
                inset 0 1px 0 rgba(255, 255, 255, 0.2);
            animation: popupSlideIn 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        @keyframes popupSlideIn {
            from {
                transform: translateY(-30px) scale(0.95);
                opacity: 0;
            }

            to {
                transform: translateY(0) scale(1);
                opacity: 1;
            }
        }

        .popup-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 25px;
            padding-bottom: 20px;
            border-bottom: 2px solid rgba(255, 255, 255, 0.1);
        }

        .popup-header h2 {
            color: #ffffff;
            font-size: 26px;
            font-family: "Ubuntu Mono Regular", monospace;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 12px;
            text-transform: uppercase;
            letter-spacing: 2px;
            text-shadow:
                0 0 20px rgba(255, 255, 255, 0.5),
                0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .popup-header h2 i {
            color: #ff9f43;
            filter: drop-shadow(0 0 10px rgba(255, 159, 67, 0.6));
        }

        .popup-close {
            background: rgba(255, 255, 255, 0.2);
            border: 2px solid rgba(255, 255, 255, 0.1);
            color: #fff;
            width: 42px;
            height: 42px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 24px;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            transition: all 0.4s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .popup-close:hover {
            background: rgba(255, 255, 255, 0.3);
            border-color: rgba(255, 255, 255, 0.2);
            transform: rotate(90deg);
            box-shadow:
                0 0 20px rgba(255, 255, 255, 0.3),
                0 2px 8px rgba(0, 0, 0, 0.2);
        }

        .notification-item {
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 18px;
            margin-bottom: 15px;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            transition: all 0.4s ease;
        }

        .notification-item:hover {
            background: rgba(255, 255, 255, 0.15);
            border-color: rgba(255, 255, 255, 0.2);
            transform: translateX(5px);
            box-shadow:
                0 4px 16px rgba(0, 0, 0, 0.2),
                0 0 24px rgba(106, 200, 255, 0.2);
        }

        .notification-item h3 {
            color: #ffffff;
            font-size: 17px;
            font-family: "Ubuntu Mono Regular", monospace;
            margin: 0 0 12px 0;
            display: flex;
            align-items: center;
            gap: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
            text-shadow: 0 0 10px rgba(255, 255, 255, 0.3);
        }

        .notification-item h3 i {
            color: #6ac8ff;
            filter: drop-shadow(0 0 8px rgba(106, 200, 255, 0.6));
        }

        .notification-item p {
            color: rgba(255, 255, 255, 0.9);
            font-size: 14px;
            margin: 0 0 12px 0;
            line-height: 1.6;
            font-family: "Ubuntu Mono Regular", monospace;
        }

        .notification-date {
            color: rgba(255, 255, 255, 0.5);
            font-size: 12px;
            font-family: "Ubuntu Mono Regular", monospace;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .notification-date i {
            opacity: 0.7;
        }

        .empty-notification {
            text-align: center;
            color: rgba(255, 255, 255, 0.6);
            padding: 50px 20px;
        }

        .empty-notification i {
            font-size: 60px;
            color: rgba(255, 255, 255, 0.2);
            display: block;
            margin-bottom: 20px;
            filter: drop-shadow(0 0 20px rgba(255, 255, 255, 0.1));
        }

        .empty-notification p {
            font-size: 16px;
            font-family: "Ubuntu Mono Regular", monospace;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(106, 200, 255, 0.1);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(106, 200, 255, 0.3);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: rgba(106, 200, 255, 0.5);
        }
    </style>
</head>

<body>
    <div class="container login-page">
        <div class="bg"></div>
    </div>
    <div class="content-dashboard">
        <button class="message-btn" id="notificationBtn" title="Lihat Pengumuman">
            <i class="fas fa-bell"></i>
            <?php if ($announcement_count > 0): ?>
                <span class="badge"><?php echo $announcement_count; ?></span>
            <?php endif; ?>
        </button>
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

    <!-- Notification Popup -->
    <div class="notification-popup" id="notificationPopup">
        <div class="popup-content">
            <div class="popup-header">
                <h2><i class="fas fa-bell"></i> Pengumuman</h2>
                <button class="popup-close" id="closePopup">&times;</button>
            </div>

            <?php if (!empty($announcements)): ?>
                <?php foreach ($announcements as $announcement): ?>
                    <div class="notification-item">
                        <h3>
                            <i class="fas fa-bullhorn"></i>
                            <?php echo htmlspecialchars($announcement['title'] ?: 'Pengumuman'); ?>
                        </h3>
                        <p><?php echo nl2br(htmlspecialchars($announcement['content'])); ?></p>
                        <div class="notification-date">
                            <i class="fas fa-calendar"></i>
                            <?php echo date('d M Y H:i', strtotime($announcement['created_at'])); ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="empty-notification">
                    <i class="fas fa-inbox"></i>
                    <p>Tidak ada pengumuman</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        const notificationBtn = document.getElementById('notificationBtn');
        const notificationPopup = document.getElementById('notificationPopup');
        const closePopup = document.getElementById('closePopup');

        notificationBtn.addEventListener('click', () => {
            notificationPopup.classList.add('active');
        });

        closePopup.addEventListener('click', () => {
            notificationPopup.classList.remove('active');
        });

        notificationPopup.addEventListener('click', (e) => {
            if (e.target === notificationPopup) {
                notificationPopup.classList.remove('active');
            }
        });
    </script>
</body>

</html>