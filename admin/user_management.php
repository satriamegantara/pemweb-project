<?php
session_start();
include("../config/koneksi.php");

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../error.php");
    exit;
}

// Handle delete user
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['userId'])) {
    $userId = intval($_GET['userId']);

    // Prevent deleting self
    if ($userId === $_SESSION['userId']) {
        $error = "Tidak bisa menghapus akun admin sendiri!";
    } else {
        // Delete associated data first
        mysqli_query($koneksi, "DELETE FROM planet_history WHERE user_id = $userId");

        // Then delete the user
        $delete_query = "DELETE FROM login WHERE userId = $userId AND role = 'user'";
        $delete_result = mysqli_query($koneksi, $delete_query);

        if ($delete_result) {
            $success = "User berhasil dihapus!";
        } else {
            $error = "Gagal menghapus user: " . mysqli_error($koneksi);
        }
    }
}

// Get admin data
$admin_query = "SELECT * FROM login WHERE userId = '{$_SESSION['userId']}'";
$admin_result = mysqli_query($koneksi, $admin_query);
$admin_data = mysqli_fetch_assoc($admin_result);

// Get all users
$users_query = "SELECT l.userId, l.email, l.username, l.role, COUNT(ph.id) as total_views,
                (SELECT planet_name FROM planet_history 
                 WHERE user_id = l.userId 
                 GROUP BY planet_name 
                 ORDER BY COUNT(*) DESC 
                 LIMIT 1) as favorite_planet
                FROM login l 
                LEFT JOIN planet_history ph ON l.userId = ph.user_id 
                WHERE l.role = 'user' 
                GROUP BY l.userId, l.email, l.username, l.role
                ORDER BY l.userId DESC";
$users_result = mysqli_query($koneksi, $users_query);
$users = mysqli_fetch_all($users_result, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/icons/thumbnail.png" type="image/png">
    <title>User Management - Admin</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/admin-dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .user-table-container {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(212, 175, 55, 0.3);
            border-radius: 15px;
            padding: 25px;
            margin-top: 20px;
            overflow-x: auto;
        }

        .user-table {
            width: 100%;
            border-collapse: collapse;
            font-family: "Ubuntu Mono Regular", monospace;
        }

        .user-table thead {
            border-bottom: 2px solid rgba(212, 175, 55, 0.5);
        }

        .user-table th {
            padding: 15px;
            text-align: left;
            color: #d4af37;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 1px;
        }

        .user-table td {
            padding: 15px;
            border-bottom: 1px solid rgba(212, 175, 55, 0.2);
            color: #f7f1da;
        }

        .user-table tbody tr:hover {
            background: rgba(212, 175, 55, 0.08);
            transition: all 0.3s ease;
        }

        .user-id {
            color: #d4af37;
            font-weight: 600;
        }

        .role-badge {
            display: inline-block;
            padding: 5px 12px;
            background: rgba(212, 175, 55, 0.2);
            border: 1px solid rgba(212, 175, 55, 0.4);
            border-radius: 8px;
            font-size: 11px;
            text-transform: uppercase;
            color: #d4af37;
        }

        .view-count {
            background: rgba(12, 150, 200, 0.15);
            padding: 5px 12px;
            border-radius: 8px;
            color: #5dade2;
            font-weight: 600;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
        }

        .btn-delete {
            padding: 8px 12px;
            background: linear-gradient(135deg, rgba(220, 53, 69, 0.6), rgba(185, 28, 28, 0.7));
            color: #fff;
            border: 1px solid rgba(220, 53, 69, 0.5);
            border-radius: 8px;
            cursor: pointer;
            font-size: 12px;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .btn-delete:hover {
            background: linear-gradient(135deg, rgba(220, 53, 69, 0.9), rgba(185, 28, 28, 1));
            box-shadow: 0 8px 20px rgba(220, 53, 69, 0.3);
            transform: translateY(-2px);
        }

        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #a8a8a8;
        }

        .empty-state i {
            font-size: 48px;
            margin-bottom: 15px;
            opacity: 0.6;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: linear-gradient(135deg, rgba(212, 175, 55, 0.1), rgba(195, 119, 12, 0.1));
            border: 1px solid rgba(212, 175, 55, 0.3);
            border-radius: 12px;
            padding: 20px;
            text-align: center;
        }

        .stat-card h4 {
            color: #a8a8a8;
            font-size: 12px;
            text-transform: uppercase;
            margin-bottom: 10px;
            letter-spacing: 1px;
        }

        .stat-card .number {
            font-size: 32px;
            color: #d4af37;
            font-weight: 600;
        }

        .alert {
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-family: "Ubuntu Mono Regular", monospace;
        }

        .alert-success {
            background: rgba(76, 175, 80, 0.15);
            border: 1px solid rgba(76, 175, 80, 0.3);
            color: #81c784;
        }

        .alert-danger {
            background: rgba(220, 53, 69, 0.15);
            border: 1px solid rgba(220, 53, 69, 0.3);
            color: #ef5350;
        }
    </style>
</head>

<body>
    <div class="bg" style=""></div>
    <div class="admin-layout">
        <div class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <h3>admin dashboard</h3>
            </div>

            <ul class="sidebar-menu">
                <li><a href="dashboard.php"><i class="fas fa-home"></i> dashboard</a></li>
                <li><a href="edit_profile.php"><i class="fas fa-user-edit"></i> edit profile</a></li>
                <li><a href="add_content.php"><i class="fas fa-plus-circle"></i> add content</a></li>
                <li><a href="update_content.php"><i class="fas fa-edit"></i> update content</a></li>
                <li><a href="user_management.php" class="active"><i class="fas fa-users"></i> user management</a></li>
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
                    <h2 class="inner-shadow">user management</h2>
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
                <?php if (isset($success)): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        <span><?php echo htmlspecialchars($success); ?></span>
                    </div>
                <?php endif; ?>

                <?php if (isset($error)): ?>
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle"></i>
                        <span><?php echo htmlspecialchars($error); ?></span>
                    </div>
                <?php endif; ?>

                <div class="stats-grid">
                    <div class="stat-card">
                        <h4>total users</h4>
                        <div class="number"><?php echo count($users); ?></div>
                    </div>
                    <div class="stat-card">
                        <h4>total views</h4>
                        <div class="number">
                            <?php
                            $total_views = 0;
                            foreach ($users as $user) {
                                $total_views += $user['total_views'];
                            }
                            echo $total_views;
                            ?>
                        </div>
                    </div>
                    <div class="stat-card">
                        <h4>avg views per user</h4>
                        <div class="number">
                            <?php
                            if (count($users) > 0) {
                                echo round($total_views / count($users), 1);
                            } else {
                                echo "0";
                            }
                            ?>
                        </div>
                    </div>
                </div>

                <div class="user-table-container">
                    <?php if (count($users) > 0): ?>
                        <table class="user-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Most Viewed Planet</th>
                                    <th>Total Views</th>
                                    <th>Joined</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $user): ?>
                                    <tr>
                                        <td><span class="user-id">#<?php echo $user['userId']; ?></span></td>
                                        <td><?php echo htmlspecialchars($user['username']); ?></td>
                                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                                        <td><span
                                                class="role-badge"><?php echo htmlspecialchars($user['favorite_planet'] ?? '-'); ?></span>
                                        </td>
                                        <td><span class="view-count"><?php echo $user['total_views']; ?> views</span></td>
                                        <td>-</td>
                                        <td>
                                            <div class="action-buttons">
                                                <a href="?action=delete&userId=<?php echo $user['userId']; ?>"
                                                    class="btn-delete"
                                                    onclick="return confirm('Yakin ingin menghapus user ini? Semua data view history akan dihapus.');">
                                                    <i class="fas fa-trash"></i> Delete
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <div class="empty-state">
                            <i class="fas fa-users"></i>
                            <h3>Tidak ada user</h3>
                            <p>Belum ada user yang terdaftar di sistem.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/js/admin-dashboard.js"></script>
</body>

</html>