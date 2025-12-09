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

$success_message = "";
$error_message = "";

// Ambil data user dari database
$username = htmlspecialchars($_SESSION['username']);
$email = "Not set";
$role = htmlspecialchars($_SESSION['role']);
$initials = strtoupper(substr($username, 0, 1));

if (isset($_SESSION['userId'])) {
    $user_query = "SELECT * FROM login WHERE userId = '{$_SESSION['userId']}'";
    $user_result = mysqli_query($koneksi, $user_query);
    if ($user_result && mysqli_num_rows($user_result) > 0) {
        $user_data = mysqli_fetch_assoc($user_result);
        $username = htmlspecialchars($user_data['username']);
        $email = htmlspecialchars($user_data['email'] ?? '');
        $role = htmlspecialchars($user_data['role']);
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_username = trim($_POST['username']);
    $new_email = trim($_POST['email']);
    $current_password = $_POST['current_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if (empty($new_username) || empty($new_email)) {
        $error_message = "Username and email are required";
    } elseif (!filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Invalid email format";
    } else {
        if (!empty($new_password)) {
            if (empty($current_password)) {
                $error_message = "Current password is required to change password";
            } elseif ($new_password !== $confirm_password) {
                $error_message = "New passwords do not match";
            } else {
                $check_query = "SELECT password FROM login WHERE userId = '{$_SESSION['userId']}'";
                $check_result = mysqli_query($koneksi, $check_query);
                if ($check_result && mysqli_num_rows($check_result) > 0) {
                    $user = mysqli_fetch_assoc($check_result);
                    if ($current_password === $user['password']) {
                        $update_query = "UPDATE login SET username = '$new_username', email = '$new_email', password = '$new_password' WHERE userId = '{$_SESSION['userId']}'";
                        if (mysqli_query($koneksi, $update_query)) {
                            $_SESSION['username'] = $new_username;
                            $_SESSION['success_message'] = "Profile and password updated successfully!";
                            header("Location: profile.php");
                            exit;
                        } else {
                            $error_message = "Failed to update profile";
                        }
                    } else {
                        $error_message = "Current password is incorrect";
                    }
                }
            }
        } else {
            // Update tanpa password
            $update_query = "UPDATE login SET username = '$new_username', email = '$new_email' WHERE userId = '{$_SESSION['userId']}'";
            if (mysqli_query($koneksi, $update_query)) {
                $_SESSION['username'] = $new_username;
                $_SESSION['success_message'] = "Profile updated successfully!";
                header("Location: profile.php");
                exit;
            } else {
                $error_message = "Failed to update profile";
            }
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
    <title>Edit Profile - Galaxy Explorer</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/user-profile.css">
</head>

<body>
    <div class="container login-page">
        <div class="bg"></div>
    </div>
    <div class="profile-container">
        <a href="profile.php" class="back-to-dashboard">
            <img src="../assets/icons/ui/back.png" class="icon"> Back
        </a>

        <a href="../auth/logout.php" class="logout-btn">
            <img src="../assets/icons/ui/logout.png" class="icon"> logout
        </a>

        <div class="profile-card">
            <div class="profile-header">
                <div class="profile-avatar"><?php echo $initials; ?></div>
                <h1 class="profile-title">Edit Profile</h1>
            </div>

            <?php if ($success_message): ?>
                <div class="alert alert-success"><?php echo $success_message; ?></div>
            <?php endif; ?>

            <?php if ($error_message): ?>
                <div class="alert alert-error"><?php echo $error_message; ?></div>
            <?php endif; ?>

            <form method="POST" action="" class="edit-profile-form">
                <div class="form-group-edit">
                    <label for="username" class="profile-label">Username</label>
                    <input type="text" id="username" name="username" class="edit-input" value="<?php echo $username; ?>"
                        required>
                </div>

                <div class="form-group-edit">
                    <label for="email" class="profile-label">Email Address</label>
                    <input type="email" id="email" name="email" class="edit-input" value="<?php echo $email; ?>"
                        required>
                </div>

                <div class="divider"></div>
                <p class="section-title">Change Password (Optional)</p>

                <div class="form-group-edit">
                    <label for="current_password" class="profile-label">Current Password</label>
                    <input type="password" id="current_password" name="current_password" class="edit-input">
                </div>

                <div class="form-group-edit">
                    <label for="new_password" class="profile-label">New Password</label>
                    <input type="password" id="new_password" name="new_password" class="edit-input">
                </div>

                <div class="form-group-edit">
                    <label for="confirm_password" class="profile-label">Confirm New Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" class="edit-input">
                </div>

                <div class="profile-actions">
                    <button type="submit" class="profile-btn edit-btn">Save Changes</button>
                    <a href="profile.php" class="profile-btn back-btn">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>