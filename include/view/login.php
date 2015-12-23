<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>うついったー</title>
</head>
<body>
    <h1>ログイン</h1>
	<form action="./user_controller.php" method="post" enctype="multipart/form-data">
		<input type="hidden" name="action_id" value="login">
		IDまたはアドレス：<input type="text" name="login_id" ><br>
		ユーザ名：<input type="text" name="user_name" value=
		"<?php if (isSessionExist('user_name')) {
			echo $_SESSION['user_name'];
			};
		?>"><br>
		パスワード：<input type="password" name="user_password" value=
		"<?php if (isSessionExist('user_password')) {
			echo $_SESSION['user_password'];
		}
		?>"><br>
		<a href="index.php">戻る</a>
		<input type="submit" value="登録確認画面へ">
	</form>
</body>
</html>