<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/icons/thumbnail.png" type="image/png">
    <title>Galaxy Explorer</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>
    <div class="container login-page">
        <div class="bg"></div>

        <img src="assets/images/planet1.png" class="planet planet1">
        <img src="assets/images/planet4.png" class="planet planet4">
        <img src="assets/images/planet2.png" class="planet planet2">
        <img src="assets/images/planet3.png" class="planet planet3">
    </div>
    <div class="content-login">
        <div class="login-card glass-card">
            <h1 class="card-title inner-shadow">login</h1>
            <form class="card-form" action="error.php" method="post">

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