<?php
// Theme (light, dark, sepia)
$theme = "sakura";
// Footer
$footer = "I really 🧡 <a href='https://www.paypal.com/paypalme/dmpop'>coffee</a>";
?>

<!DOCTYPE html>
<html lang="en" data-theme="<?php echo $theme ?>">

<!--
	Author: Dmitri Popov, dmpop@cameracode.coffee
	License: GPLv3 https://www.gnu.org/licenses/gpl-3.0.txt
-->

<head>
	<meta charset="utf-8">
	<title>Lilut</title>
	<link rel="shortcut icon" href="favicon.png" />
	<link rel="stylesheet" href="css/classless.css">
	<link rel="stylesheet" href="css/themes.css">
	<link rel="stylesheet" href="css/styles.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
	<!-- Suppress form re-submit prompt on refresh -->
	<script>
		if (window.history.replaceState) {
			window.history.replaceState(null, null, window.location.href);
		}
	</script>

	<?php
	$max_upload = (int)(ini_get('upload_max_filesize'));
	$max_post = (int)(ini_get('post_max_size'));
	$memory_limit = (int)(ini_get('memory_limit'));
	$upload_mb = min($max_upload, $max_post, $memory_limit);
	if (!file_exists('upload')) {
		mkdir('upload', 0777, true);
	}
	if (!file_exists('results')) {
		mkdir('results', 0777, true);
	}
	?>
	<div style="text-align: center;">
		<img style="display: inline; height: 2.5em; vertical-align: middle;" src="favicon.svg" alt="logo" />
		<h1 class="text-center" style="display: inline; margin-left: 0.19em; vertical-align: middle; letter-spacing: 3px; margin-top: 0em; color: #ce6a85ff;">LILUT</h1>
		<p style="color: gray; margin-bottom: 1.5em;">Current upload limit is <u><?php echo $upload_mb; ?>MB</u></p>
	</div>
	<div class="card">
		<?php
		if (!extension_loaded('imagick')) {
			echo "<p>Looks like the php-imagick extension is missing.</p>";
			echo "<p>On Debian and Ubuntu, use the <code>sudo apt install php-imagick</code> command.</p>";
			echo "<p>On openSUSE, use the <code>sudo zypper install php-imagick</code> command.</p>";
			exit;
		}
		?>

		<form style="margin-top: 1em;" action=" " method="POST" enctype="multipart/form-data">
			<label for="fileToUpload">Select JPEG file:</label>
			<input style="margin-bottom: 1.5em; margin-top: 0.5em;" type="file" name="fileToUpload" id="fileToUpload">
			<?php
			/* $files = glob("luts/*");
				foreach ($files as $file) {
					$file_name = basename($file);
					$name = basename($file, ".png");
					echo $name . " ";
				} */
			?>
			<div style="text-align: center;">
				<button style="margin-bottom: 1.5em;" type="submit" name="process">Process</button>
				<button style="margin-bottom: 1.5em;" type="submit" name="empty">Remove files</button>
				<div style="margin-bottom: 1.5em; margin-top: .5em;"><a style="color: #009999;" href="https://gumroad.com/l/hald-clut-pack">I want these Hald CLUT files</a></div>
			</div>
		</form>
		<details>
			<summary style="letter-spacing: 1px; color: #ce6a85ff;">Help</summary>
			<p>Create your own Hald CLUT files or get the <a style="color: #009999;" href="https://gumroad.com/l/hald-clut-pack">the Hald CLUT Pack</a>.
			<h4>How to use Lilut</h4>
			<ol>
				<li>
					Before you start, place prepared Hald CLUT files in the PNG format into the <i>luts</i> directory.
				</li>
				<li>
					Select the desired JPEG file using the <kbd>Browse</kbd> button.
				</li>
				<li>
					Press the <kbd>Process</kbd> button.
				</li>
				<li>
					Click the desired processed image to download it.
				</li>
				<li>
					Press the <kbd>Remove files</kbd> button to remove all uploaded and processed files.
				</li>
			</ol>
			<p class="text-center">Lilut stands for <strong style="color: #ce6a85ff;">Li</strong>ttle <strong style="color: #ce6a85ff;">LU</strong>T <strong style="color: #ce6a85ff;">T</strong>ool</p>
		</details>

		<?php
		if (isset($_POST["empty"])) {
			foreach (glob("upload/*") as $file) {
				unlink($file);
			}
			foreach (glob("results/*") as $file) {
				unlink($file);
			}
		}
		if (isset($_POST["process"])) {
			$target_file = "upload/" . basename($_FILES["fileToUpload"]["name"]);
			$upload_ok = 1;
			$image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
			$lut = $_POST['lut'];
			$lut_name = strtolower(str_replace(" ", "-", basename($lut, ".png")));
			$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
			if ($check !== false) {
				$upload_ok = 1;
			} else {
				$upload_ok = 0;
			}
			if ($image_file_type != "jpg" && $image_file_type != "jpeg" && $image_file_type != "JPG" && $image_file_type != "JPEG") {
				$upload_ok = 0;
			}
			if ($upload_ok == 0) {
				echo '<p style="margin-top: 2em; margin-bottom: 2em;"><h3 style="margin-top: 0em;"> Something went wrong. The file was not uploaded.</h3></p>';
				// if everything is ok, try to upload file
			} else {
				if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
					$imagick = new \Imagick('upload/' . $_FILES["fileToUpload"]["name"]);
					$luts = glob("luts/*");
					foreach ($luts as $lut) {
						$lut_name = strtolower(str_replace(" ", "-", basename($lut, ".png")));
						$imagick_palette = new \Imagick(realpath($lut));
						$imagick->haldClutImage($imagick_palette);
						$imagick->writeImage($lut_name . "_" . basename($_FILES["fileToUpload"]["name"]));
						$file = $lut_name . "_"  . basename($_FILES["fileToUpload"]["name"]);
						rename($file, "results/" . $file);
					}
				}
			}
			echo '<div class="square-container">';
			foreach (glob("results/*") as $file) {
				echo '<a href="' . $file . '" download>';
				echo '<img src="' . $file . '" alt="' . $file . '" title= "' . basename($file) . '">';
				echo '</a>';
			}
			echo '</div>';
		}
		?>
	</div>
	<p class="text-center"><?php echo $footer ?></p>
</body>

</html>