<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
	      content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Document</title>
	<style>
		.gallery {
			display: flex;
			width: 100% ;
		}

		.img {
			width: 33%;
		}

		.img a {
			display: block;
		}

		.img img {
			max-width: 100%;
		}
	</style>
</head>
<body>
	<div class="gallery">
		<?
			$imagesDir = @opendir("images-mini");
			while ($file = readdir($imagesDir)) {
				if($file=="." || $file == "..") continue;

				$file_parts = explode(".", $file);
				$ext = strtolower(array_pop($file_parts));

				echo '<div class = "img" >
		                <a href="images-max/' . $file . '" title="' . $file . '" target="_blank">
		                  <img src="images-mini/' . $file . '" title="' . $file . '" />
		                </a>
		            </div>';
			}
			closedir($imagesDir);
		?>
	</div>
</body>
</html>

