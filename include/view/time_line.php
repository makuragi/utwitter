<div id="all_timeline" class="left">
<h3>うついーと一覧</h3>
<?php foreach($all_time_line as $time_line) { ?>
	<div class="time_line">
		<?php echo $time_line['user_name'] ?>&nbsp;
		<?php echo $time_line['user_id'] ?><br>
		<?php echo $time_line['post_body']; ?><br>
		<?php echo $time_line['post_date'] ?>
	</div>
<?php } ?>
</div>