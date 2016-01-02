<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>うついったー</title>
 	<link rel="stylesheet" type="text/css" href="../htdocs/css/normalize.css" media="all">
	<link rel="stylesheet" type="text/css" href="../htdocs/css/style.css" media="all">
</head>
<body>
	<div class="registration">
    <h2>ユーザ登録</h2>
	<form action="./user_controller.php" method="post" enctype="multipart/form-data">
		<input type="hidden" name="action_id" value="user_create_confirm">
		ユーザID：<input type="text" name="user_id" value=
		"<?php if (isSessionExist('user_id')) {
			echo $_SESSION['user_id'];
			};
		?>"><br>
		ユーザ名：<input type="text" name="user_name" value=
		"<?php if (isSessionExist('user_name')) {
			echo $_SESSION['user_name'];
			};
		?>"><br>
		メールアドレス：<input type="text" name="user_email" value=
		"<?php if (isSessionExist('user_email')) {
			echo $_SESSION['user_email'];
		}
		?>"><br>
		パスワード：<input type="password" name="user_password" value=
		"<?php if (isSessionExist('user_password')) {
			echo $_SESSION['user_password'];
		}
		?>"><br>
		パスワード(確認)：<input type="password" name="user_password_confirm"><br>
		年齢：<input type="text" name="user_age" value=
		"<?php if (isSessionExist('user_age')) {
			echo $_SESSION['user_age'];
		}
		?>"><br>
		性別：
		男<input type="radio" name="user_gender" value="0"
		<?php if (isSessionExist('user_gender') && $_SESSION['user_gender'] === '0') { ?>
		checked
		<?php } ?>>
		女<input type="radio" name="user_gender" value="1"
		<?php if (isSessionExist('user_gender') && $_SESSION['user_gender'] === '1') { ?>
		checked
		<?php } ?>>
		<br>
		プロフィール：<textarea  name="user_profile" rows="5" cols="40"
		><?php if (isSessionExist('user_profile')) {
			echo $_SESSION['user_profile'];
		}
		?></textarea><br>
		プロフィール画像：<input type="file" name="user_profile_photo[]"><br>
		背景画像：<input type="file" name="user_profile_photo[]"><br>
		<a href="index.php">戻る</a>
		<input type="submit" value="登録確認画面へ">
	</form>
<<<<<<< HEAD
	
=======
>>>>>>> ff0fcd707df22196a5393993d6992d8e9a906a0c
	</div>
</body>
</html>