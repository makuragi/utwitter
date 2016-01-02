<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>うついったー</title>
 	<link rel="stylesheet" type="text/css" href="../htdocs/css/normalize.css" media="all">
	<link rel="stylesheet" type="text/css" href="../htdocs/css/style.css" media="all">
	<link href='css/jquery.Jcrop.min.css' rel='stylesheet' type='text/css'>
	<script type="text/javascript" src="../htdocs/js/jquery-1.11.3.min.js"></script>
	<script type="text/javascript" src="../htdocs/js/jquery.Jcrop.min.js"></script>
</head>
<body>
<div id="confirm" class="registration">
ユーザ名：<?php echo $_SESSION['user_name']; ?><br>
メールアドレス：<?php echo $_SESSION['user_email']; ?><br>
パスワード：<?php echo $_SESSION['user_password']; ?><br>
年齢：<?php echo $_SESSION['user_age']; ?><br>
<!-- todo: user_genderの表示を0→男、1→女に変える -->
性別：<?php echo $_SESSION['user_gender']; ?><br>
プロフィール：<?php echo $_SESSION['user_profile']; ?><br>

	

<?php if (isset($_SESSION['user_profile_photo'])) { ?>
<div>プロフィール画像:</div>
<div class="user_profile_image">
<img src="<?php echo $_SESSION['user_profile_photo']; ?>">
<!--  
<script type="text/Javascript">
    $(function(){$('#jcrop_target').Jcrop();});
</script>
<div id="pre-thumb">
<img id="jcrop_target" src="<?php echo $_SESSION['user_profile_photo']; ?>"><br>
</div>
<div id="thumb">
<img id="preview" src="<?php echo $_SESSION['user_profile_photo']; ?>"><br></div>
-->
<?php } ?>
</div>
<?php if (isset($_SESSION['user_profile_background'])) { ?>
<div><p>背景画像:<img src="<?php echo $_SESSION['user_profile_background']; ?>"></p></div>
<?php } ?>

<div><p>
<a href="./user_controller.php">戻る</a></p>
<form action="./user_controller.php" method="post">
<input type="hidden" name="action_id" value="user_create_result">
<input type="submit" value="登録する">
</form>
</div>
</div>
</body>
</html>