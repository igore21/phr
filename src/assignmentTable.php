<?php 
	$showDoctor = !isset($render['skipDoctor']) || $render['skipDoctor'] == false;
	$showPatient = !isset($render['skipPatient']) || $render['skipPatient'] == false;
	$assignments = $render['assignments'];
	$allParameters = $render['allParameters'];
?>
<div class="col-md-11 assignmentTable">
	<?php if (!empty($render['tableName'])) { ?>
	<h3 class="table_name"><?php echo $render['tableName']; ?></h3>
	<?php } ?>
	<table class="table table-bordered">
	<thead>
		<th class="ass_numb">#</th>
		<?php if ($showDoctor) { ?>
			<th class="ass_doctor">Doktor</th>
		<?php } ?>
		<?php if ($showPatient) { ?>
			<th class="ass_patient">Pacijent</th>
		<?php } ?>
		<th class="ass_name">Naziv zadatka</th>
		<th class="ass_description">Opis zadatka</th>
		<th class="ass_durration">Trajanje</th>
		<th class="ass_params">Parametri</th>
		<th class="ass_action">Akcije</th>
	</thead>
	<?php foreach ($assignments as $index => $ass) {?>
		<tr>
			<td><?php echo $index+1; ?>.</td>
			<?php if ($showDoctor) { ?>
				<td><?php echo $ass['doctor_first_name'] . ' ' . $ass['doctor_last_name'] ?></td>
			<?php } ?>
			<?php if ($showPatient) { ?>
				<td><?php echo $ass['patient_first_name'] . ' ' . $ass['patient_last_name'] ?></td>
			<?php } ?>
			<td><?php echo $ass['name']; ?></td>
			<td><?php echo $ass['description']; ?></td>
			<td>
				<div>
					<span>Od: </span>
					<span><?php echo $ass['start_time']; ?></span>
				</div>
				<div>
					<span>Do: </span>
					<span><?php echo $ass['end_time']; ?></span>
				</div>
			</td>
			<td>
				<?php foreach ($ass['params'] as $param) { ?>
				<div>
					<span><b><?php echo $allParameters[$param['parameter_id']]['name']; ?></b></span>
					<span> - <?php echo $param['comment']; ?></span>
				</div>
				<?php } ?>
			</td>
			<td>
				<ul class="list-unstyled linkList">
					<li><a id="zadaci" href="/doctor/patient/editAssignment.php?user_id=<?php echo $ass['patient_id']; ?>&assignment_id=<?php echo $ass['id']?>">Detalji</a></li>
					<li><a id="noviZadatak" href="/doctor/patient/dataPatient.php">Podaci</a></li>
				</ul>
			</td>
			<!-- <td><?php echo $ass['doctor_first_name'].' '; echo $ass['doctor_last_name']?></td> -->
		</tr>
	<?php }?>
	</table>
</div>
