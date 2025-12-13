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
$initials = strtoupper(substr($admin_data['username'], 0, 1));

$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($email)) {
        $error = "Username dan Email harus diisi!";
    } else {
        if (!empty($password)) {
            $update_query = "UPDATE login SET username = '$username', email = '$email', password = '$password' WHERE userId = '{$_SESSION['userId']}'";
        } else {
            $update_query = "UPDATE login SET username = '$username', email = '$email' WHERE userId = '{$_SESSION['userId']}'";
        }

        if (mysqli_query($koneksi, $update_query)) {
            $_SESSION['username'] = $username;
            $success = "Profile berhasil diperbarui!";

            $admin_result = mysqli_query($koneksi, $admin_query);
            $admin_data = mysqli_fetch_assoc($admin_result);
        } else {
            $error = "Error: " . mysqli_error($koneksi);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/icons/thumbnail.png" type="image/png">
    <title>Edit Profile - Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/admin-dashboard.css">
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
                <li><a href="edit_profile.php" class="active"><i class="fas fa-user-edit"></i> edit profile</a></li>
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
                    <h2 class="inner-shadow">edit profile</h2>
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
                <div class="edit-profile-card admin-edit-card">
                    <div class="profile-header">
                        <div class="profile-avatar"><?php echo htmlspecialchars($initials); ?></div>
                        <h2 class="profile-title inner-shadow">edit profile admin</h2>
                    </div>

                    <?php if (!empty($success)): ?>
                        <div class="success-message"><?php echo htmlspecialchars($success); ?></div>
                    <?php endif; ?>

                    <?php if (!empty($error)): ?>
                        <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
                    <?php endif; ?>

                    <form method="POST" action="" class="edit-profile-form">
                        <div class="form-group-edit">
                            <label for="username" class="profile-label">username</label>
                            <input type="text" id="username" name="username" class="edit-input"
                                value="<?php echo htmlspecialchars($admin_data['username']); ?>" required>
                        </div>

                        <div class="form-group-edit">
                            <label for="email" class="profile-label">email address</label>
                            <input type="email" id="email" name="email" class="edit-input"
                                value="<?php echo htmlspecialchars($admin_data['email'] ?? ''); ?>">
                        </div>

                        <div class="divider"></div>
                        <p class="section-title">Change Password (Optional)</p>

                        <div class="form-group-edit">
                            <label for="password" class="profile-label">new password</label>
                            <input type="password" id="password" name="password" class="edit-input"
                                placeholder="Password">
                        </div>

                        <div class="profile-actions">
                            <button type="submit" class="profile-btn edit-btn">Save</button>
                            <a href="dashboard.php" class="profile-btn back-btn">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/js/admin-dashboard.js"></script>
</body>

</html>