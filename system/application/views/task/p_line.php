<tr valign='top' id='task_tr_<?= $task['id'] ?>' onClick='editTask(<?= $task['id'] ?>)' style='background:<?= $task['company_color'] ?>'>
	<td  width=20 class='task_color'>
		<div class='circle' style='background:<?= $task['color'] ?>;'></div>
	</td>
	<td width=5>
		&nbsp;
	</td>
	<td width=50>
		<span class='task_time'><?= trim($task['time']) ?></span>
	</td>
	<td width=100>
		<span class='task_date'><?= trim($task['date']) ?></span>
	</td>
	<td>
		<span class='task_title'><?= $task['title'] ?></span>
		<input type='hidden' class='task_text' value='<?= $task['text'] ?>' />
		<input type='hidden' class='company_id' value='<?= $task['company_id'] ?>' />
		<input type='hidden' class='color' value='<?= $task['color'] ?>' />
	</td>
</tr>