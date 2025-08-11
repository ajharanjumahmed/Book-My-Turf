<!DOCTYPE html>
<html>

<head>
    <title>User Login</title>
    <link rel="stylesheet" href="register_style.css">
</head>

<body>
    <div class="form-group">
        
        <div class="heading">
            <h2>Login To Your Account</h2>
        </div>

        <div class="form">
            <form class="main-form" action="login_process.php" method="POST">
                <div class="email">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" required>
                </div>
                <div class="password">
                    <label class="form-label">Password</label> 
                    <input type="password" name="password" required>
                </div>
                <div class="submit-button">
                    <input type="submit" value="Login">
                </div>
            </form>
            <div class="change">
                <div class="msg">
                    Don't have an account? 
                </div>
                <div class="login-link">
                    <a href="register.php">Register Here</a>
                </div>
            </div>
        </div>

    </div>
</body>

</html>