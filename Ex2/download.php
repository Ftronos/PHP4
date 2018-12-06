<?
	$uploaddir = 'C:/Users/DK/OSPanel/domains/HW4/Ex2/';
	move_uploaded_file($_FILES['userfile']['tmp_name'], $uploaddir . $_FILES['userfile']['name']);
	header("Location: ".$_SERVER['HTTP_REFERER']);