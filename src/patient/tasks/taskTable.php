<?php 
$allParameters = getTranslatedParameters();
$showIgnoreButton = isset($render['showIgnoreButton']) && $render['showIgnoreButton'] == true;
$showValuesAndActions = isset($render['showValuesAndActions']) && $render['showValuesAndActions'] == true;

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
			<?php if ($showValuesAndActions) { ?>
			<th class="task_value">Vrednost</th>
			<th class="task_action">Akcija</th>
			<?php } ?>
		</thead>
		<?php foreach ($assTasks['tasks'] as $index => $task) { ?>
		<tr>
			<input type="hidden" class="taskId" value="<?php echo $task['id']; ?>"></input>
			<input type="hidden" class="taskDataType" value="<?php echo $task['data_type']; ?>"></input>
			<td><?php echo $index+1; ?>.</td>
			<td><?php echo $task['scheduled_time']; ?></td>
			<td>
				<?php echo $allParameters[$task['parameter_id']]['name']; ?>
			</td>
			<td><?php echo $task['comment']; ?>.</td>
			<?php if ($showValuesAndActions) { ?>
			<td>
				<?php if ($task['data_type'] == 1) { ?>
					<input class="type1 dataValue" type="number"/>
				<?php } else if ($task['data_type'] == 2) { ?>
					<input class="type2 dataValue" type="number" step="0.01"/>
				<?php } else if ($task['data_type'] == 3) { ?>
					<textarea class="type3 dataValue" type="text"></textarea>
				<?php } else if ($task['data_type'] == 4) { ?>
					Uradjeno <input class="type4 dataValue" type="checkbox" value="1"/>
				<?php }?>
			</td>
			<td>
				<span class="actionOk glyphicon glyphicon-ok" aria-hidden="true" style="display: none; color: green;"></span>
				<button type="button" class="saveDataButton btn btn-primary btn-sm">Sacuvaj</button>
				<?php if ($showIgnoreButton) { ?>
				<button type="button" class="btnIgnore btn btn-danger btn-sm">Ignorisi</button>
				<?php } ?>
			</td>
			<?php } ?>
		</tr>
		<?php } ?>
	</table>
</div>
<?php } ?>
