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
	<?php
	$max_upload = (int)(ini_get('upload_max_filesize'));
	$max_post = (int)(ini_get('post_max_size'));
	$memory_limit = (int)(ini_get('memory_limit'));
	$upload_mb = min($max_upload, $max_post, $memory_limit);
	if (!file_exists('uploads')) {
		mkdir('uploads', 0777, true);
	}
	if (!file_exists('results')) {
		mkdir('results', 0777, true);
	}
	?>
	<img style="display: inline; height: 1.6em;" src="favicon.svg" alt="logo" />
	<h1 style="display: inline; height: 2em; margin-left: 0.3em; letter-spacing: 3px; color: rgb(200, 113, 55);">LILUT</h1>
	<?php
	if (!extension_loaded('imagick')) {
		echo "<p>Looks like the php-imagick extension is missing.</p>";
		echo "<p>On Debian and Ubuntu, use the <code>sudo apt install php-imagick</code> command.</p>";
		echo "<p>On openSUSE, use the <code>sudo zypper install php-imagick</code> command.</p>";
		exit;
	}
	?>
	<p style="color: lightgray;">Current upload limit is <u><?php echo $upload_mb; ?>MB</u></p>
	<form action="process.php" method="POST" enctype="multipart/form-data">
		<p>Select JPEG file:</p>
		<input style="margin-bottom: 1.5em;" type="file" name="fileToUpload" id="fileToUpload">
		<p>Select LUT:</p>
		<select style="margin-bottom: 1.5em;" name="lut">
			<?php
			$files = glob("luts/*");
			foreach ($files as $file) {
				$filename = basename($file);
				$name = basename($file, ".png");
				echo "<option value='$filename'>$name</option>";
			}
			?>
		</select>
		<p>Password:</p>
		<input style="margin-bottom: 1.5em;" type="password" name="password">
		<input type="submit" value="Process" name="submit">
	</form>
	<hr style="margin-top: 1.5em;">
	<p>
		<details>
			<summary style="color: rgb(200, 113, 55);">Help</summary>
			<p>To learn how to create Hald-CLUT presets for use with Lilut, refer to the <a href="https://gumroad.com/l/linux-photography">Linux Photography</a> book.
				<p>How to use Lilut</p>
				<ol>
					<li>
						Before you start, place prepared Hald-CLUT files in the PNG format into the <i>luts</i> directory.
					</li>
					<li>
						Select the desired JPEG file using the <kbd>Browse</kbd> button.
					</li>
					<li>
						Select the desired Hald-CLUT preset from the <em>Select LUT</em> drop-down list.
					</li>
					<li>
						Press the <kbd>Process</kbd> button.
					</li>
				</ol>
				<p>Lilut stands for <strong style="color: brown;">Li</strong>ttle <strong style="color: brown;">LU</strong>T <strong style="color: brown;">T</strong>ool</p>
				<p>This is <a href="https://gitlab.com/dmpop/lilut">Lilut</a>.</p>
		</details>
	</p>
</body>

</html>