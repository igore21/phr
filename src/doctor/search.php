<?php
require_once '../header.php';
require_once '../DB.php';

$params = array(
	'file_id' => '',
	'email' => '',
	'first_name' => '',
	'last_name' => '',
);

if (!empty($_GET['file_id'])) {
	$params['file_id'] = $_GET['file_id'];
}
if (!empty($_GET['email'])) {
	$params['email'] = $_GET['email'];
}
if (!empty($_GET['first_name'])) {
	$params['first_name'] = $_GET['first_name'];
}
if (!empty($_GET['last_name'])) {
	$params['last_name'] = $_GET['last_name'];
}

$search = false;
foreach ($params as $param) {
	if (!empty($param)) {
		$search = true;
		break;
	}
}

$patients = array();
if ($search) {
	$params['role'] = PATIENT_ROLE;
	$patients = DB::getUsers($params);
}

?>

<form method = "GET" action = "search.php">
	<ul class="list-unstyled search">
		<div class="container searchResult">
			<div class="form-group">
				<li><label for="file_id" class="searchField">Broj kartona</label>
				<input type="text" name="file_id" value=<?php  echo $params['file_id'];?>></li>
			</div>
			<div class="form-group">
				<li><label for="email" class="searchField">E-mail</label>
				<input type="text" name="email" value=<?php echo $params['email'];?>></li>
			</div>
			<div class="form-group">
				<li><label for="first_name" class="searchField">Ime</label>
				<input type="text" name="first_name" value=<?php echo $params['first_name'];?>></li>
			</div>
			<div class="form-group">
				<li><label for="last_name" class="searchField">Prezime</label>
				<input type="text" name="last_name" value=<?php echo $params['last_name'];?>></li>
			</div>
			<button class="btn btn-md btn-primary searchField col-md-offset-1" type="submit">Pretrazi</button>
		</div>
	</ul>
</form>

<?php if ($search) { ?>
<div class="container pacient_data">
	<div class="col-md-8">
	<h3 class="searchResult table_name">Rezultati pretrage</h3>
	<?php
		if (empty($patients)) echo 'Ne postoje korisnici za zadatu pretragu';
		else {
	?>
	<table class = "table table-bordered">
		<thead>
			<th class="ass_gave">Broj kartona</th>
			<th class="ass_name">Ime</th>
			<th class="ass_name">Prezime</th>
			<th class="ass_description">E-mail</th>
			<th class="ass_description">Akcije</th>
		</thead>
			<?php foreach ($patients as $patient) {?>
			<tr class='list-unstyled'>
				<td><?php echo $patient['file_id'];?></td>
				<td><?php echo $patient['first_name'];?></td>
				<td><?php echo $patient['last_name'];?></td>
				<td><?php echo $patient['email'];?></td>
				<td>
					<ul class="list-unstyled akcije">
						<li><a id="zadaci" href="/doctor/patient/assignmentsPatient.php?user_id=<?php echo $patient['id']?>">Zadaci</a></li>
						<li><a id="noviZadatak" href="/doctor/patient/createAssignment.php?user_id=<?php echo $patient['id']?>">Novi Zadatak</a></li>
						<li><a id="podaci" href="/doctor/patient/dataPatient.php?user_id=<?php echo $patient['id']?>">Podaci</a></li>
					</ul>
				</td>
			</tr>
			<?php }?>
	</table>
	<?php } ?>
	</div>
</div>
<?php } ?>

<?php 
require '../footer.php';
?>