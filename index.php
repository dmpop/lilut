<!DOCTYPE html>
<html lang="en">
<!-- Author: Dmitri Popov, dmpop@linux.com
	 License: GPLv3 https://www.gnu.org/licenses/gpl-3.0.txt -->

<head>
	<meta charset="utf-8">
	<title>Lilut</title>
	<link rel="shortcut icon" href="favicon.png" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/kognise/water.css@latest/dist/light.min.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
	<?php
	if (!file_exists('uploads')) {
		mkdir('uploads', 0777, true);
	}
	if (!file_exists('results')) {
		mkdir('results', 0777, true);
	}
	?>
	<img style="display: inline; height: 1.6em;" src="favicon.svg" alt="logo" />
	<h1 style="display: inline; height: 2em; margin-left: 0.3em; letter-spacing: 3px;">LILUT</h1>

	<form action="process.php" method="post" enctype="multipart/form-data">
		<p>Select JPEG file:</p>
		<input type="file" name="fileToUpload" id="fileToUpload">
		<p></p>
		<p>Select LUT:</p>
		<select name="lut">
			<?php
			$files = glob("luts/*");
			foreach ($files as $file) {
				$filename = basename($file);
				$name = basename($file, ".png");
				echo "<option value='$filename'>$name</option>";
			}
			?>
		</select>
		<p></p>
		<input type="submit" value="Process" name="submit">
	</form>

	<p>
		<details>
			<summary>Help</summary>
			<p>To learn how to create Hald-CLUT presets for use with Lilut, refer to the <a href="https://gumroad.com/l/linux-photography">Linux Photography</a> book.
				<p>How to use Lilut</p>
				<ol>
					<li>
						Before you start, place prepared Hald-CLUT files in the PNG format into the <i>luts</i> directory.
					</li>
					<li>
						Select the desired JPEG file using the <b>Browse</b> button.
					</li>
					<li>
						Select the desired Hald-CLUT preset from the <b>Select LUT</b> drop-down list.
					</li>
					<li>
						Press the <b>Process</b> button.
					</li>
				</ol>
				<p>Lilut stands for <strong style="color: brown;">Li</strong>ttle <strong style="color: brown;">LU</strong>T <strong style="color: brown;">T</strong>ool</p>
		</details>
	</p>
</body>

</html>