<?php
// エラー表示
if (count($errors) !== 0) {
	foreach ($errors as $error) {
		print $error;
	}
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>うついったー</title>
<<<<<<< HEAD
	<link rel="stylesheet" type="text/css" href="../htdocs/css/normalize.css" media="all">
	<link rel="stylesheet" type="text/css" href="../htdocs/css/style.css" media="all">
=======
	<link rel="stylesheet" type="text/css" href="../include/common/normalize.css" media="all">
	<link rel="stylesheet" type="text/css" href="../include/common/style.css" media="all">
>>>>>>> ff0fcd707df22196a5393993d6992d8e9a906a0c
</head>
<body>
	<div class="container">
	<div class="registration">
	<h2>ログイン</h2>
	<form action="./login_controller.php" method="post" enctype="multipart/form-data">
		<input type="hidden" name="action_id" value="login">
		ユーザID：<input type="text" name="login_id" ><br>
		パスワード：<input type="password" name="login_pass"><br>
		<a href="./index.php">戻る</a>
		<input type="submit" value="ログイン">
	</form>
	</div>
	</div>
</body>
</html>