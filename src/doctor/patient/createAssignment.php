<?php
require_once '../../common.php';
require_once '../../DB.php';
require '../../header.php';

if (empty($_GET['user_id'])) {
	redirect('/doctor/search.php');
}
$patientId = $_GET['user_id'];
$patient = DB::getUser(array('user_id' => $patientId));
if (empty($patient)) {
	redirect('/doctor/search.php');
}

$assignment = array(
	'patient_id' => $patientId,
	'name' => '',
	'description' => '',
	'start_time' => '',
	'end_time' => '',
	'time_between' => '8',
	'period' => PERIOD_HOURS,
	'comment' => '',
	'paramIds' => array(),
);

$allParameters = DB::getParameters();
foreach ($allParameters as $id => $param) {
	$allParameters[$id]['name'] = $TANSLATED_PARAMETERS_RS[$param['name']];
}
$assignment['parameters'] = $allParameters;

if (isset($_SESSION['new_assignment'])) {
	$assignment = array_replace($assignment, $_SESSION['new_assignment']);
	unset($_SESSION['new_assignment']);
}

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

?>

<?php if (!empty($errorMsg)) { ?>
	<div class="alert alert-danger change-success-alert" role="alert"><?php echo $errorMsg; ?></div>
<?php } ?>

<form method="POST" action="processCreateAssignment.php">
	<ul class="list-unstyled create-assignment">
		<div class="container">
			<div class="form-group">
				<h2 class="form-signin-heading">Napravite zadatak</h2>
			</div>
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
				<div><h3 class="form-signin-heading">Nacin primene</h3></div>
				<li>
					<label class="assField">Primenjuje se 1 na svaka/svakih</label>
					<input class="ass-choose-area" type="int" name="time_between" required value="<?php echo $assignment['time_between']?>"/>
					<select name="period" class="ass-choose-area">
						<?php foreach ($assignment['all_periods'] as $periodId => $periodName) {?>
						<option value="<?php echo $periodId;?>" <?php if ($periodId == $assignment['period']) {echo 'selected="selected"';} ?>>
							<?php echo $periodName; ?>
						</option>
						<?php }?>
					</select>
				</li>
			</div>
			<div class="form-group">
				<li>
					<label for="comment" class="assField">Komentar</label>
					<textarea class="ass-text-area" type="text" name="comment" value="<?php echo $assignment['comment']?>"></textarea>
				</li>
			</div>
			
			<div class="form-group">
				<div><h3 class="form-signin-heading">Parametri</h3></div>
				<li>
					<label class="assField">Izaberite parametre</label>
					<select class="ass-choose-area" id="parameterList" name="params">
						<option selected="selected" value="0">Izbaerite parametar</option>
						<?php foreach ($assignment['parameters'] as $index => $param) {?>
							<option value="<?php echo $param['id'];?>"><?php echo $param['name'];?></option>
						<?php }?>
					</select>
					<a class="btn btn-default btn-sm add-param" id="addParameter" href="#">Dodaj parametar</a>
				</li>
			</div>
			
			<div id="parameters">
				<div id="templateParameter" class="parameterElem" style="display: none;">
					<input type="hidden" class="paramId" name="paramIds[]" value="0"></input>
					<a class="btn btn-default removeParameter" href="#">x</a>
					<span class="parameterName"></span>
				</div>
				<?php foreach ($assignment['paramIds'] as $id) { ?>
				<div class="parameterElem">
					<input type="hidden" class="paramId" name="paramIds[]" value="<?php echo $id; ?>"></input>
					<a class="btn btn-default removeParameter" href="#">x</a>
					<span class="parameterName"><?php echo $assignment['parameters'][$id]['name'] ?></span>
				</div>
				<?php } ?>
			</div>
			
			<div class="form-group">
				<li><input type="submit" class="create btn btn-md btn-primary assField-btn" value="Napravi Zadatak"></li>
			</div>
		</div>
	</ul>
</form>

<?php 
	require '../../footer.php';
?>