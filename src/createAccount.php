<?php
require 'header.php';
?>

<!DOCTYPE html>
<html>
<head>
<!-- <title>Log-In</title> -->
</head>
<body>
<div>
<form method = "POST" action = "processCreateAccount.php">
	<ul>
		<div class="form-group">
			<h2 class="form-signin-heading"><div class="login">Unesite parametre</div></h2>
		</div>
		<div class="form-group">
			<li><label for="first_name">Unesite ime</label>
			<input type="text" name="first_name" required></li>
		</div>
		<div class="form-group">
			<li><label for="last_name">Unesite prezime</label>
			<input type="text" name="last_name" required></li>
		</div>
		<div class="form-group">
			<li><label for="email">Email</label>
			<input type="email" name="email" placeholder="email@email.com" required></li>
		</div>
		<div class="form-group">
			<li><label>Izaberite ulogu</label>
			<select name="role">
			<option>1</option>
			<option>2</option>
			</select></li>
		</div>
		<div class="form-group">
			<li><label for="password">Sifra</label>
			<input type="password" name="password" placeholder="password" required></li>
		</div>
		<div class="form-group">
				<li><input type="submit" value="Napravi"></li>
	</ul>
</form>
</div>
</body>
</html>

<?php 
	require 'footer.php';
?>