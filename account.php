<!doctype html>
<html>
<head>
<title>User Registration Page</title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="header">
        <h2>ACCOUNT MANAGEMENT</h2>
    </div>
    <form method="post" action="account.php">
        <?php include('errors.php'); echo ("modify one or multiple user settings");?>
        <div class="input-group">
            <label>New username</label>
            <input type="text" name="username">
        </div>
        <div class="input-group">
            <label>New Email</label>
            <input type="text" name="email">
        </div>
        <div class="input-group">
            <label>New Password</label>
            <input type="password" name="password">
        </div>
        <div class="input-group">
            <label>Confirm New Password</label>
            <input type="password" name="confirm">
        </div>
        <div class="input-group">
            <button type="submit" name="account" class="button">Change</button>
        </div>
        <p>
            <a href="index.php">Return</a>
        </p>
    </form>
</body>
</html>