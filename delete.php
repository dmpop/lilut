<?php
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
?>