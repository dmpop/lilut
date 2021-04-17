<?php
include('config.php');
if ($protect) {
	require_once('protect.php');
}
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
		$upload_dir = "luts/";
		if (isset($_POST['submit'])) {
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
			<form id="lut" style="margin-top: 1em;" method='POST' action='' enctype='multipart/form-data'>
				<label for="file[]">Select Hald CLUT file(s):</label><br />
				<input style="margin-bottom: 1.5em; margin-top: 0.5em;" type="file" name="file[]" id="file" multiple>
			</form>
			<span style="display: inline;">
				<button role="button" name="submit" form="lut">Upload</button>
				<button style="margin-bottom: 2em;" onclick='window.location.href = "index.php"'>Back</button>
		</div>
	</div>
	<p class="text-center"><?php echo $footer ?></p>
	</div>
</body>

</html>