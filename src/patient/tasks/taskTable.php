<?php 
$allParameters = getTranslatedParameters();
$showValuesAndActions = isset($render['showValuesAndActions']) && $render['showValuesAndActions'] == true;

$allAssignmentTasks = array();
foreach ($render['tasks'] as $task) {
	$dateStr = substr($task['scheduled_time'], 0, 10);
	if (!isset($allAssignmentTasks[$dateStr][$task['assignment_id']])) {
		$allAssignmentTasks[$dateStr][$task['assignment_id']] = array(
			'name' => $task['name'],
			'description' => $task['description'],
			'date' => $dateStr,
			'tasks' => array(),
		);
	}
	$allAssignmentTasks[$dateStr][$task['assignment_id']]['tasks'][] = $task;
}

foreach ($allAssignmentTasks as $dayAssignments) {
	foreach ($dayAssignments as $id => $dayTasks) {
?>

<div class="col-md-11 dataRow">
	<div>
		<span class="dataStatusSucess" style="display: none;">
			<span class="actionOk glyphicon glyphicon-saved" aria-hidden="true" style="color: green;"></span>
			<span>Sacuvano</span>
		</span>
		<span>
			<div class="dataAssName">Zadatak: <?php echo $dayTasks['name']; ?></div>
			<div class="dataAssDescr">Opis: <?php echo $dayTasks['description']; ?></div>
			<div class="dataAssDescr">Za dan: <?php echo $dayTasks['date']; ?></div>
		</span>
	</div>
	<table class="table">
		<thead>
			<th class="task_numb">#</th>
			<th class="task_time">Zakazano vreme</th>
			<th class="task_param">Parametar</th>
			<th class="task_comment">Komentar</th>
			<?php if ($showValuesAndActions) { ?>
			<th class="task_value">Vrednost</th>
			<th class="tcheck task_check">Provera Vrednosti</th>
			<?php } ?>
		</thead>
		<?php foreach ($dayTasks['tasks'] as $index => $task) { //var_dump($task); ?>
		<tr>
			<input type="hidden" class="taskId" value="<?php echo $task['id']; ?>"
				data-valid-low="<?php echo $task['valid_range_low']; ?>"
				data-valid-high="<?php echo $task['valid_range_high']?>"
				data-mandatory="<?php echo $task['mandatory']; ?>"></input>
			<input type="hidden" class="taskDataType" value="<?php echo $task['data_type']; ?>"></input>
			<td><?php echo $index+1; ?>.</td>
			<td><?php echo substr($task['scheduled_time'], 11); ?></td>
			<td>
				<?php echo $allParameters[$task['parameter_id']]['name']; ?>
			</td>
			<td><?php echo $task['comment']; ?></td>
			<?php if ($showValuesAndActions) { ?>
			<td>
				<?php if ($task['mandatory']) echo '*'; ?>
				<?php if ($task['data_type'] == 1) { ?>
					<input class="type1 dataValue" type="number" value="<?php echo $task['integer_value']; ?>"/>
				<?php } else if ($task['data_type'] == 2) { ?>
					<input class="type2 dataValue" type="number" step="0.01" value="<?php echo $task['double_value']; ?>"/>
				<?php } else if ($task['data_type'] == 3) { ?>
					<textarea class="type3 dataValue" type="text"><?php echo $task['string_value']; ?></textarea>
				<?php } else if ($task['data_type'] == 4) { ?>
					Uradjeno <input class="type4 dataValue" type="checkbox" <?php if ($task['bool_value']) echo 'checked'; ?>/>
				<?php }?>
				<?php if (!empty($task['measure_unit'])) { ?>
					<span class="paramMeasureUnit"><?php echo $task['measure_unit']; ?></span>
				<?php } ?>
			</td>
			<td class="tcheck task_check">
				<span class="tcheck task_ok_row glyphicon glyphicon-check" aria-hidden="true" style="color: green; display: none;"></span>
				<div class="tcheck task_warn_row_mand" style="display: none;">
					<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true" style="color: red;"></span>
					<span>Parametar je obavezan</span>
				</div>
				<div class="tcheck task_warn_row_valid" style="display: none;">
					<span class="glyphicon glyphicon-warning-sign" aria-hidden="true" style="color: orange;"></span>
					<span>Vrednost nije u opsegu normalnih vrednosti</span>
				</div>
			</td>
			<?php } ?>
		</tr>
		<?php }?>
	</table>
	<?php if ($showValuesAndActions) { ?>
		<div class="dataActionButtons">
			<button type="button" class="saveAsDraftButton btn btn-default btn-md">Sacuvaj i nastavi</button>
			<button type="button" class="saveAsCompleteButton btn btn-primary btn-md">Sacuvaj i zatvori</button>
		</div>
		<div class="dataActionConfButtons" style="display: none;">
			<button type="button" class="returnForCorrectionButton btn btn-default btn-md">Varti se i ispravi</button>
			<button type="button" class="saveAnywayButton btn btn-primary btn-md">Sacuvaj i zatvori bez ispravki</button>
		</div>
	<?php } ?>
</div>

<?php 
	}
}
