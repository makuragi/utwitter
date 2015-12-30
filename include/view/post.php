<div class="right_container">
	<div id = "post">
	<h3>さあ、うつなことをつぶやきましょう</h3>
	<form action="./main_controller.php" method="post">
		<input type="hidden" name="action_id" value="post_create">
		<select name="color_id">
			<option value="1">赤</option>
			<option value="2">黄</option>
			<option value="3">青</option>
			<option value="4">緑</option>
			<option value="5">白</option>
		</select><br>
		<textarea name="post_body" rows="4" cols="35"></textarea>
		<input type="submit" value="うついーと">
	</form>
	</div>