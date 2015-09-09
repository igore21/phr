<?php 
$allParameters = getTranslatedParameters();

$assignmentTasks = array();
foreach ($render['tasks'] as $task) {
	$assignmentTasks[$task['assignment_id']]['tasks'][] = $task;
	$assignmentTasks[$task['assignment_id']]['name'] = $task['name'];
}
?>

<?php foreach ($assignmentTasks as $id => $assTasks) { ?>
<div class="col-md-11 assignmentTable">
	<h3 class="table_name">Zadatak: <?php echo $assTasks['name']; ?></h3>
	<table class="table">
		<thead>
			<th class="task_numb">#</th>
			<th class="task_time">Zakazano vreme</th>
			<th class="task_param">Parametar</th>
			<th class="task_comment">Komentar</th>
			<th class="task_value">Vrednost</th>
			<th class="task_action">Akcija</th>
		</thead>
		<?php foreach ($assTasks['tasks'] as $index => $task) { ?>
		<tr>
			<td><?php echo $index+1; ?>.</td>
			<td><?php echo $task['scheduled_time']; ?></td>
			<td>
				<?php echo $allParameters[$task['parameter_id']]['name']; ?>
			</td>
			<td><?php echo $task['comment']; ?>.</td>
			<td>
				<?php if ($task['data_type'] == 1) { ?>
					<input class="value" type="number"/>
				<?php } else if ($task['data_type'] == 3) { ?>
					<input class="value" type="number" step="0.01"/>
				<?php } else if ($task['data_type'] == 2) { ?>
					<textarea class="valueComment" type="text"></textarea>
				<?php } else if ($task['data_type'] == 4) { ?>
					Uradjeno <input class="value" type="checkbox"/>
				<?php }?>
			</td>
			<td>
				<button type="button" class="btn btn-primary btn-sm">Sacuvaj</button>
				<button type="button" class="btnIgnore btn btn-danger btn-sm">Ignorisi</button>
			</td>
		</tr>
		<?php } ?>
	</table>
</div>
<?php } ?>
