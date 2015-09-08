<?php 

$allParameters = getTranslatedParameters();

if (isset($_SESSION['new_assignment'])) {
	$assignment = array_replace($assignment, $_SESSION['new_assignment']);
	unset($_SESSION['new_assignment']);
}

// Adding template param
$assignment['params'][] = array(
	'parameter_id' => 0,
	'execute_after' => '',
	'time_unit' => '',
	'comment' => '',
);

$errorMsg = '';
if (isset($_SESSION['createAssignmentError'])) {
	$errorMsg = $_SESSION['createAssignmentError'];
	unset($_SESSION['createAssignmentError']);
}

$assignment['all_periods'] = array(
	PERIOD_HOURS => 'sat/sati',
	PERIOD_DAYS => 'dan/dana',
	PERIOD_WEEKS =>	'nedelje/nedelja',
);

$assignment['start_time'] = substr($assignment['start_time'], 0, 10);
$assignment['end_time'] = substr($assignment['end_time'], 0, 10);

?>
<?php if (!empty($errorMsg)) { ?>
	<div class="alert alert-danger change-success-alert" role="alert"><?php echo $errorMsg; ?></div>
<?php } ?>

<form method="POST" action="processCreateAssignment.php">
	<ul class="list-unstyled create-assignment">
		<div class="container">
			<input type="hidden" name="assignment_id" value="<?php echo $assignment['id']; ?>"></input>
			<h2 class="form-signin-heading"><?php echo $tableTitle; ?></h2>
			<div class="form-group">
				<li>
					<label for="patientId"></label>
					<input style="display: none" name="patient_id" value="<?php echo $assignment['patient_id']; ?>">
				</li>
			</div>
			<div class="form-group">
				<li>
					<label for="name" class="assField">Naziv zadatka</label>
					<input class="assField" type="text" name="name" required value="<?php echo $assignment['name']; ?>">
				</li>
			</div>
			<div class="form-group">
				<li>
					<label for="description" class="assField">Opis zadatka</label>
					<textarea class="ass-text-area" type="text" name="description"><?php echo $assignment['description']; ?></textarea>
				</li>
			</div>
			<div class="form-group">
				<li>
					<label for="start_time" class="assField">Datum pocetka</label>
					<input class="ass-choose-area" type="date" name="start_time" required value="<?php echo $assignment['start_time']?>">
				</li>
			</div>
			<div class="form-group">
				<li>
					<label for="end_time" class="assField">Datum zavrsetka</label>
					<input class="ass-choose-area" type="date" name="end_time" required value="<?php echo $assignment['end_time']?>">
				</li>
			</div>
			
			<div class="form-group">
				<div><h3 class="form-signin-heading">Parametri</h3></div>
				<li>
					<label class="assField">Izaberite parametre</label>
					<select class="ass-choose-area" id="parameterList" name="params">
						<option selected="selected" value="0">Izbaerite parametar</option>
						<?php foreach ($allParameters as $index => $param) {?>
							<option value="<?php echo $param['id'];?>"><?php echo $param['name'];?></option>
						<?php }?>
					</select>
					<a class="btn btn-default btn-sm add-param" id="addParameter" href="#">Dodaj parametar</a>
				</li>
			</div>
			
			<div id="parameters">
				<div class="col-md-11">
					<table class="table">
						<thead>
							<th class="param_col_name">Naziv</th>
							<th class="param_col_execute">Izvrsavati na svakih</th>
							<th class="param_col_unite">Vremenska jedinica</th>
							<th class="param_col_comment">Komentar</th>
							<th class="param_col_remove"></th>
						</thead>
						<?php foreach ($assignment['params'] as $param) { ?>
						<tr class="parameterElem" <?php if ($param['parameter_id'] == 0) echo 'id="templateParameter" style="display: none;"'; ?>>
							<input type="hidden" class="paramId" name="params[<?php echo $param['parameter_id']; ?>][parameter_id]" value="<?php echo $param['parameter_id']?>"></input>
							<th>
								<span class="paramName">
									<?php if (isset($allParameters[$param['parameter_id']]['name'])) echo $allParameters[$param['parameter_id']]['name']; ?>
								</span>
							</th>
							<th><input class="paramExecuteAfter" type="number" name="params[<?php echo $param['parameter_id']; ?>][execute_after]" value="<?php echo $param['execute_after']?>" style="width: 100px;"></th>
							<th>
								<select class="ass-choose-area paramTimeUnit" name="params[<?php echo $param['parameter_id']; ?>][time_unit]">
									<?php foreach ($assignment['all_periods'] as $periodId => $periodName) {?>
									<option value="<?php echo $periodId;?>" <?php if ($periodId == $param['time_unit']) {echo 'selected="selected"';} ?>>
										<?php echo $periodName; ?>
									</option>
									<?php }?>
								</select>
							</th>
							<th>
								<textarea class="ass-text-area paramComment" type="text" name="params[<?php echo $param['parameter_id']; ?>][comment]"><?php echo $param['comment']?></textarea>
							</th>
							<th>
								<a class="btn btn-default removeParameter" href="#">x</a>
							</th>
						</tr>
						<?php } ?>
					</table>
				</div>
			</div>
			
			<div class="form-group">
				<li><input type="submit" class="create btn btn-md btn-primary assField-btn" value="<?php echo $buttonName; ?>"></li>
			</div>
		</div>
	</ul>
</form>