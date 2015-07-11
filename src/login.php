<?php 
require_once 'common.php';

if (getUserRole() != ANONYMOUS_ROLE) {
	redirect('index.php');
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Log-In</title>
</head>
	<body>
		<div>
			<form method = "POST" action = "processLogin.php">
				<ul>
					<li><label for="usermail">Email</label>
					<input type="email" name="usermail" placeholder="yourname@email.com" required></li>
					<li><label for="password">Sifra</label>
					<input type="password" name="password" placeholder="password" required></li>
					<li><input type="submit" value="Ulogujte se"></li>
				</ul>
			</form>
		</div>
	</body>
</html>

