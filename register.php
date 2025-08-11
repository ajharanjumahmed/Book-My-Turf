<!DOCTYPE html>
<html>

<head>
    <title>User Registration</title>
    <link rel="stylesheet" href="register_style.css">
</head>

<body>
    <div class="form-group">
        
        <div class="heading">
            <h2>Register A New Account</h2>
        </div>

        <div class="form">
            <form class="main-form" action="register_process.php" method="POST">
                <div class="name">
                    <label class="form-label">Name</label> 
                    <input type="text" name="name" required>
                </div>
                <div class="email">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" required>
                </div>
                <div class="number">
                    <label class="form-label">Number</label>
                    <input type="tel" name="number" pattern="[0-9]*" inputmode="numeric" maxlength="11" required>
                </div>
                <div class="password">
                    <label class="form-label">Password</label> 
                    <input type="password" name="password" required>
                </div>
                <div class="role">
                    <label class="form-label">I'm an</label>
                    <select name="role">
                    <option value="user">User</option>
                    <option value="owner">Turf Owner</option>
                    </select>
                </div>
                <div class="submit-button">
                    <input type="submit" value="Register">
                </div>
            </form>
            <div class="change">
                <div class="msg">
                    Already have an account? 
                </div>
                <div class="login-link">
                    <a href="login.php">Login Here</a>
                </div>
            </div>
        </div>

    </div>
</body>

</html>