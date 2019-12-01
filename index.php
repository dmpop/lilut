<!DOCTYPE html>
<html lang="en">
    <!-- Author: Dmitri Popov, dmpop@linux.com
	 License: GPLv3 https://www.gnu.org/licenses/gpl-3.0.txt -->
    
    <head>
	<meta charset="utf-8">
	<title>Lilut</title>
	<link rel="shortcut icon" href="favicon.png" />
	<link rel="stylesheet" href="terminal.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<style>
	 body {
	     display: flex;
	     flex-direction: column;
	     max-width: 50rem;
	     margin: 0 auto;
	     padding: 0 0.9375rem;
	     line-height: 1.9;
         }
	 h1,
         h2,
         h3,
         h4 {
             font-size: 1.5em;
             margin-top: 2%;
         }
	 label {
	     display: inline-block;
	     width:100px;
	     text-align: right;
	 }
	 #center {
             text-align: center;
             margin: 0 auto;
         }
	</style>
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

	<h1>Lilut</h1>

	<form action="process.php" method="post" enctype="multipart/form-data">
	    <p class="label">Select JPEG file:</p>
	    <input type="file" name="fileToUpload" id="fileToUpload"><p></p>
	    <p class="label">Select LUT:</p>
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
	    <input class="btn btn-primary" type="submit" value="Process" name="submit">
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
	    </details>
		</p>
    </body>
</html>
