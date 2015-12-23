<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>うついったー</title>
</head>
<body>
    <h1>ユーザ登録</h1>
	<form action="./user_controller.php" method="post" enctype="multipart/form-data">
		<input type="hidden" name="action_id" value="user_create_confirm">
		ユーザID：<input type="text" name="user_id"><br>
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
		プロフィール画像：<input type="file" name="user_profile_phpto"><br>
		背景画像：<input type="file" name="user_profile_background"><br>
		<a href="index.php">戻る</a>
		<input type="submit" value="登録確認画面へ">
	</form>
</body>
</html>