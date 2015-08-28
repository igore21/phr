
<?php
require '../header.php';
require_once '../common.php';
require_once '../DB.php';


$role = getUserRole();
$userId = $_SESSION['user']['id'];
if ($role == ANONYMOUS_ROLE) redirect('login.php');
?>



<div class='page-header'>
  <div class='btn-toolbar pull-right'>
    <div class='btn-group'>
      <button type='button' class='btn btn-primary'><a href="createAccount.php">Napravite novi zadatak</a></button>
    </div>
  </div>
</div>

<?php 
	$ass1 = DB::getDoctorAssignmentsTable($userId, true);
	$ass2 = DB::getDoctorAssignmentsTable($userId, false);
	$zadaci = array($ass1, $ass2);
	$ass3 = DB::getDoctorAssignmentsTable($userId, false);
	$k = count($ass1);
	$l = count($ass2);
	if ($zadaci[0]==$ass1) {?>
		<div>
			<h2 class="table_name">Tabela aktivnih zadataka</h2>
				<table class = "table table-bordered">
				<thead>
					<th class="bla">#</th>
					<th class="ass_name">Naziv zadatka</th>
					<th class="ass_durration">Trajanje</th>
					<th class="ass_description">Opis zadatka</th>
					<th class="ass_description">Akcije</th>
					<th class="ass_description">Uzimati na svakih</th>
					<th class="ass_description">Komentari</th>
					<th class="ass_gave">Zadao</th>
				</thead>
				<?php foreach ($ass1 as $c => $ass) {?>
					<tr>
			 			<td><?php echo $c+1; ?></td>
			 			<td><?php echo $ass['name']; ?></td>
			 			<td><?php echo $ass['start_time']; ?> do <?php echo $ass['end_time']; ?></td>
			 			<td><?php echo $ass['description']; ?></td>
			 			<td><?php echo $ass['actions']; ?></td>
			 			<td><?php echo $ass['frequency']; ?></td>
			 			<td><?php echo $ass['comment']; ?></td>
			 			<td><?php echo $ass['doctor_first_name'].' '; echo $ass['doctor_last_name']?></td>
					</tr>
			 	<?php }?>
				</table>
	<?php }?>
		</div>
		
	<?php 
	if ($zadaci[1]==$ass2) {?>
		<div>
			<h2 class="table_name">Tabela zavrsenih zadataka</h2>
		</div>
		<table class = "table table-bordered">
			<thead>
				<th class="bla">#</th>
				<th class="ass_name">Naziv zadatka</th>
				<th class="ass_durration">Trajanje</th>
				<th class="ass_description">Opis zadatka</th>
				<th class="ass_description">Akcije</th>
				<th class="ass_description">Uzimati na svakih</th>
				<th class="ass_description">Komentari</th>
				<th class="ass_gave">Zadao</th>
			</thead>
			<?php foreach ($ass2 as $c => $ass) {?>
				<tr>
		 			<td><?php echo $c+1; ?></td>
		 			<td><?php echo $ass['name']; ?></td>
		 			<td><?php echo $ass['start_time']; ?> do <?php echo $ass['end_time']; ?></td>
		 			<td><?php echo $ass['description']; ?></td>
		 			<td><?php echo $ass['actions']; ?></td>
		 			<td><?php echo $ass['frequency']; ?></td>
		 			<td><?php echo $ass['comment']; ?></td>
		 			<td><?php echo $ass['doctor_first_name'].' '; echo $ass['doctor_last_name']?></td>
				</tr>
			<?php } ?>
			
	<?php }?>			
				
				
				
		
<?php 
	require '../footer.php';

?>