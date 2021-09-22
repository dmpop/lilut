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
	<link rel="stylesheet" href="css/classless.css">
	<link rel="stylesheet" href="css/themes.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
	<div style="text-align: center;">
		<img style="display: inline; height: 2.5em; vertical-align: middle;" src="favicon.svg" alt="logo" />
		<h1 class="text-center" style="display: inline; margin-left: 0.19em; vertical-align: middle; letter-spacing: 3px; margin-top: 0em; color: #f6a159ff;">LILUT</h1>
		<?php
		$target_file = "upload/" . basename($_FILES["fileToUpload"]["name"]);
		$upload_ok = 1;
		$image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
		// Check if image file is a actual image or fake image
		if (isset($_POST["submit"])) {
			$lut = $_POST['lut'];
			$lut_name = strtolower(str_replace(" ", "-", basename($lut, ".png")));
			$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
			if ($check !== false) {
				$upload_ok = 1;
			} else {
				$upload_ok = 0;
			}
		}
		// Allow certain file formats
		if ($image_file_type != "jpg" && $image_file_type != "jpeg" && $image_file_type != "JPG" && $image_file_type != "JPEG") {
			echo '<p style="margin-top: 2em; margin-bottom: 2em;"><h3 style="margin-top: 0em;">Only jpg, jpeg, JPG, and JPEG files are allowed. Also, make sure the file size does not exceed the current upload limit.</h3></p>';
			$upload_ok = 0;
		}
		// Check if $upload_ok is set to 0 by an error
		if ($upload_ok == 0) {
			echo '<p style="margin-top: 2em; margin-bottom: 2em;"><h3 style="margin-top: 0em;"> Something went wrong. The file was not uploaded.</h3></p>';
			// if everything is ok, try to upload file
		} else {
			if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
				$imagick = new \Imagick('upload/' . $_FILES["fileToUpload"]["name"]);
				$imagick_palette = new \Imagick(realpath("luts/$lut"));
				$imagick->haldClutImage($imagick_palette);
				$imagick->writeImage($lut_name . "_" . basename($_FILES["fileToUpload"]["name"]));
				$file = $lut_name . "_"  . basename($_FILES["fileToUpload"]["name"]);
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