<?php
session_start();
include("../config/koneksi.php");

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"];

    $query = "SELECT * FROM login WHERE email = '$email'";
    $result = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($result) === 1) {
        $data = mysqli_fetch_assoc($result);
        $_SESSION["reset_email"] = $data["email"];

        header("Location: reset.php");
        exit;
    } else {
        $error = "Email tidak terdaftar!";
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

        <img src="../assets/images/bg/planet1.webp" class="planet planet1">
        <img src="../assets/images/bg/planet4.webp" class="planet planet4">
        <img src="../assets/images/bg/planet2.webp" class="planet planet2">
        <img src="../assets/images/bg/planet3.webp" class="planet planet3">
    </div>
    <div class="content-login">
        <div class="login-card glass-card">
            <h1 class="card-title inner-shadow">reset password</h1>

            <?php if ($error): ?>
                <div
                    style="color: #ff6b6b; text-align: center; margin-bottom: 1rem; padding: 0.5rem; background: rgba(255,107,107,0.1); border-radius: 8px; font-size: 0.9rem;">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <form class="card-form" action="" method="post">

                <div class="form-group">
                    <label class="field-label" for="email">Email Address</label>
                    <input type="text" id="email" name="email" placeholder="Email Address" required>
                </div>

                <button type="submit" class="login-btn">Verify</button>
            </form>

            <div class="card-links">
                <p>Don't have account? <a href="register.php">Register</a></p>
                <p>Remember password? <a href="login.php">Login</a></p>
            </div>
        </div>
    </div>
</body>

</html>