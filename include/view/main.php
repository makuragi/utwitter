<?php
echo 'ようこそ'. $_SESSION['login_id'] . 'さん';
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>うついったー</title>
</head>
<body>
	<form action="./login_controller.php" method="post">
	<input type="hidden" name="action_id" value="logout">
	<input type="submit" value="ログアウト">
	</form>
</body>
</html>