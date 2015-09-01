<?php
require '../header.php';
?>

<!DOCTYPE html>
<html>
<head>
<!-- <title>Log-In</title> -->
</head>
<body>
<div>
<form method = "POST" action = "processCreateAccount.php">
	<ul class="list-unstyled create-assignment">
		<div class="container">
			<div class="form-group">
				<h2 class="form-signin-heading"><div class="login">Unesite podaatke</div></h2>
			</div>
			<div class="form-group">
				<li><label for="first_name" class="assField">Ime</label>
				<input type="text" name="first_name" placeholder="first name" required></li>
			</div>
			<div class="form-group">
				<li><label for="last_name" class="assField">Prezime</label>
				<input type="text" name="last_name" required></li>
			</div>
			<div class="form-group">
				<li><label for="email" class="assField">Email</label>
				<input type="email" name="email" placeholder="email@email.com" required></li>
			</div>
			<div class="form-group">
				<li><label for="password" class="assField">Sifra</label>
				<input type="password" name="password" placeholder="password" required></li>
			</div>
			<div class="form-group">
				<li><input type="submit" value="Napravi"></li>
			</div>
		</div>
	</ul>
</form>
</div>
</body>
</html>

<?php 
	require '../footer.php';
?>