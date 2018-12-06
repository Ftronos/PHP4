<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

<?php

	// ���� �������� ������
	$path = 'C:/Users/DK/OSPanel/domains/HW4/Ex2/';
	$tmp_path = 'C:/Users/DK/OSPanel/domains/HW4/Ex2/tmp/';
	// ������ ���������� �������� ���� �����
	$types = array('image/gif', 'image/png', 'image/jpeg');
	// ������������ ������ �����
	$size = 1024000;

	// ��������� �������
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		function resize($file)
		{
			global $tmp_path;

			// ����������� �� ������ � ��������
			$max_thumb_size = 200;
			$max_size = 600;

			// C����� �������� ����������� �� ������ ��������� �����
			if ($file['type'] == 'image/jpeg')
				$source = imagecreatefromjpeg($file['tmp_name']);
      elseif ($file['type'] == 'image/png')
				$source = imagecreatefrompng($file['tmp_name']);
      elseif ($file['type'] == 'image/gif')
				$source = imagecreatefromgif($file['tmp_name']);
			else
				return false;

			// ���������� ������ � ������ �����������
			$w_src = imagesx($source);
			$h_src = imagesy($source);

			$w = $max_thumb_size;

			// ���� ������ ������ ��������
			if ($w_src > $w) {
				// ���������� ���������
				$ratio = $w_src / $w;
				$w_dest = round($w_src / $ratio);
				$h_dest = round($h_src / $ratio);

				// ������ ������ ��������
				$dest = imagecreatetruecolor($w_dest, $h_dest);

				// �������� ������ ����������� � ����� � ���������� ����������
				imagecopyresampled($dest, $source, 0, 0, 0, 0, $w_dest, $h_dest, $w_src, $h_src);

				// ����� �������� � ������� ������
				imagejpeg($dest, $tmp_path . $file['name']);
				imagedestroy($dest);
				imagedestroy($source);

				return $file['name'];
			} else {
				// ����� �������� � ������� ������
				imagejpeg($src, $tmp_path . $file['name']);
				imagedestroy($src);

				return $file['name'];
			}
		}

		$name = resize($_FILES['userfile'], $_POST['file_type'], $_POST['file_rotate']);

		// �������� ����� � ����� ���������
		if (!@copy($tmp_path . $name, $path . 'min-' . $name))
			echo '<p>���-�� ����� �� ���.</p>';
		else
			echo '<p>�������� ������ ������ <a href="' . $path . $_FILES['userfile']['name'] . '">����������</a>.</p>';

		// ������� ��������� ����
		unlink($tmp_path . $name);
	}
?>

<form enctype="multipart/form-data" method="POST">
    <!-- �������� �������� input ���������� ��� � ������� $_FILES -->
    ��������� ���� ����: <input name="userfile" type="file"/>
    <input type="submit" value="��������� ����"/>
</form>
</body>
</html>