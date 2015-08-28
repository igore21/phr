<?php 
require_once 'common.php';
require 'header.php';

if (getUserRole() != ANONYMOUS_ROLE) {
	redirect('index.php');
}
?>
<!-- <div class="container"> -->

<!--       <form class="form-signin"> -->
<!--         <h2 class="form-signin-heading">Please sign in</h2> -->
<!--         <label for="inputEmail" class="sr-only">Email address</label> -->
<!--         <input type="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus> -->
<!--         <label for="inputPassword" class="sr-only">Password</label> -->
<!--         <input type="password" id="inputPassword" class="form-control" placeholder="Password" required> -->
<!--         <div class="checkbox"> -->
<!--           <label> -->
<!--             <input type="checkbox" value="remember-me"> Remember me -->
<!--           </label> -->
<!--         </div> -->
<!--         <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button> -->
<!--       </form> -->

   
<!DOCTYPE html>
<html>
<head>
	<link type = "text/css" href="css/bootstrap.css" rel="stylesheet"/>
	<link type = "text/css" href="css/bootstrap-theme.css" rel="stylesheet"/>
	<link type = "text/css" href="css/style.css" rel="stylesheet"/>
	<title>Log-In</title>
</head>
	<body>
		<div>
			<form method = "POST" action = "processLogin.php">
				<ol class="list-unstyled">
				<div class="container">
				<div class="login-login">
				<form class="form-signin">
				<h2 class="form-signin-heading"><div class="login">Ulogujte se</div></h2>
					<li><label for="usermail" class="distance">Email</label>
					<input type="email" name="usermail" class="form-control" placeholder="yourname@email.com" required autofocus></li>
					<li><label for="password" class="distance">Sifra</label>
					<input type="password" name="password" class="form-control" placeholder="password" required></li>
					<div class="checkbox">
          				<label><input type="checkbox" value="remember-me">Zapamti me</label>
          				</div>
          				<button class="btn btn-lg btn-primary btn-block" type="submit">Ulogujte se</button>				
          		</form>
					</div>
				</div>
				</ol>
			</form>
		</div>
	</body>
</html>

<?php 
require 'footer.php';
?>
