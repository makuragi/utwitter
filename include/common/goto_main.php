<?php
if (isset($_SESSION['login_id'])) {
	header('HTTP/1.1 303 See Other');
	header('Location: http://localhost//utwitter/htdocs/main_controller.php');
	exit();
}