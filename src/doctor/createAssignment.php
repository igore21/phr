<?php
require_once '../common.php';
require '../header.php';
require_once '../constants.php';
var_dump($_GET);
$userId = $_GET['user_id'];
$user = DB::getUserById($userId);
$assignment = getEmptyAssignment();

if (isset($_SESSION['new_assignment'])) {
	$assignment = $_SESSION['new_assignment'];
}
if (isset($_SESSION['createAssignmentError'])) {
	echo $_SESSION['createAssignmentError'];
}

$assignment['all_periods'] = array(
		PERIOD_HOURS => 'sati',
		PERIOD_DAYS => 'dani',
		PERIOD_WEEKS =>	'nedelje',
);

$parameters['all_params'] = array(
		blood_pressure => 'krvni pritisak',
		height => 'visina',
		weight => 'tezina',
		temperature => 'telesna temperatura',
);

//var_dump($assignment);
?>

<div>
<form method = "POST" action = "processCreateAssignment.php">
	<ul class='list-unstyled create-assignment'>
		<div class="container">
			<div class="form-group">
				<h2 class="form-signin-heading"><div>Napravite zadatak</div></h2>
			</div>
			<div class="form-group">
				<li><label for="name">Pacijent:  <?php echo $user['first_name']; echo $user['last_name'];?></label>
			</div>
			<div class="form-group">
				<li><label for="name" class="assField">Naziv zadatka</label>
				<input type="text" name="name" required value="<?php echo $assignment['name']?>"></li>
			</div>
			<div class="form-group">
				<li><label for="description" class="assField">Opis zadatka</label>
				<input type="text" name="description" required value="<?php echo $assignment['description']?>"></li>
			</div>
			<div class="form-group">
				<li><label for="start_time" class="assField">Datum pocetka</label>
				<input type="date" name="start_time" required value="<?php echo $assignment['start_time']?>"></li>
			</div>
			<div class="form-group">
				<li><label for="end_time" class="assField">Datum zavrsetka</label>
				<input type="date" name="end_time" required value="<?php echo $assignment['end_time']?>"></li>
			</div>
			<div class="form-group">
				<li><label>Izaberite stepen ucestalosti</label>
				<select name="period">
				<?php foreach ($assignment['all_periods'] as $pk => $pv) {?>
					<option value="<?php echo $pk;?>" <?php if ($pk==$assignment['all_periods']) {echo 'selected="selected"';}?>>
						<?php echo $pv; ?>
					</option>
				<?php }?>
				</select></li>
			</div>
			<div class="form-group">
				<li><label for="time_between" class="assField">Period razmaka</label>
				<input type="int" name="time_between" required value="<?php echo $assignment['time_between']?>"/></li>
			</div>
			<div class="form-group">
				<li>
				<label for="max_delay" class="assField">Maksimalno kasnjenje</label>
				<input type="number" name="max_delay" required value="<?php echo $assignment['max_delay']?>"/>
				</li>
			</div>
			<div class="form-group">
				<li><label for="comment" class="assField">Komentar</label>
				<input type="text" name="comment" value="<?php echo $assignment['comment']?>"></li>
			</div>
			<div class="form-group">
					<li><label>Izaberite parametre</label>
					<option value="0" selected></option>
					<select id="parameterList" name="params">
					<?php foreach ($parameters['all_params'] as $pak => $pav) {?>
						<option value="<?php echo $pak;?>" ><?php echo $pav;?> 
						</option>
					<?php }?>
					</select><a class="btn btn-default btn-sm add-param" id="addParameter" href="#">Dodaj parametar</a></li>
			</div>
			<div id="parameters">
				<div id="templateParameter" class="parameterElem" style="display: none;">
					<input type="hidden" id="paramId" name="paramIds[]"></input>
					<a class="btn btn-default removeParameter" href="#">x</a>
					<span class="parameterName"></span>
				</div>
			</div>
			<div class="form-group">
				<li><input type="submit" class="create btn btn-md btn-primary assField-btn" value="Napravi"></li>
			</div>
		</div>
				</ul>
	</form>
</div>




<?php 
require '../footer.php';
?>