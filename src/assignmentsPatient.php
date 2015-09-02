<?php
require 'header.php';
require_once 'common.php';
require_once 'DB.php';


$role = getUserRole();
$userId = $_SESSION['user']['id'];
if ($role == ANONYMOUS_ROLE) redirect('login.php');
$ID = $_GET['user_id'];
//var_dump($ID);
$ass1 = DB::getPatientAssignmentsTable($ID, true);
$ass2 = DB::getPatientAssignmentsTable($ID, false);
//var_dump($ass1);
?>


<nav class="navbar navbar-inverse" id="submenu">
<div class="container">
	<div>
      	<p class="navbar-text"><a href="#">Zadaci</a></p>
      	<p class="navbar-text"><a href="#">Novi zadatak</a></p>
      	<p class="navbar-text"><a href="#">Podaci</a></p>
    </div>
</div>
</nav>
<div>
	<div class="col-md-11 assignmentTable">
<?//if (empty($ass1)) { echo "bla";?>
		<h3 class="table_name">Tabela aktivnih zadataka za <?php echo DB::getUserById($_GET['user_id'])['first_name']; echo ' '. DB::getUserById($_GET['user_id'])['last_name'];?></h3>
			<table class = "table table-bordered">
			<thead>
				<th class="bla">#</th>
				<th class="ass_gave">Zadao</th>
				<th class="ass_name">Naziv zadatka</th>
				<th class="ass_name">Opis zadatka</th>
				<th class="ass_name">Trajanje</th>
				<th class="ass_description">Akcije</th>
			</thead>
			<?php foreach ($ass1 as $c => $ass) {?>
				<tr>
		 			<td><?php echo $c+1; ?></td>
		 			<td><?php echo $ass['doctor_first_name'].' '; echo $ass['doctor_last_name']?></td>
		 			<td><?php echo $ass['name'];?></td>
		 			<td><?php echo $ass['description']; ?></td>
		 			<td><?php echo $ass['start_time'].' ';?> do <?php echo $ass['end_time']?></td>
		 			<td>
		 			<td>
					<td>
		 				<ul class="list-unstyled akcije">
						<li><a id="zadaci" href="assignmentsPacient.php?user_id=<?php echo $ass['id']?>">Zadaci</a></li>
						<li><a id="noviZadatak" href="createAssignment.php">Novi Zadatak</a></li>
						<li><a id="podaci" href="#">Podaci</a></li>
						</ul>
					</td>
				</td>
				</tr>
		 	<?php }?>
			</table>
	</div>
	<?php //};
	//else echo 'Ne postoje podaci';
	?>
</div>

<div>
	<div class="col-md-11 assignmentTable">
		<h3 class="table_name">Tabela zavrsenih zadataka za <?php echo DB::getUserById($_GET['user_id'])['first_name']; echo ' '. DB::getUserById($_GET['user_id'])['last_name'];?></h3>
			<table class = "table table-bordered">
			<thead>
				<th class="bla">#</th>
				<th class="ass_gave">Zadao</th>
				<th class="ass_name">Naziv zadatka</th>
				<th class="ass_name">Opis zadatka</th>
				<th class="ass_name">Trajanje</th>
				<th class="ass_description">Akcije</th>
			</thead>
			<?php foreach ($ass2 as $c => $ass) {?>
				<tr>
		 			<td><?php echo $c+1; ?></td>
		 			<td><?php echo $ass['doctor_first_name'].' '; echo $ass['doctor_last_name']?></td>
		 			<td><?php echo $ass['name'];?></td>
		 			<td><?php echo $ass['description']; ?></td>
		 			<td><?php echo $ass['start_time'].' ';?> do <?php echo $ass['end_time']?></td>
		 			<td>
		 				<ul class="list-unstyled akcije">
						<li><a id="zadaci" href="assignmentsPacient.php?user_id=<?php echo $ass['id']?>">Zadaci</a></li>
						<li><a id="noviZadatak" href="createAssignment.php">Novi Zadatak</a></li>
						<li><a id="podaci" href="#">Podaci</a></li>
						</ul>
					</td>
				</tr>
		 	<?php }?>
			</table>
	</div>
</div>


	
<?php 
require 'footer.php';
?>