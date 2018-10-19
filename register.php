<!doctype html>
<html>
<head>
<title>User Registration Page</title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="header">
        <h2>REGISTER</h2>
    </div>

    <form method="post" action="register.php">
        <?php include('errors.php');?>
        <div class="input-group">
            <label>Username</label>
            <input type="text" name="username">
        </div>
        <div class="input-group">
            <label>Email</label>
            <input type="text" name="email">
        </div>
        <div class="input-group">
            <label>Password</label>
            <input type="password" name="password">
        </div>
        <div class="input-group">
            <label>Confirm Password</label>
            <input type="password" name="confirm">
        </div>
        <div class="input-group">
            <button type="submit" name="register" class="button">Register</button>
        </div>
        <p>
            Have an account? <a href="login.php">Log in</a>
        </p>
    </form>

</body>
</html>