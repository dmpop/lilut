<?php
include('config.php');

/* Redirects here after login */
$redirect_after_login = 'index.php';

/* Set timezone to UTC */

date_default_timezone_set('UTC');

/* Will not ask password again for */
$remember_password = strtotime('+30 days'); // 30 days

if (isset($_POST['password']) && $_POST['password'] == $password) {
    setcookie("password", $password, $remember_password);
    header('Location: ' . $redirect_after_login);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en" data-theme="<?php echo $theme ?>">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <head>

        <meta name="viewport" content="width=device-width">
        <link rel="shortcut icon" href="favicon.png" />
        <link rel="stylesheet" href="classless.css">
        <title><?php echo $title ?></title>
    </head>
</head>

<body>
    <div style="text-align: center;">
        <img style="display: inline; height: 2em; vertical-align: middle;" src="favicon.svg" alt="logo" />
        <h1 class="text-center" style="display: inline; margin-left: 0.19em; vertical-align: middle; letter-spacing: 3px; margin-top: 0em; color: #f6a159ff;">LILUT</h1>
        <div class="card">
            <form action="" method="POST">
                <p>Password:</p>
                <input type="password" name="password">
                <button type="submit" name="submit">Submit</button>
            </form>
        </div>
    </div>
</body>

</html>