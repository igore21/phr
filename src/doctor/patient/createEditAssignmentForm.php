<?php 

$allParameters = getTranslatedParameters();
$templateNames = DB::getTempalteNames();
$allTemplates = DB::getTemplates();

if (isset($_SESSION['new_assignment'])) {
	$assignment = array_replace($assignment, $_SESSION['new_assignment']);
	unset($_SESSION['new_assignment']);
}

// Adding template param
$assignment['params'][] = array(
	'parameter_id' => 0,
	'execute_after' => '',
	'time_unit' => '',
	'measure_unit' => '',
	'comment' => '',
	'mandatory' => 0,
	'data_type' => 0,
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
				<div>
					<label class="assField">Izaberite parametre</label>
					<select class="ass-choose-area" id="parameterList">
						<option selected="selected" value="0">Izaberite parametar</option>
						<?php foreach ($allParameters as $index => $param) {?>
							<option value="<?php echo $param['id'];?>"
								data-type="<?php echo $param['data_type']; ?>"
								data-measure-unit="<?php echo (!empty($param['measure_unit']) ? $param['measure_unit'] : '/'); ?>">
								<?php echo $param['name'];?>
							</option>
						<?php }?>
					</select>
					<a class="btn btn-default btn-sm add-param" id="addParameter" href="#">Dodaj parametar</a>
				</div>
				<div style="margin-top: 10px;">
					<label class="assField">Izaberite sablon</label>
					<select class="ass-choose-area" id="templateList">
						<option selected="selected" value="0">Izaberite sablon</option>
						<?php foreach ($templateNames as $index => $temp) { //var_dump($temp); ?>
							<option value="<?php echo $temp['template_id'];?>">
								<?php echo $temp['name'];?>
							</option>
						<?php }?>
					</select>
					<a class="btn btn-default btn-sm add-param" id="addTemplate" href="#">Dodaj sablon</a>
					<div id="tempParams" style="display: none;">
					<?php foreach ($allTemplates as $index => $param) { //var_dump($param); ?>
						<div>
							<input type="hidden" class="tempParam<?php echo $param['template_id']?>"
								data-name="<?php echo $allParameters[$param['parameter_id']]['name']; ?>"
								data-parameter-id="<?php echo $param['parameter_id']; ?>"
								data-measure-unit="<?php echo $param['measure_unit']; ?>"
								data-data-type="<?php echo $param['data_type']; ?>"
								data-mandatory="<?php echo $param['mandatory']; ?>"
								data-execute-after="<?php echo $param['execute_after']; ?>"
								data-time-unit="<?php echo $param['time_unit']; ?>"
								data-valid-low="<?php echo $param['valid_range_low']; ?>"
								data-valid-high="<?php echo $param['valid_range_high']; ?>"
								data-ref-low="<?php echo $param['ref_range_low']; ?>"
								data-ref-high="<?php echo $param['ref_range_high']; ?>"
								data-comment="<?php echo $param['comment']; ?>"
								></input>
						</div>
					<?php } ?>
					</div>
				</div>
			</div>
			
			<div id="parameters">
				<div class="col-md-11">
					<table class="table">
						<thead>
							<th class="param_col_name">Naziv</th>
							<th class="param_col_mand">Obav.</th>
							<th class="param_col_execute">Izvrsavati na svakih</th>
							<th class="param_col_unit">Vremenska jedinica</th>
							<th class="param_col_mesure_unit">Merna jedinica</th>
							<th class="param_col_valid">Opseg validnih vrednosti</th>
							<th class="param_col_ref">Opseg referentnih vrednosti</th>
							<th class="param_col_comment">Komentar</th>
							<th class="param_col_remove"></th>
						</thead>
						<?php foreach ($assignment['params'] as $param) { //var_dump($param); ?>
						<tr class="parameterElem" <?php if ($param['parameter_id'] == 0) echo 'id="templateParameter" style="display: none;"'; ?>>
							<input type="hidden" class="paramId" name="params[<?php echo $param['parameter_id']; ?>][parameter_id]" value="<?php echo $param['parameter_id']?>"></input>
							<td>
								<span class="paramName">
									<?php if (isset($allParameters[$param['parameter_id']]['name'])) echo $allParameters[$param['parameter_id']]['name']; ?>
								</span>
							</td>
							<td class="paramMandatoryCol">
								<input class="paramMandatory" value="1" name="params[<?php echo $param['parameter_id']; ?>][mandatory]" type="checkbox" <?php if ($param['mandatory'] == 1) echo 'checked'; ?>/>
							</td>
							<td><input class="paramInput paramExecuteAfter" type="number" min="1" name="params[<?php echo $param['parameter_id']; ?>][execute_after]" value="<?php echo $param['execute_after']?>"></th>
							<td>
								<select class="paramTimeUnit ass-choose-area" name="params[<?php echo $param['parameter_id']; ?>][time_unit]" style="width: 100px;">
									<?php foreach ($assignment['all_periods'] as $periodId => $periodName) {?>
									<option value="<?php echo $periodId;?>" <?php if ($periodId == $param['time_unit']) {echo 'selected="selected"';} ?>>
										<?php echo $periodName; ?>
									</option>
									<?php }?>
								</select>
							</td>
							<td style="text-align: center;">
								<?php $measureUnit = isset($allParameters[$param['parameter_id']]) ? $allParameters[$param['parameter_id']]['measure_unit'] : ''; ?>
								<span class="paramMeasureUnit"><?php echo (!empty($measureUnit) ? $measureUnit : '/'); ?></span>
							</td>
							<td>
								<?php if ($param['data_type'] == 0 || $param['data_type'] == 1 || $param['data_type'] == 2) { ?>
								<div class="validRef">
								<div>
									<span>Gornja: </span>
									<span>
										<input class="paramInput paramValidHigh" type="number" step="0.01"
										name="params[<?php echo $param['parameter_id']; ?>][valid_range_high]"
										value="<?php echo $param['valid_range_high']?>">
									</span>
								</div>
								<div>
									<span>Donja: </span>
									<span>
										<input class="paramInput paramValidLow" type="number" step="0.01"
										name="params[<?php echo $param['parameter_id']; ?>][valid_range_low]"
										value="<?php echo $param['valid_range_low']?>">
									</span>
								</div>
								</div>
								<?php } ?>
							</td>
							<td>
								<?php if ($param['data_type'] == 0 || $param['data_type'] == 1 || $param['data_type'] == 2) { ?>
								<div class="validRef">
								<div>
									<span>Gornja: </span>
									<span>
										<input class="paramInput paramRefHigh" type="number" step="0.01"
										name="params[<?php echo $param['parameter_id']; ?>][ref_range_high]"
										value="<?php echo $param['ref_range_high']?>">
									</span>
								</div>
								<div>
									<span>Donja: </span>
									<span>
										<input class="paramInput paramRefLow" type="number" step="0.01"
										name="params[<?php echo $param['parameter_id']; ?>][ref_range_low]"
										value="<?php echo $param['ref_range_low']?>">
									</span>
								</div>
								</div>
								<?php } ?>
							</td>
							<td>
								<textarea class="ass-text-area paramComment" type="text" style="width: 300px;" name="params[<?php echo $param['parameter_id']; ?>][comment]"><?php echo $param['comment']?></textarea>
							</td>
							<td>
								<a class="btn btn-default removeParameter" href="#">x</a>
							</td>
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