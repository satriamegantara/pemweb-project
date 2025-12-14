<?php
session_start();
include("../config/koneksi.php");

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../error.php");
    exit;
}

$admin_query = "SELECT * FROM login WHERE userId = '{$_SESSION['userId']}'";
$admin_result = mysqli_query($koneksi, $admin_query);
$admin_data = mysqli_fetch_assoc($admin_result);

// Ensure announcements table exists
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

$success = null;
$error = null;

// Flash messages (PRG pattern)
if (isset($_SESSION['flash_success'])) {
    $success = $_SESSION['flash_success'];
    unset($_SESSION['flash_success']);
}
if (isset($_SESSION['flash_error'])) {
    $error = $_SESSION['flash_error'];
    unset($_SESSION['flash_error']);
}

// Handle POST actions BEFORE ANY OUTPUT
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create'])) {
    $title = isset($_POST['title']) ? mysqli_real_escape_string($koneksi, $_POST['title']) : null;
    $content = mysqli_real_escape_string($koneksi, $_POST['content']);
    $is_active = isset($_POST['is_active']) ? 1 : 0;
    $start_at = !empty($_POST['start_at']) ? mysqli_real_escape_string($koneksi, $_POST['start_at']) : null;
    $end_at = !empty($_POST['end_at']) ? mysqli_real_escape_string($koneksi, $_POST['end_at']) : null;

    if ($is_active) {
        mysqli_query($koneksi, "UPDATE announcements SET is_active = 0");
    }

    $insert_sql = sprintf(
        "INSERT INTO announcements(title, content, is_active, start_at, end_at, created_by) VALUES(%s, '%s', %d, %s, %s, %d)",
        $title ? "'" . $title . "'" : "NULL",
        $content,
        $is_active,
        $start_at ? "'" . $start_at . "'" : "NULL",
        $end_at ? "'" . $end_at . "'" : "NULL",
        intval($_SESSION['userId'])
    );

    if (mysqli_query($koneksi, $insert_sql)) {
        $_SESSION['flash_success'] = "Announcement created";
        header("Location: review_report.php");
        exit;
    } else {
        $error = "Failed: " . mysqli_error($koneksi);
    }
}

// Handle GET actions
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    if ($_GET['action'] === 'activate') {
        mysqli_query($koneksi, "UPDATE announcements SET is_active = 0");
        mysqli_query($koneksi, "UPDATE announcements SET is_active = 1 WHERE id = $id");
        $success = "Announcement activated";
    } elseif ($_GET['action'] === 'deactivate') {
        mysqli_query($koneksi, "UPDATE announcements SET is_active = 0 WHERE id = $id");
        $success = "Announcement deactivated";
    } elseif ($_GET['action'] === 'delete') {
        mysqli_query($koneksi, "DELETE FROM announcements WHERE id = $id");
        $success = "Announcement deleted";
    }
}

// Fetch data
$active_sql = "SELECT * FROM announcements WHERE is_active = 1 ORDER BY created_at DESC LIMIT 1";
$active_result = mysqli_query($koneksi, $active_sql);
$active = mysqli_fetch_assoc($active_result);

$list_sql = "SELECT * FROM announcements ORDER BY created_at DESC LIMIT 100";
$list_result = mysqli_query($koneksi, $list_sql);
$announcements = mysqli_fetch_all($list_result, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/icons/thumbnail.png" type="image/png">
    <title>Announcements - Admin</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/admin-dashboard.css">
    <link rel="stylesheet" href="../assets/css/announcement.css">
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
                <li><a href="dashboard.php"><i class="fas fa-home"></i> dashboard</a></li>
                <li><a href="edit_profile.php"><i class="fas fa-user-edit"></i> edit profile</a></li>
                <li><a href="add_content.php"><i class="fas fa-plus-circle"></i> add content</a></li>
                <li><a href="update_content.php"><i class="fas fa-edit"></i> update content</a></li>
                <li><a href="user_management.php"><i class="fas fa-users"></i> user management</a></li>
                <li><a href="review_report.php" class="active"><i class="fas fa-bullhorn"></i> announcement</a></li>
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
                    <h2 class="inner-shadow">announcement</h2>
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
                <?php if ($success): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        <span><?php echo htmlspecialchars($success); ?></span>
                    </div>
                <?php endif; ?>
                <?php if ($error): ?>
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle"></i>
                        <span><?php echo htmlspecialchars($error); ?></span>
                    </div>
                <?php endif; ?>

                <div class="welcome-box">
                    <h2 class="inner-shadow">current announcement</h2>
                    <?php if ($active): ?>
                        <div class="announcement-card">
                            <div class="announcement-header">
                                <i class="fas fa-bullhorn"></i>
                                <strong>Active Announcement</strong>
                            </div>
                            <?php if (!empty($active['title'])): ?>
                                <h3 class="announcement-title"><?php echo htmlspecialchars($active['title']); ?></h3>
                            <?php endif; ?>
                            <div class="announcement-content">
                                <?php echo nl2br(htmlspecialchars($active['content'])); ?>
                            </div>
                            <div class="announcement-meta">
                                Published: <?php echo date('d M Y H:i', strtotime($active['created_at'])); ?>
                                <?php if ($active['start_at']): ?>
                                    | Start: <?php echo date('d M Y H:i', strtotime($active['start_at'])); ?>
                                <?php endif; ?>
                                <?php if ($active['end_at']): ?>
                                    | End: <?php echo date('d M Y H:i', strtotime($active['end_at'])); ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="empty-state">
                            <i class="fas fa-bullhorn"></i>
                            <p>Tidak ada announcement aktif.</p>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="welcome-box" style="margin-top:30px;">
                    <h2 class="inner-shadow">create announcement</h2>
                    <form method="post" class="form-card">
                        <div class="form-group">
                            <label>Title (optional)</label>
                            <input type="text" name="title" class="form-control"
                                placeholder="Enter announcement title..." />
                        </div>
                        <div class="form-group">
                            <label>Content</label>
                            <textarea name="content" class="form-control" required
                                placeholder="Enter announcement content..."></textarea>
                        </div>
                        <div class="form-group">
                            <div class="form-inline-group">
                                <label class="checkbox-label">
                                    <input type="checkbox" name="is_active" checked />
                                    <span>Set as active announcement</span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Schedule (optional)</label>
                            <div class="datetime-group">
                                <input type="datetime-local" name="start_at" class="datetime-input"
                                    placeholder="Start date" />
                                <input type="datetime-local" name="end_at" class="datetime-input"
                                    placeholder="End date" />
                            </div>
                        </div>
                        <button type="submit" name="create" class="btn-primary">
                            <i class="fas fa-paper-plane"></i>
                            <span>Publish Announcement</span>
                        </button>
                    </form>
                </div>

                <div class="user-table-container" style="margin-top:30px;">
                    <h2 class="inner-shadow" style="margin-bottom:20px; color: black;">announcement history</h2>
                    <?php if (count($announcements) > 0): ?>
                        <table class="user-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Start</th>
                                    <th>End</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($announcements as $a): ?>
                                    <tr>
                                        <td><span class="user-id">#<?php echo $a['id']; ?></span></td>
                                        <td><?php echo htmlspecialchars($a['title'] ?? '-'); ?></td>
                                        <td>
                                            <?php if ($a['is_active']): ?>
                                                <span class="role-badge"
                                                    style="background: rgba(76, 175, 80, 0.2); border-color: rgba(76, 175, 80, 0.4); color: #81c784;">
                                                    <i class="fas fa-check-circle"></i> Active
                                                </span>
                                            <?php else: ?>
                                                <span class="role-badge" style="opacity: 0.6;">
                                                    <i class="fas fa-times-circle"></i> Inactive
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo $a['created_at'] ? date('d M Y H:i', strtotime($a['created_at'])) : '-'; ?>
                                        </td>
                                        <td><?php echo $a['start_at'] ? date('d M Y', strtotime($a['start_at'])) : '-'; ?></td>
                                        <td><?php echo $a['end_at'] ? date('d M Y', strtotime($a['end_at'])) : '-'; ?></td>
                                        <td>
                                            <div class="action-buttons">
                                                <?php if ($a['is_active']): ?>
                                                    <a class="btn-delete" href="?action=deactivate&id=<?php echo $a['id']; ?>"
                                                        onclick="return confirm('Deactivate this announcement?');">
                                                        <i class="fas fa-eye-slash"></i> Deactivate
                                                    </a>
                                                <?php else: ?>
                                                    <a class="btn-activate" href="?action=activate&id=<?php echo $a['id']; ?>"
                                                        onclick="return confirm('Activate this announcement? It will disable other active ones.');">
                                                        <i class="fas fa-bullhorn"></i> Activate
                                                    </a>
                                                <?php endif; ?>
                                                <a class="btn-delete" href="?action=delete&id=<?php echo $a['id']; ?>"
                                                    onclick="return confirm('Delete this announcement permanently?');">
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
                            <i class="fas fa-inbox"></i>
                            <p>No announcements created yet.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/js/admin-dashboard.js"></script>
</body>

</html>