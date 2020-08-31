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
</head>

<body>
	<div class="uk-container uk-margin-small-top">
		<div class="uk-card uk-card-primary uk-card-body">
			<h1 class="uk-heading-line uk-text-center"><span>Lilut</span></h1>
			<hr>
			<?php
			if (!file_exists('uploads')) {
				mkdir('uploads', 0777, true);
			}
			if (!file_exists('results')) {
				mkdir('results', 0777, true);
			}
			?>
			<form action="process.php" method="post" enctype="multipart/form-data">
				<p>Select JPEG file:</p>
				<input class="uk-input" type="file" name="fileToUpload" id="fileToUpload">
				<p>Select LUT: </p>
				<select class="uk-select" name="lut">
					<?php
					$files = glob("luts/*");
					foreach ($files as $file) {
						$filename = basename($file);
						$name = basename($file, ".png");
						echo "<option value='$filename'>$name</option>";
					}
					?>
				</select>
				<input class="uk-button uk-button-primary uk-margin-top" type="submit" value="Process" name="submit">
				<button class="uk-button uk-button-default uk-margin-top" type="button" uk-toggle="target: #modal">Help</button>
			</form>
		</div>
	</div>

	<div id="modal" uk-modal>
		<div class="uk-modal-dialog uk-modal-body">
			<h2 class="uk-modal-title">Help</h2>
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
		</div>
	</div>
</body>

</html>