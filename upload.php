<?php
include('config.php');
?>

<html lang="en" data-theme="<?php echo $theme ?>">
<!-- Author: Dmitri Popov, dmpop@linux.com
         License: GPLv3 https://www.gnu.org/licenses/gpl-3.0.txt -->

<head>
	<meta charset="utf-8">
	<title>LILUT</title>
	<link rel="shortcut icon" href="favicon.png" />
	<link rel="stylesheet" href="classless.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
	<div style="text-align: center;">
		<img style="display: inline; height: 2em; vertical-align: middle;" src="favicon.svg" alt="logo" />
		<h1 class="text-center" style="margin-left: 0.19em; vertical-align: middle; letter-spacing: 3px; margin-top: 0em; color: #f6a159ff;">LILUT</h1>
		<?php

		if (!$upload) {
			echo '<p style="margin-top: 2em; margin-bottom: 2em;"><h3 style="margin-top: 0em;">⚠️ Upload is disabled.</h3></p>';
			echo '<button style="margin-bottom: 2em;" onclick=\'window.location.href = "index.php"\'>Back</button>';
			exit();
		}

		$upload_dir = "luts/";
		if (isset($_POST['submit'])) {
			if ($_POST['password'] != $pw) {
				echo '<p style="margin-top: 2em; margin-bottom: 2em;"><h3 style="margin-top: 0em;">Wrong password!</h3></p>';
				echo '<button style="margin-bottom: 2em;" onclick=\'window.location.href = "upload.php"\'>Try again</button>';
				exit();
			}
			$countfiles = count($_FILES['file']['name']);
			for ($i = 0; $i < $countfiles; $i++) {
				$filename = $_FILES['file']['name'][$i];
				move_uploaded_file($_FILES['file']['tmp_name'][$i], $upload_dir . DIRECTORY_SEPARATOR . $filename);
			}
			echo '<script language="javascript">';
			echo 'alert("Upload completed.")';
			echo '</script>';
		}
		?>
		<div class="card text-center" style="margin-top: 2em;">
			<form style="margin-top: 1em;" method='post' action='' enctype='multipart/form-data'>
				<label for="file[]">Select Hald CLUT file(s):</label><br />
				<input style="margin-bottom: 1.5em; margin-top: 0.5em;" type="file" name="file[]" id="file" multiple>
				<label for="password">Password:</label><br />
				<input style="margin-top: 0.5em;" type="password" name="password">
				<button role="button" name="submit">Upload</button>
			</form>
		</div>
		<p class="text-center"><?php echo $footer ?></p>
	</div>
</body>

</html>