<?php

$allPatientAssignmentsActive = DB::getAssignments($patientId, false, true);
$allPatientAssignmentsNotActive = DB::getAssignments($patientId, false, false);
$allAssignments = array_merge($allPatientAssignmentsActive, $allPatientAssignmentsNotActive);
$translatedParameters = getTranslatedParameters();

$searchData = array();
$params = array();
$isAss = true;
if (!empty($_GET['assignment_id'])) {
	$searchData['assignment_id'] = $_GET['assignment_id'];
} else if (!empty($_GET['parameter_id'])) {
	$isAss = false;
	$searchData['parameter_id'] = $_GET['parameter_id'];
}

if (!empty($searchData)) {
	$searchData['patient_id'] = $patientId;
	$params = DB::getData($searchData);
}

$isDoctor = getUserRole() == DOCTOR_ROLE;

?>

<form method="GET" action="<?php $isDoctor ? 'dataPatient.php' : 'patientData.php'; ?>">
	<?php if ($isDoctor) { ?>
	<input type="hidden" class="taskId" name="user_id" value="3"></input>
	<?php } ?>
	<ul class="list-unstyled search">
		<div class="container searchResult">
			<div class="form-group">
				<label for="assignment_id" class="searchDataLabel">Podaci za zadatak </label>
				<select class="ass-choose-area" id="assignmentDataList" name="assignment_id">
					<option selected="selected" value="0">Izaberite zadatak</option>
					<?php foreach ($allAssignments as $index => $ass) {?>
						<option value="<?php echo $ass['id'];?>"><?php echo $ass['name'];?></option>
					<?php }?>
				</select>
				<button type="submit" class="searchDataBtn btn btn-primary btn-md">Prikazi</button>
			</div>
			<div class="form-group">
				<label for="parameter_id" class="searchDataLabel">Podaci za parametar </label>
				<select class="ass-choose-area" id="parameterDataList" name="parameter_id">
					<option selected="selected" value="0">Izaberite parametar</option>
					<?php foreach ($translatedParameters as $index => $param) {?>
						<option value="<?php echo $param['id'];?>"><?php echo $param['name'];?></option>
					<?php }?>
				</select>
				<button type="submit" class="searchDataBtn btn btn-primary btn-md">Prikazi</button>
			</div>
		</div>
	</ul>
</form>

<?php if (!empty($searchData)) { ?>
<div class="dataResult col-md-4">
	<?php if (empty($params)) { ?>
		<h3>Ne postoje podaci za zadatu pretragu</h3>
	<?php } else { ?>
			
	<div class="">
		<?php if ($isAss) { ?>
			<h3>Zadatak: <?php echo $params[0]['name']; ?></h3>
		<?php } else { ?>
			<h3>Parametar: <?php echo $translatedParameters[$params[0]['parameter_id']]['name']; ?></h3>
		<?php } ?>
		<table class="table table-bordered">
		<thead>
			<th class="data_param"><?php echo $isAss ? 'Parametar' : 'Zadatak'; ?></th>
			<th class="data_time">Zakazano vreme</th>
			<th class="data_value">Vrednost</th>
			<th class="data_status">Status</th>
		</thead>
		<?php foreach ($params as $param) { ?>
		<tr>
			<td>
				<?php echo $isAss ? $translatedParameters[$param['parameter_id']]['name'] : $param['name']; ?>
			</td>
			<td><?php echo $param['scheduled_time']?></td>
			<td>
				<?php
					$value = '';
					if ($param['data_type'] == 1) $value = $param['integer_value'];
					else if ($param['data_type'] == 2) $value = $param['double_value'];
					else if ($param['data_type'] == 3) $value = $param['string_value'];
					else if ($param['data_type'] == 4) $value = $param['bool_value'] ? 'Uradjeno' : '';
					echo $value;
				?>
				<?php if (!empty($param['measure_unit']) && (!empty($param['integer_value']) || !empty($param['double_value']))) { ?>
					<span class="paramMeasureUnit"><?php echo $param['measure_unit']; ?></span>
				<?php } ?>
			</td>
			<td>
				<?php if ($param['state'] == DataState::COMPLETED) { 
					$validLow = !empty($param['valid_range_low']) ? $param['valid_range_low'] : '/';
					$validHigh = !empty($param['valid_range_high']) ? $param['valid_range_high'] : '/';
					$refLow = !empty($param['ref_range_low']) ? $param['ref_range_low'] : '/';
					$refHigh = !empty($param['ref_range_high']) ? $param['ref_range_high'] : '/';
				?>
					<?php if ((!empty($param['valid_range_low']) && $value <= $validLow) || (!empty($param['valid_range_high']) && $value >= $validHigh)) { ?>
						<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true" style="color: red;"></span>
						<span><?php echo $validLow . ' - ' . $validHigh; ?></span>
					<?php } else if ((!empty($param['ref_range_low']) && $value <= $refLow) || (!empty($param['ref_range_high']) && $value >= $refHigh)) {?>
						<span class="glyphicon glyphicon-warning-sign" aria-hidden="true" style="color: orange;"></span>
						<span><?php echo $refLow . ' - ' . $refHigh; ?></span>
					<?php } else { ?>
						<span class="actionOk glyphicon glyphicon-ok" aria-hidden="true" style="color: green;"></span>
					<?php } ?>
				<?php } else if ($param['state'] == DataState::IGNORED && $param['mandatory']) { ?>
					<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true" style="color: red;"></span>
					<span>Obavezan</span>
				<?php } else if ($param['state'] == DataState::DRAFT) { ?>
					<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
				<?php } else if ($param['state'] == DataState::PENDING) { ?>
					<span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
				<?php } ?>
			</td>
		</tr>
		<?php } ?>
	</span>
	<?php } ?>

</div>
<?php } ?>