<!doctype html>
<html>
<head>
<title>Reset Password</title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="header">
        <h2>RESET PASSWORD</h2>
    </div>
    <form method="post" id="form" action="reset-password.php">
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
            <button type="submit" name="reset" class="button">Send email</button>
        </div>
    </form>
</body>
</html>