<?php
session_start();

if (!isset($_SESSION['login_id'])) {
	if (isset($_COOKIE['login_id'])) {
		$_SESSION['login_id'] = $_COOKIE['login_id'];
	}
}

