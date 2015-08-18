<?php
require 'header.php';
require_once 'DB.php';
require_once 'common.php';


$role = getUserRole();
$userId = $_SESSION['user']['id'];
$user = DB::getUserByMail('nik@gmail.com');
$idd = $user['id'];
echo $idd;
$ass1 = DB::getAssignmentsTable($userId, true);
$ass2 = DB::getAssignmentsTable($userId, false);
$zadaci = array($ass1, $ass2);
//var_dump($ass1);
?>


<form class="form-inline">
	<div class="form-group">
	<?php for ($i = 0; $i<count($zadaci); $i++) {
		if ($i == 0) {?>
		<label for="exampleInputName2">Trenutni zadaci</label>
		<?php } ?>
		<input type="text" class="form-control" id="exampleInputName2">
	</div>
	<div class="form-group">
	<?php if ($i == 1) {?>
		<label for="exampleInputName2">Naredni</label>
		<?php }?>
		<input type="text" class="form-control" id="exampleInputName2">
	</div>
	<?php }?>
	<button type="submit" class="btn btn-default">Send invitation</button>
</form>

<?php 
require 'footer.php';
?>