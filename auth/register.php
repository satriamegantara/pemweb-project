<?php
session_start();
$error = "";

if (isset($_POST['submit'])) {
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $uname = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $confirm_password = isset($_POST['confirm-password']) ? $_POST['confirm-password'] : '';

    if ($password !== $confirm_password) {
        $error = "Password dan Confirm Password tidak sama!";
    } else {
        include("../config/koneksi.php");

        $email_e = mysqli_real_escape_string($koneksi, $email);
        $uname_e = mysqli_real_escape_string($koneksi, $uname);
        $password_e = mysqli_real_escape_string($koneksi, $password);

        $check_query = "SELECT * FROM login WHERE username='$uname_e' OR email='$email_e'";
        $check_result = mysqli_query($koneksi, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            $error = "Username atau Email sudah terdaftar!";
        } else {
            $result = mysqli_query($koneksi, "INSERT INTO login(email,username,password,role) VALUES('" . $email_e . "','" . $uname_e . "','" . $password_e . "','user')");

            if ($result) {
                header("Location: login.php");
                exit;
            } else {
                $error = "Registrasi gagal! " . mysqli_error($koneksi);
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
            <h1 class="card-title inner-shadow">register</h1>

            <?php if ($error): ?>
                <div
                    style="color: #ff6b6b; text-align: center; margin-bottom: 1rem; padding: 0.5rem; background: rgba(255,107,107,0.1); border-radius: 8px;">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <form class="card-form" action="" method="post">

                <div class="form-group">
                    <label class="field-label" for="email">Email Address</label>
                    <input type="text" id="email" name="email" placeholder="Email Address" required>
                </div>
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
                <div class="form-group">
                    <label class="field-label" for="confirm-password">Confirm Password</label>
                    <div class="password-wrap">
                        <input id="confirm-password" type="password" name="confirm-password"
                            placeholder="Confirm Password" required>
                    </div>
                </div>

                <button type="submit" name="submit" class="login-btn">Register</button>
            </form>

            <div class="card-links">
                <p>Already have an account? <a href="login.php">Login</a></p>
            </div>
        </div>
    </div>
</body>

</html>