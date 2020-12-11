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
	$PASSWORD='monkey';
	if ($_POST['password']!=$PASSWORD) { print '<p>Wrong password :-(</p><p><a href="index.php">Back</a></p>'; exit(); }
	$target_dir = "uploads/";
	$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
	$uploadOk = 1;
	$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
	// Check if image file is a actual image or fake image
	if (isset($_POST["submit"])) {
		$lut = $_POST['lut'];
		$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		if ($check !== false) {
			$uploadOk = 1;
		} else {
			echo "<p>File is not an image.</p>";
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
		echo "<p>Only jpg, jpeg, JPG, and JPEG files are allowed. Also, make sure the file size doesn't exceed the current upload limit.</p>";
		$uploadOk = 0;
	}
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
		echo "The file was not uploaded.";
		// if everything is ok, try to upload file
	} else {
		if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
			$imagick = new \Imagick('uploads/' . $_FILES["fileToUpload"]["name"]);
			$imagickPalette = new \Imagick(realpath("luts/$lut"));
			$imagick->haldClutImage($imagickPalette);
			$imagick->writeImage("results/" . basename($_FILES["fileToUpload"]["name"]));
			unlink('uploads/' . $_FILES["fileToUpload"]["name"]);
			echo "<p>Click on the image to download the file.</p>";
			echo '<a download="results/' . $_FILES["fileToUpload"]["name"] . '" href="results/' . $_FILES["fileToUpload"]["name"] . '" title="Click to download the file"><img alt="Click to download the file" src="results/' . $_FILES["fileToUpload"]["name"] . '"></a>';
		} else {
			echo "Error uploading the file.";
		}
	}
	?>
	<form method="GET" action="index.php">
		<p style='margin-top:1em;'><button type="submit">Back</button></p>
	</form>
</body>

</html>