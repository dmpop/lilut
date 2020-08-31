<!DOCTYPE html>
<html lang="en">
<!-- Author: Dmitri Popov, dmpop@linux.com
	 License: GPLv3 https://www.gnu.org/licenses/gpl-3.0.txt -->

<head>
	<title>Lilut</title>
	<meta charset="utf-8">
	<link rel="shortcut icon" href="favicon.png" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.5.7/dist/css/uikit.min.css" />
	<script src="https://cdn.jsdelivr.net/npm/uikit@3.5.7/dist/js/uikit.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/uikit@3.5.7/dist/js/uikit-icons.min.js"></script>
	<style>
		img {
			border-radius: 1em;
			max-width: 100%;
			display: block;
			align-self: center;
		}
	</style>
</head>

<body>
	<div class="uk-container uk-margin-small-top">
		<div class="uk-card uk-card-default uk-card-body">
			<h1 class="uk-heading-line uk-text-center"><span>Lilut</span></h1>
			<?php
			$target_dir = "uploads/";
			$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
			$uploadOk = 1;
			$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
			if (isset($_POST["submit"])) {
				$lut = $_POST['lut'];
				echo "<p class='uk-text-center'>Click on the image to download it.</p>";
				$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
				if ($check !== false) {
					$uploadOk = 1;
				} else {
					echo "File is not an image.";
					$uploadOk = 0;
				}
			}
			// Check if file already exists
			//if (file_exists($target_file)) {
			//   echo "Sorry, file already exists.";
			//    $uploadOk = 0;
			//}
			// Check file size
			//if ($_FILES["fileToUpload"]["size"] > 500000) {
			//    echo "Sorry, your file is too large.";
			//    $uploadOk = 0;
			//}
			// Allow certain file formats
			if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "JPG" && $imageFileType != "JPEG") {
				echo "Only jpg, jpeg, JPG, and JPEG files are allowed. Make sure the file size doesn't exceed the current upload limit.";
				$uploadOk = 0;
			}
			// Check if $uploadOk is set to 0 by an error
			if ($uploadOk == 0) {
				echo " The file was not uploaded.";
				// if everything is ok, try to upload file
			} else {
				if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
					$imagick = new \Imagick('uploads/' . $_FILES["fileToUpload"]["name"]);
					$imagickPalette = new \Imagick(realpath("luts/$lut"));
					$imagick->haldClutImage($imagickPalette);
					$imagick->writeImage("results/" . basename($_FILES["fileToUpload"]["name"]));
					unlink('uploads/' . $_FILES["fileToUpload"]["name"]);
				} else {
					echo "Error uploading the file.";
				}
			}
			echo '<a download="results/' . $_FILES["fileToUpload"]["name"] . '" href="results/' . $_FILES["fileToUpload"]["name"] . '" title="Click to download the file"><img alt="Click to download the file" src="results/' . $_FILES["fileToUpload"]["name"] . '"></a>';
			?>
			<a class="uk-button uk-button-primary uk-margin-top" href="index.php">Back</a>
		</div>
	</div>
</body>

</html>