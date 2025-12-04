<?php
session_start();

if (isset($_POST['reset'])) {
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $confirm_password = isset($_POST['confirm-password']) ? $_POST['confirm-password'] : '';

    if ($password !== $confirm_password) {
        $error = "Password dan Confirm Password tidak sama!";
    } else {
        include("../config/koneksi.php");

        $password_e = mysqli_real_escape_string($koneksi, $password);
        $result = mysqli_query($koneksi, "UPDATE login SET password='" . $password_e . "' WHERE email='" . $_SESSION["reset_email"] . "'");
        if ($result) {
            header("Location: login.php");
            exit;
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
    <title>Galaxy Explorer</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>

<body>
    <div class="container login-page">
        <div class="bg"></div>

        <img src="../assets/images/bg/planet1.png" class="planet planet1">
        <img src="../assets/images/bg/planet4.png" class="planet planet4">
        <img src="../assets/images/bg/planet2.png" class="planet planet2">
        <img src="../assets/images/bg/planet3.png" class="planet planet3">
    </div>
    <div class="content-login">
        <div class="login-card glass-card">
            <h1 class="card-title inner-shadow">reset</h1>
            <form class="card-form" action="" method="POST">
                <div class="form-group">
                    <label class="field-label" for="password">New Password</label>
                    <input type="password" id="password" name="password" placeholder="New Password" required>
                </div>
                <div class="form-group">
                    <label class="field-label" for="confirm-password">Confirm Password</label>
                    <div class="password-wrap">
                        <input id="confirm-password" type="password" name="confirm-password"
                            placeholder="Confirm Password" required>
                    </div>
                </div>

                <button type="submit" name="reset" class="login-btn">Reset Password</button>
            </form>

            <div class="card-links">
                <p>Don't have account? <a href="register.php">Register</a></p>
                <p>Forgot password? <a href="verify.php">Reset</a></p>
            </div>
        </div>
    </div>
</body>

</html>