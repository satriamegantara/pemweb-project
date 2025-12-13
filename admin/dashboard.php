<?php
session_start();
include("../config/koneksi.php");

if (!isset($_SESSION['username']) || !isset($_SESSION['role'])) {
    header("Location: ../auth/login.php");
    exit;
}

if ($_SESSION['role'] !== 'admin') {
    header("Location: ../error.php");
    exit;
}

$admin_query = "SELECT * FROM login WHERE userId = '{$_SESSION['userId']}'";
$admin_result = mysqli_query($koneksi, $admin_query);
$admin_data = mysqli_fetch_assoc($admin_result);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/icons/thumbnail.png" type="image/png">
    <title>Admin Dashboard - Galaxy Explorer</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/admin-dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <div class="bg" style=""></div>
    <div class="admin-layout">
        <div class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <h3>admin dashboard</h3>
            </div>

            <ul class="sidebar-menu">
                <li><a href="dashboard.php" class="active"><i class="fas fa-home"></i> dashboard</a></li>
                <li><a href="edit_profile.php"><i class="fas fa-user-edit"></i> edit profile</a></li>
                <li><a href="add_content.php"><i class="fas fa-plus-circle"></i> add content</a></li>
                <li><a href="update_content.php"><i class="fas fa-edit"></i> update content</a></li>
                <li><a href="verify_user.php"><i class="fas fa-check-circle"></i> verify user</a></li>
                <li><a href="review_report.php"><i class="fas fa-file-alt"></i> review report</a></li>
            </ul>

            <div class="sidebar-footer">
                <a href="../auth/logout.php" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i> logout
                </a>
            </div>
        </div>

        <div class="main-content">
            <div class="topbar">
                <div class="topbar-left">
                    <button class="menu-toggle" id="menuToggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h2 class="inner-shadow">dashboard</h2>
                </div>

                <div class="topbar-right">
                    <div class="admin-profile">
                        <i class="fas fa-user-circle"></i>
                        <span><?php echo htmlspecialchars($admin_data['username']); ?></span>
                    </div>
                    <a href="edit_profile.php" class="edit-profile-link">edit profile</a>
                </div>
            </div>

            <div class="content-area">
                <div class="welcome-box">
                    <h2 class="inner-shadow">selamat datang,
                        <?php echo htmlspecialchars($admin_data['username']); ?>!
                    </h2>
                    <p>Anda login sebagai administrator. Gunakan menu di sebelah kiri untuk mengelola
                        konten, user, dan laporan.</p>

                    <div class="quick-stats">
                        <div class="stat-card">
                            <h4>total users</h4>
                            <div class="number">
                                <?php
                                $count_query = "SELECT COUNT(*) as total FROM login WHERE role = 'user'";
                                $count_result = mysqli_query($koneksi, $count_query);
                                $count_row = mysqli_fetch_assoc($count_result);
                                echo $count_row['total'];
                                ?>
                            </div>
                        </div>
                        <div class="stat-card">
                            <h4>admin users</h4>
                            <div class="number">
                                <?php
                                $admin_count_query = "SELECT COUNT(*) as total FROM login WHERE role = 'admin'";
                                $admin_count_result = mysqli_query($koneksi, $admin_count_query);
                                $admin_count_row = mysqli_fetch_assoc($admin_count_result);
                                echo $admin_count_row['total'];
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/js/admin-dashboard.js"></script>
</body>

</html>