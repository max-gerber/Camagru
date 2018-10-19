<?php include(server.php); ?>
<!doctype html>
<html>
<head>
<title>User Registration Page</title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="header">
        <h2>LOG IN</h2>
    </div>

    <form method="post" action="login.php">
        <div class="input-group">
            <label>Username</label>
            <input type="text" name="username">
        </div>
        <div class="input-group">
            <label>Password</label>
            <input type="password" name="password">
        </div>
        <div class="input-group">
            <button type="submit" name="login" class="button">Log In</button>
        </div>
        <p>
            Don't have an account? <a href="register.php">Sign up</a>
        </p>
    </form>

</body>
</html>