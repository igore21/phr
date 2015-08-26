<?php 
	require_once 'DB.php';
	require_once 'common.php';
	$role = getUserRole();
	$page = basename($_SERVER["SCRIPT_FILENAME"]);
	if(isset($_SESSION['user'])) $userEmail = $_SESSION['user']['email'];
?>
<!DOCTYPE html>
<html>
<head>
	<link type = "text/css" href="css/bootstrap.css" rel="stylesheet"/>
	<link type = "text/css" href="css/bootstrap-theme.css" rel="stylesheet"/>
	<link rel="stylesheet" type="text/css" href="css/style.css" />
</head>
<body>
	<div>
		<nav class="navbar navbar-inverse navbar-fixed-top">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
					</button>
				</div>
				<div class="navbar-header">
					<div id="navbar" class="navbar-collapse collapse">
					<ul class="nav navbar-nav">
						<li class="brand"><a href="#">PHR</a></li>
						<?php if($page!='login.php') {
						if ($role == 1) {?>
							<li class='nav nav-pills<?php if($page=='homePage.php') echo 'active'?>'><a href="homePage.php">Pocetna</a></li>
							<li class='nav nav-tabs<?php if($page=='assignments.php') echo 'active'?>><a href="assignments.php">Zadaci</a></li>
							<li class='nav nav-tabs<?php if($page=='podaci.php') echo 'active'?>><a href="index.php">Podaci</a></li>
						<?php }?>
						
						<?php if ($role == 2) {?>
							<li class='<?php if($page=='search.php') echo 'active'?> nav nav-pills'><a href="search.php">Pacijent</a></li>
							<li class='<?php if($page=='createAssignment.php') echo 'active'?> nav nav-pills'><a href="createAssignment.php">Dodavanje pacijenta</a></li>
							<li class='<?php if($page=='assignments.php') echo 'active'?> nav nav-pills'><a href="assignments.php">Zadati zadaci</a></li>
						<?php }?>
						
						<?php if ($role == 3) {?>
							<li class=<?php if($page=='adminHomePage.php') echo 'active'?>><a href="adminhomePage.php">Pocetna</a></li>
							<li class=<?php if($page=='createAccount.php') echo 'active'?>><a href="createAccount.php">Napravi novi nalog</a></li>
						<?php }?>
					</ul>
					</div>
				</div>
				
				<ul class="nav navbar-nav navbar-right">
		        	<li role="presentation" class="dropdown">
			        	<a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
				        <?php echo $userEmail;?> <span class="caret"></span></a>
			        	<ul class="dropdown-menu">
							<li><a href="#">Profil</a></li>
							<li><a href="#"><a href="logout.php">logout</a></a></li>
						</ul>
		        	</li>	
		      	</ul>
		      	<?php }?>
			</div>
		</nav>
	</div>
<div style="margin-top: 50px;">
