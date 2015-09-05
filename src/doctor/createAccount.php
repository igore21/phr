<?php
require '../header.php';

$errorMsg = '';
if (isset($_SESSION['createAccountError'])) {
	$errorMsg = $_SESSION['createAccountError'];
	unset($_SESSION['createAccountError']);
}

$account = array(
	'first_name' => '',
	'last_name' => '',
	'file_id' => '',
	'email' => '',
);
if (isset($_SESSION['createAccountData'])) {
	$account = array_replace($account, $_SESSION['createAccountData']);
	unset($_SESSION['createAccountData']);
}

?>

<form method="POST" action="processCreateAccount.php" autocomplete="off">
	<ul class="list-unstyled create-assignment">
		<div class="container">
			<?php if (!empty($errorMsg)) { ?>
				<div class="alert alert-danger change-success-alert" role="alert" id="createAccountErrorMsg">
					<?php echo $errorMsg; ?>
				</div>
			<?php } ?>
			<div class="form-group">
				<h2 class="form-signin-heading"><div class="login">Unesite podatke</div></h2>
			</div>
			<div class="form-group">
				<li><label for="first_name" class="assField">Ime</label>
				<input type="text" name="first_name" required value="<?php echo $account['first_name']; ?>"></li>
			</div>
			<div class="form-group">
				<li><label for="last_name" class="assField">Prezime</label>
				<input type="text" name="last_name" required value="<?php echo $account['last_name']?>"></li>
			</div>
			<div class="form-group">
				<li><label for="file_id" class="assField">Broj kartona</label>
				<input type="text" name="file_id" required value="<?php echo $account['file_id']; ?>"></li>
			</div>
			<div class="form-group">
				<li>
					<label for="email" class="assField">Email</label>
					<input type="email" name="email" placeholder="email@email.com" required autocomplete="off" value="<?php echo $account['email']?>">
				</li>
			</div>
			<div class="form-group">
				<li><label for="password" class="assField">Sifra</label>
				<input style="display:none" type="password" name="fakepasswordremembered"/>
				<input type="password" name="password" placeholder="password" required></li>
			</div>
			<div class="form-group">
				<button class="btn btn-md btn-primary save-change-pass-btn" type="submit">Sacuvaj</button>
			</div>
		</div>
	</ul>
</form>

<?php 
	require '../footer.php';
?>