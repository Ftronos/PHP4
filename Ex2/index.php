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

	// Пути загрузки файлов
	$path = 'C:/Users/DK/OSPanel/domains/HW4/Ex2/';
	$tmp_path = 'C:/Users/DK/OSPanel/domains/HW4/Ex2/tmp/';
	// Массив допустимых значений типа файла
	$types = array('image/gif', 'image/png', 'image/jpeg');
	// Максимальный размер файла
	$size = 1024000;

	// Обработка запроса
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		function resize($file)
		{
			global $tmp_path;

			// Ограничение по ширине в пикселях
			$max_thumb_size = 200;
			$max_size = 600;

			// Cоздаём исходное изображение на основе исходного файла
			if ($file['type'] == 'image/jpeg')
				$source = imagecreatefromjpeg($file['tmp_name']);
      elseif ($file['type'] == 'image/png')
				$source = imagecreatefrompng($file['tmp_name']);
      elseif ($file['type'] == 'image/gif')
				$source = imagecreatefromgif($file['tmp_name']);
			else
				return false;

			// Определяем ширину и высоту изображения
			$w_src = imagesx($source);
			$h_src = imagesy($source);

			$w = $max_thumb_size;

			// Если ширина больше заданной
			if ($w_src > $w) {
				// Вычисление пропорций
				$ratio = $w_src / $w;
				$w_dest = round($w_src / $ratio);
				$h_dest = round($h_src / $ratio);

				// Создаём пустую картинку
				$dest = imagecreatetruecolor($w_dest, $h_dest);

				// Копируем старое изображение в новое с изменением параметров
				imagecopyresampled($dest, $source, 0, 0, 0, 0, $w_dest, $h_dest, $w_src, $h_src);

				// Вывод картинки и очистка памяти
				imagejpeg($dest, $tmp_path . $file['name']);
				imagedestroy($dest);
				imagedestroy($source);

				return $file['name'];
			} else {
				// Вывод картинки и очистка памяти
				imagejpeg($src, $tmp_path . $file['name']);
				imagedestroy($src);

				return $file['name'];
			}
		}

		$name = resize($_FILES['userfile'], $_POST['file_type'], $_POST['file_rotate']);

		// Загрузка файла и вывод сообщения
		if (!@copy($tmp_path . $name, $path . 'min-' . $name))
			echo '<p>Что-то пошло не так.</p>';
		else
			echo '<p>Загрузка прошла удачно <a href="' . $path . $_FILES['userfile']['name'] . '">Посмотреть</a>.</p>';

		// Удаляем временный файл
		unlink($tmp_path . $name);
	}
?>

<form enctype="multipart/form-data" method="POST">
    <!-- Название элемента input определяет имя в массиве $_FILES -->
    Отправить этот файл: <input name="userfile" type="file"/>
    <input type="submit" value="Отправить файл"/>
</form>
</body>
</html>