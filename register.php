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
            <h1 class="card-title inner-shadow">register</h1>
            <form class="card-form" action="error.php" method="post">

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

                <button type="submit" class="login-btn">Register</button>
            </form>

            <div class="card-links">
                <p>Already have an account? <a href="login.php">Login</a></p>
            </div>
        </div>
    </div>
</body>

</html>