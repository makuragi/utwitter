<div id="all_timeline">
<h3>うついーと一覧</h3>
<?php foreach($all_time_line as $time_line) { ?>
	<div class="time_line">
		<a href="./main_controller.php?<?php echo $time_line['user_id']; ?>"><?php echo $time_line['user_name']; ?></a>&nbsp;
		<?php echo $time_line['user_id'] ?><br>
		<?php echo $time_line['post_body']; ?><br>
		<?php echo $time_line['post_date'] ?>
	</div>
<?php } ?>

