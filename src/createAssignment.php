<?php
require_once 'common.php';
require 'header.php';

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

//var_dump($assignment);
?>

<div>
<form method = "POST" action = "processCreateAssignment.php">
	<ul>
		<div class="form-group">
			<h2 class="form-signin-heading"><div class="login">Napravite zadatak</div></h2>
		</div>
		<div class="form-group">
			<li><label for="email">Pacijent</label>
			<input type="email" name="email" placeholder="email@email.com" required value="<?php echo $assignment['email']?>"></li>
		</div>
		<div class="form-group">
			<li><label for="name">Unesite naziv zadatka</label>
			<input type="text" name="name" required value="<?php echo $assignment['name']?>"></li>
		</div>
		<div class="form-group">
			<li><label for="description">Unesite opis zadatka</label>
			<input type="text" name="description" required value="<?php echo $assignment['description']?>"></li>
		</div>
		<div class="form-group">
			<li><label for="actions">Unesite potrebne akcije</label>
			<input type="text" name="actions" required value="<?php echo $assignment['actions']?>"></li>
		</div>
		<div class="form-group">
			<li><label for="start_time">Unesite datum pocetka</label>
			<input type="date" name="start_time" required value="<?php echo $assignment['start_time']?>"></li>
		</div>
		<div class="form-group">
			<li><label for="end_time">Unesite datum zavrsetka</label>
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
			<li><label for="time_between">Unesite period razmaka</label>
			<input type="int" name="time_between" required value="<?php echo $assignment['time_between']?>"/></li>
		</div>
		<div class="form-group">
			<li>
			<label for="max_delay">Unesite maksimalno kasnjenje</label>
			<input type="number" name="max_delay" required value="<?php echo $assignment['max_delay']?>"/>
			</li>
		</div>
		<div class="form-group">
			<li><label for="comment">Komentar</label>
			<input type="text" name="comment" value="<?php echo $assignment['comment']?>"></li>
		</div>
		<div class="form-group">
			<li><input type="submit" value="Napravi"></li>
		</div>
	</ul>
</form>
</div>

<?php 
require 'footer.php';
?>