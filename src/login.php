<?php 
require_once 'common.php';
require 'header.php';

if (getUserRole() != ANONYMOUS_ROLE) {
	redirect('index.php');
}

$errorMessage = '';
if (isset($_SESSION['loginError'])) {
	$errorMessage = $_SESSION['loginError'];
	unset($_SESSION['loginError']);
}
?>

<div>
	<form method = "POST" action = "processLogin.php">
		<ol class="list-unstyled">
		<div class="container">
			<div class="login-login">
				<form class="form-signin">
				<h2 class="form-signin-heading"><div class="login">Ulogujte se</div></h2>
					<li>
						<label for="usermail" class="distance">Email</label>
						<input type="email" name="usermail" class="form-control" placeholder="yourname@email.com" required autofocus>
					</li>
					<li>
						<label for="password" class="distance">Sifra</label>
						<input type="password" name="password" class="form-control" placeholder="password" required>
					</li>
					<?php if (!empty($errorMessage)) {?>
					<div class="btn btn-md btn-block alert btn-danger error-login" role="alert"><?php echo $errorMessage;?></div>
					<?php }?>
					<button class="btn btn-lg btn-primary btn-block try-login" type="submit">Ulogujte se</button>				
				</form>
			</div>
		</div>
		</ol>
	</form>
</div>
	

<?php 
require 'footer.php';
?>
