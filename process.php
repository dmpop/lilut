<?php
include('config.php');
?>

<!DOCTYPE html>
<html lang="en" data-theme="<?php echo $theme ?>">
<!-- Author: Dmitri Popov, dmpop@linux.com
	 License: GPLv3 https://www.gnu.org/licenses/gpl-3.0.txt -->

<head>
	<meta charset="utf-8">
	<title>Lilut</title>
	<link rel="shortcut icon" href="favicon.png" />
	<link rel="stylesheet" href="classless.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
	<div style="text-align: center;">
		<img style="display: inline; height: 2em; vertical-align: middle;" src="favicon.svg" alt="logo" />
		<h1 class="text-center" style="display: inline; margin-left: 0.19em; vertical-align: middle; letter-spacing: 3px; margin-top: 0em; color: #f6a159ff;">LILUT</h1>
		<?php
		if ($_POST['password'] != $pw) {
			echo '<p style="margin-top: 2em; margin-bottom: 2em;"><h3 style="margin-top: 0em;">Wrong password</h3></p>';
			echo '<button style="margin-bottom: 2em;" onclick=\'window.location.href = "index.php"\'>Back</button>';
			exit();
		}
		$target_file = "upload/" . basename($_FILES["fileToUpload"]["name"]);
		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
		// Check if image file is a actual image or fake image
		if (isset($_POST["submit"])) {
			$lut = $_POST['lut'];
			$lutname = strtolower(str_replace(" ", "-", basename($lut, ".png")));
			$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
			if ($check !== false) {
				$uploadOk = 1;
			} else {
				echo '<p style="margin-top: 2em; margin-bottom: 2em;"><h3 style="margin-top: 0em;">Something went wrong</h3></p>';
				$uploadOk = 0;
			}
		}
		// Allow certain file formats
		if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "JPG" && $imageFileType != "JPEG") {
			echo '<p style="margin-top: 2em; margin-bottom: 2em;"><h3 style="margin-top: 0em;">Only jpg, jpeg, JPG, and JPEG files are allowed. Also, make sure the file size does not exceed the current upload limit.</h3></p>';
			$uploadOk = 0;
		}
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
			echo '<p style="margin-top: 2em; margin-bottom: 2em;"><h3 style="margin-top: 0em;">The file was not uploaded.</h3></p>';
			// if everything is ok, try to upload file
		} else {
			if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
				$imagick = new \Imagick('upload/' . $_FILES["fileToUpload"]["name"]);
				$imagickPalette = new \Imagick(realpath("luts/$lut"));
				$imagick->haldClutImage($imagickPalette);
				$imagick->writeImage($lutname . "_" . basename($_FILES["fileToUpload"]["name"]));
				$file = $lutname . "_"  . basename($_FILES["fileToUpload"]["name"]);
				ob_start();
				while (ob_get_status()) {
					ob_end_clean();
				}
				header('Content-type: image/jpeg');
				header('Content-Disposition: attachment; filename="' . $file . '"');
				readfile($file);
				if ($keep) {
					rename($file, "result/" . $file);
				} else {
					unlink('upload/' . $_FILES["fileToUpload"]["name"]);
					unlink($file);
				}
			} else {
				echo '<p style="margin-top: 2em; margin-bottom: 2em;"><h3 style="margin-top: 0em;">Error uploading the file.</h3></p>';
			}
		}
		?>
		<button style="margin-bottom: 2em;" onclick='window.location.href = "index.php"'>Back</button>
		<hr>
		<p><?php echo $footer ?></p>
	</div>
</body>

</html>