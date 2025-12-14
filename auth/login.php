<?php
session_start();
include("../config/koneksi.php");

$error = "";

if (isset($_POST["login"])) {
    $uname = mysqli_real_escape_string($koneksi, $_POST['username']);
    $pass = $_POST['password'];

    $query = "SELECT * FROM login WHERE username='$uname'";
    $result = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($result) === 1) {
        $data = mysqli_fetch_assoc($result);

        // Verify password menggunakan password_verify()
        if (password_verify($pass, $data['password'])) {
            $_SESSION['username'] = $data['username'];
            $_SESSION['userId'] = $data['userId'];
            $_SESSION['role'] = $data['role'];

            if ($data['role'] === "admin") {
                header("Location: ../admin/dashboard.php");
            } else {
                header("Location: ../user/dashboard.php");
            }
            exit;
        } else {
            $error = "Username atau password salah!";
        }
    } else {
        $error = "Username atau password salah!";
    }
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
    <link rel="stylesheet" href="../assets/css/user-profile.css">
</head>

<body>
    <div class="container login-page">
        <div class="bg"></div>

        <img src="../assets/images/bg/planet1.webp" class="planet planet1">
        <img src="../assets/images/bg/planet4.webp" class="planet planet4">
        <img src="../assets/images/bg/planet2.webp" class="planet planet2">
        <img src="../assets/images/bg/planet3.webp" class="planet planet3">
    </div>
    <div class="content-login">
        <?php if (!empty($error)): ?>
            <div class="notification-popup" id="loginNotif">
                <div class="notification-content">
                    <span class="notification-icon">&#9888;</span>
                    <span class="notification-text"><?php echo $error; ?></span>
                </div>
            </div>
            <script>
                setTimeout(function () {
                    var notif = document.getElementById('loginNotif');
                    if (notif) notif.classList.add('fade-out');
                }, 2500);
                setTimeout(function () {
                    var notif = document.getElementById('loginNotif');
                    if (notif) notif.style.display = 'none';
                }, 3000);
            </script>
        <?php endif; ?>
        <div class="login-card glass-card">
            <h1 class="card-title inner-shadow">login</h1>
            <form class="card-form" action="" method="POST">
                <div class="form-group">
                    <label class="field-label" for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="Username" required>
                </div>
                <div class="form-group">
                    <label class="field-label" for="password">Password</label>
                    <div class="password-wrap">
                        <input id="password" type="password" name="password" placeholder="Password" required>
                    </div>
                </div>

                <button type="submit" name="login" class="login-btn">Login</button>
            </form>

            <div class="card-links">
                <p>Don't have account? <a href="register.php">Register</a></p>
                <p>Forgot password? <a href="verify.php">Reset</a></p>
            </div>
        </div>
    </div>
</body>

</html>