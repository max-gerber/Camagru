<!doctype html>
<html>
<head>
<title>Create New Password</title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="header">
        <h2>CREATE NEW PASSWORD</h2>
    </div>
    <form method="post" action="new-password.php">
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
            <label>New Password</label>
            <input type="password" name="password">
        </div>
        <div class="input-group">
            <label>Confirm new password</label>
            <input type="password" name="confirm">
        </div>
        <div class="input-group">
            <label>Token</label>
            <input type="text" name="reset-token">
        </div>
        <div class="input-group">
            <button type="submit" name="new" class="button">reset</button>
        </div>
    </form>
</body>
</html>