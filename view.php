<!DOCTYPE html>
<html lang="en">
<!-- Author: Dmitri Popov, dmpop@linux.com
	 License: GPLv3 https://www.gnu.org/licenses/gpl-3.0.txt -->

<head>
    <meta charset="utf-8">
    <title>Lilut</title>
    <link rel="shortcut icon" href="favicon.png" />
    <link rel="stylesheet" href="water.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
    <img style="display: inline; height: 1.6em;" src="favicon.svg" alt="logo" />
    <h1 style="display: inline; height: 2em; margin-left: 0.3em; letter-spacing: 3px; color: rgb(200, 113, 55);">LILUT</h1>
    <?php
    $PASSWORD = 'monkey';
    $fileList = glob('results/*');
    //Loop through the array that glob returned.
    foreach ($fileList as $filename) {
        //Simply print them out onto the screen.
        echo "<p><a href='$filename'>" . basename(str_replace("_", " ", $filename),) . "</a></p>";
    }
    ?>
    <p></p>
    <form style="float: left; padding: 5px;" method="POST" action=" ">
        <p>Password:</p>
        <input style="margin-bottom: 1.5em;" type="password" name="secret">
        <p style='float: left;'><button type="submit" name="delete">Delete</button>
            <button type="submit" name="back">Back</button></p>
    </form>

    <?php
    if (isset($_POST["delete"]) and $_POST['secret'] = $PASSWORD) {
        $files = glob('results/*'); // get all file names
        foreach ($files as $file) { // iterate files
            if (is_file($file)) {
                unlink($file); // delete file
            }
        }
        ob_start();
        while (ob_get_status()) {
            ob_end_clean();
        }
        header("Location: index.php");
    }
    if (isset($_POST["back"])) {
        ob_start();
        while (ob_get_status()) {
            ob_end_clean();
        }
        header("Location: index.php");
    }
    ?>

</body>

</html>