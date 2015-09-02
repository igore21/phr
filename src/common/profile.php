<?php
require_once '../DB.php';
require_once '../common.php';
require '../header.php';
require_once '../constants.php';
$sesion = $_SESSION;
if (!empty($_GET)) {
	$id = $_GET['user_id'];
	$user = DB::getUserById($id);
	$first_name = $user['first_name'];
	$last_name = $user['last_name'];
	$email = $user['email'];
?>

<!DOCTYPE html>
<html>
<head>
	<link type = "text/css" href="css/bootstrap.css" rel="stylesheet"/>
	<link type = "text/css" href="css/bootstrap-theme.css" rel="stylesheet"/>
	<link type = "text/css" href="css/style.css" rel="stylesheet"/>
</head>
	
<body>
<form method = "POST" action = "processEditProfile.php">
<div class="edit-user">
	<ul class="list-unstyled search">
		<div class="form-group">
			<h2 class="form-signin-heading"><div class="user-info-h2">Podaci o korisniku</div></h2>
		</div>
		<div class="form-group">
			<li><label for="first_name" class="account-info">Ime</label>
			<input type="text" data-value="<?php echo $user['first_name']?>" name="first_name" id="fn" required value="<?php echo $user['first_name']?>" disabled="true"></li>
		</div>
		<div class="form-group">
			<li><label for="last_name" class="account-info">Prezime</label>
			<input type="text" data-value="<?php echo $user['last_name']?>" name="last_name" id="ln" required value="<?php echo $user['last_name']?>" disabled="true"></li>
		</div>
		<div class="form-group">
			<li><label for="email" class="account-info">Email</label>
			<input type="email" data-value="<?php echo $user['email']?>" name="email" placeholder="email@email.com" id="em" required value="<?php echo $user['email']?>" disabled="true"></li>
		</div>
		<button class="btn btn-md btn-primary btn-block edit-btn" id="editProfileInfo" type="submit">Promeni</button>
		<div class="form-group saveOrCancel" style="display: none">
			<button class="btn btn-sm btn-primary btn-primary save-change-edit-btn" id="changeProfileInfo" type="submit">Sacuvaj</button>
			<button class="btn btn-sm btn-primary btn-danger cancel-change-edit-btn" id="cancelChangeProfileInfo" type="submit">Otkazi</button>
		</div>
	</ul>
</div>
</form>

<form method = "POST" action = "processEditPassword.php">
<div class="edit-user">
	<ul class="list-unstyled search">
		<div class="form-group">
			<h2 class="form-signin-heading"><div class="user-info-h2">Promena sifre</div></h2>
		</div>
		<div class="form-group">
			<li><label for="password" class="account-info">Sifra</label>
			<input type="password" name="password" placeholder="password" id="op" required></li>
		</div>
		<div class="form-group">
			<li><label for="newPassword" class="account-info">Nova sifra</label>
			<input type="password" name="newPassword" placeholder="password" id="np" required></li>
		</div>
		<div class="form-group">
			<li><label for="repeatNewPassword" class="account-info">Nova sifra</label>
			<input type="password" name="repeatNewPassword" placeholder="password" id="rnp" required></li>
		</div>
		
		
		
		<div class="form-group">
			<button class="btn btn-md btn-primary save-change-pass-btn" id="saveChangedPassword" type="submit">Sacuvaj</button>
		</div>
	</ul>
</div>
</form>
<?php }?>









	</body>
</html>
































<?php 
require '../footer.php';
?>