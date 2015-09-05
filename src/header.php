<?php 
require_once 'common.php';
require_once 'constants.php';

$role = getUserRole();
?>

<!DOCTYPE html>
<html>
<head>
	<link type="text/css" rel="stylesheet" href="/css/bootstrap.css"/>
	<link type="text/css" rel="stylesheet" href="/css/bootstrap-theme.css"/>
	<link type="text/css" rel="stylesheet" href= "/css/style.css" />
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
						<?php if($_SERVER['PHP_SELF']!='/login.php') {
							if ($role == PACIENT_ROLE) {?>
								<li class='nav nav-pills<?php if($_SERVER['PHP_SELF']=='/patient/home.php') echo 'active'?>'><a href="/patient/home.php">Pocetna</a></li>
								<li class='nav nav-tabs<?php if($_SERVER['PHP_SELF']=='/assignments.php') echo 'active'?>><a href="/assignments.php">Zadaci</a></li>
								<li class='nav nav-tabs<?php if($_SERVER['PHP_SELF']=='/podaci.php') echo 'active'?>><a href="/index.php">Podaci</a></li>
							<?php }?>
							
							<?php if ($role == 2) {?>
								<li class='<?php if($_SERVER['PHP_SELF']=='/doctor/search.php') echo 'active'?> nav nav-pills'><a href="/doctor/search.php">Pacijent</a></li>
								<li class='<?php if($_SERVER['PHP_SELF']=='/doctor/createAccount.php') echo 'active'?> nav nav-pills'><a href="/doctor/createAccount.php">Dodavanje pacijenta</a></li>
								<li class='<?php if($_SERVER['PHP_SELF']=='/doctor/assignments.php') echo 'active'?> nav nav-pills'><a href="/doctor/assignments.php">Zadati zadaci</a></li>
							<?php }?>
							
							<?php if ($role == 3) {?>
								<li class=<?php if($_SERVER['PHP_SELF']=='/adminHomePage.php') echo 'active'?>><a href="/adminhomePage.php">Pocetna</a></li>
								<li class=<?php if($_SERVER['PHP_SELF']=='/createAccount.php') echo 'active'?>><a href="/createAccount.php">Napravi novi nalog</a></li>
							<?php }?>
						<?php } ?>
					</ul>
					</div>
				</div>
				
				<?php if(isset($_SESSION['user'])) { ?>
				<ul class="nav navbar-nav navbar-right">
					<li role="presentation" class="dropdown">
						<a id="profileName" class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
						<?php echo $_SESSION['user']['first_name'] . ' ' . $_SESSION['user']['last_name']; ?> <span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li><a href="#"><a href="../common/profile.php">Profil</a></a></li>
							<li><a href="#"><a href="../logout.php">Izlogujte se</a></a></li>
						</ul>
					</li>
				</ul>
				<?php }?>
			</div>
		</nav>
	</div>
<div id="mainContent">
