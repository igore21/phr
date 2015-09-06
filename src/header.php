<?php 
require_once 'common.php';
require_once 'constants.php';
require_once 'DB.php';

$role = getUserRole();

$pathParts = explode("/", $_SERVER['PHP_SELF']);
array_shift($pathParts);
$pageName = end($pathParts);

if (($pathParts[0] == 'doctor' && $role != DOCTOR_ROLE) || ($pathParts[0] == 'patient' && $role == PATIENT_ROLE)) {
	redirect('/login.php');
}

$hasSubMenu = count($pathParts) > 2 && $pathParts[0] == 'doctor' && $pathParts[1] == 'patient';
$reqUserId = '';
$reqUserFullName = '';
if (isset($_GET['user_id'])) {
	$reqUserId = $_GET['user_id'];
	$reqUser = DB::getUser(array('user_id' => $reqUserId));
	$reqUserFullName = $reqUser['first_name'] . ' ' . $reqUser['last_name'];
}

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
						<?php if ($pageName != 'login.php') {
							if ($role == PATIENT_ROLE) {?>
								<li class="<?php if ($pageName == 'home.php') echo 'active'?>"><a href="/patient/home.php">Pocetna</a></li>
								<li class="<?php if ($pageName == 'assignments.php') echo 'active'?>"><a href="/patient/assignments.php">Zadaci</a></li>
								<li class="<?php if ($pageName == 'data.php') echo 'active'?>"><a href="/patient/data.php">Podaci</a></li>
							<?php }?>
							<?php if ($role == DOCTOR_ROLE) {?>
								<li class="<?php if ($pageName == 'search.php' || (count($pathParts) > 2 && $pathParts[1] == 'patient')) echo 'active'?>">
									<a href="/doctor/search.php">Pacijent</a>
								</li>
								<li class="<?php if ($pageName == 'createAccount.php') echo 'active'?>"><a href="/doctor/createAccount.php">Dodavanje pacijenta</a></li>
								<li class="<?php if ($pageName == 'assignments.php') echo 'active'?>"><a href="/doctor/assignments.php">Zadati zadaci</a></li>
							<?php }?>
						<?php } ?>
					</ul>
					</div>
				</div>
				
				<?php if(isset($_SESSION['user'])) { ?>
				<ul class="nav navbar-nav navbar-right">
					<li role="presentation" class="dropdown">
						<a id="profileName" class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
							<?php echo $_SESSION['user']['first_name'] . ' ' . $_SESSION['user']['last_name']; ?>
							<span class="caret"></span>
						</a>
						<ul class="dropdown-menu">
							<li><a href="#"><a href="/common/profile.php">Profil</a></a></li>
							<li><a href="#"><a href="/logout.php">Izlogujte se</a></a></li>
						</ul>
					</li>
				</ul>
				<?php }?>
			</div>
		</nav>
	</div>
	<div id="mainContent">
		<?php if ($hasSubMenu) { ?>
		<span class="subMenu">
			<div class="patientNameSubMenu">Pacijent: <?php echo $reqUserFullName; ?></div>
			<div>
				<ul class="nav nav-pills nav-stacked">
					<li role="presentation" class="<?php if ($pageName == 'assignmentsPatient.php') echo 'active'; ?>">
						<a href="/doctor/patient/assignmentsPatient.php?user_id=<?php echo $reqUserId; ?>">Zadaci</a>
					</li>
					<li role="presentation" class="<?php if ($pageName == 'createAssignment.php') echo 'active'; ?>">
						<a href="/doctor/patient/createAssignment.php?user_id=<?php echo $reqUserId; ?>">Novi Zadatak</a>
					</li>
					<li role="presentation" class="<?php if ($pageName == 'dataPatient.php') echo 'active'; ?>">
						<a href="/doctor/patient/dataPatient.php?user_id=<?php echo $reqUserId; ?>">Podaci</a>
					</li>
				</ul>
			</div>
		</span>
		<?php } ?>
		<span class="<?php if ($hasSubMenu) echo 'rightContent'?>">
	
