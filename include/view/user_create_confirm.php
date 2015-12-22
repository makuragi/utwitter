<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>うついったー</title>
</head>
<body>
ユーザ名：<?php echo $_SESSION['user_name']; ?><br>
メールアドレス：<?php echo $_SESSION['user_email']; ?><br>
パスワード：<?php echo $_SESSION['user_password']; ?><br>
年齢：<?php echo $_SESSION['user_age']; ?><br>
性別：<?php echo $_SESSION['user_gender']; ?><br>
プロフィール：<?php echo $_SESSION['user_profile']; ?><br>

</body>
</html>