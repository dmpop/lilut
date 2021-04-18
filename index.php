<?php
include('config.php');
if ($protect) {
	require_once('protect.php');
}
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
	<?php
	$max_upload = (int)(ini_get('upload_max_filesize'));
	$max_post = (int)(ini_get('post_max_size'));
	$memory_limit = (int)(ini_get('memory_limit'));
	$upload_mb = min($max_upload, $max_post, $memory_limit);
	if (!file_exists('upload')) {
		mkdir('upload', 0777, true);
	}
	if (!file_exists('result')) {
		mkdir('result', 0777, true);
	}
	?>
	<div style="text-align: center;">
		<img style="display: inline; height: 2em; vertical-align: middle;" src="favicon.svg" alt="logo" />
		<h1 class="text-center" style="display: inline; margin-left: 0.19em; vertical-align: middle; letter-spacing: 3px; margin-top: 0em; color: #f6a159ff;">LILUT</h1>
		<p style="color: lightgray; margin-bottom: 1.5em;">💡 Current upload limit is <u><?php echo $upload_mb; ?>MB</u></p>
	</div>
	<?php
	if (!extension_loaded('imagick')) {
		echo "<p>Looks like the php-imagick extension is missing.</p>";
		echo "<p>On Debian and Ubuntu, use the <code>sudo apt install php-imagick</code> command.</p>";
		echo "<p>On openSUSE, use the <code>sudo zypper install php-imagick</code> command.</p>";
		exit;
	}
	?>
	<div class="card text-center">
		<form style="margin-top: 1em;" action="process.php" method="POST" enctype="multipart/form-data">
			<label for="fileToUpload">Select JPEG file:</label>
			<input style="margin-bottom: 1.5em; margin-top: 0.5em;" type="file" name="fileToUpload" id="fileToUpload">
			<label for="lut">Select LUT:</label><br />
			<select style="margin-bottom: 1.5em; margin-top: 0.5em;" name="lut">
				<?php
				$files = glob("luts/*");
				foreach ($files as $file) {
					$file_name = basename($file);
					$name = basename($file, ".png");
					echo "<option value='$file_name'>$name</option>";
				}
				?>
			</select>
			<br />
			<div class="text-center">
				<button style="margin-bottom: 1.5em;" type="submit" name="submit">Process</button>
			</div>
		</form>
		<details>
			<summary style="letter-spacing: 1px; color: #f6a159ff;">Help</summary>
			<p>To learn how to create Hald CLUT presets for use with Lilut, refer to the <a href="https://gumroad.com/l/linux-photography">Linux Photography</a> book.
			<p>How to use Lilut</p>
			<ol>
				<li>
					Before you start, place prepared Hald CLUT files in the PNG format into the <i>luts</i> directory.
				</li>
				<li>
					Select the desired JPEG file using the <kbd>Browse</kbd> button.
				</li>
				<li>
					Select the desired Hald CLUT preset from the <em>Select LUT</em> drop-down list.
				</li>
				<li>
					Press the <kbd>Process</kbd> button.
				</li>
			</ol>
			<p class="text-center">Lilut stands for <strong style="color: #f6a159ff;">Li</strong>ttle <strong style="color: #f6a159ff;">LU</strong>T <strong style="color: #f6a159ff;">T</strong>ool</p>
		</details>
	</div>
	<p class="text-center"><?php echo $footer ?></p>
</body>

</html>