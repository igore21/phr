<?php 
	require_once 'DB.php';
	require_once '/common.php';
	$role = getUserRole();
	$page = basename($_SERVER["SCRIPT_FILENAME"]);
	if(isset($_SESSION['user'])) $userName = $_SESSION['user']['first_name'];
	//$id = $_SESSION['user']['id'];
?>
<!DOCTYPE html>
<html>
<head>
	<link type = "text/css" href="/css/bootstrap.css" rel="stylesheet"/>
	<link type = "text/css" href="/css/bootstrap-theme.css" rel="stylesheet"/>
	<link rel="stylesheet" type="text/css" href= "/css/style.css" />
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
						<?php if($page!='login.php') {
						if ($role == 1) {?>
							<li class='nav nav-pills<?php if($page=='homePage.php') echo 'active'?>'><a href="homePage.php">Pocetna</a></li>
							<li class='nav nav-tabs<?php if($page=='assignments.php') echo 'active'?>><a href="assignments.php">Zadaci</a></li>
							<li class='nav nav-tabs<?php if($page=='podaci.php') echo 'active'?>><a href="index.php">Podaci</a></li>
						<?php }?>
						
						<?php if ($role == 2) {?>
							<li class='<?php if($page=='doctor/search.php') echo 'active'?> nav nav-pills'><a href="/doctor/search.php">Pacijent</a></li>
							<li class='<?php if($page=='doctor/createAccount.php') echo 'active'?> nav nav-pills'><a href="/doctor/createAccount.php">Dodavanje pacijenta</a></li>
							<li class='<?php if($page=='doctor/assignments.php') echo 'active'?> nav nav-pills'><a href="/doctor/assignments.php">Zadati zadaci</a></li>
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
				        <?php echo $userName; $id = $_SESSION['user']['id'];//echo $id;?> <span class="caret"></span></a>
			        	<ul class="dropdown-menu">
							<li><a href="#"><a href="../common/profile.php?user_id=<?php echo $id;?>">Profil</a></a></li>
							<li><a href="#"><a href="../logout.php">Izlogujte se</a></a></li>
						</ul>
		        	</li>	
		      	</ul>
		      	<?php }?>
			</div>
		</nav>
	</div>
<div style="margin-top: 50px;">
