<?php
require '../header.php';
?>

<div>
<form method = "POST" action = "processCreateAccount.php" autocomplete="off">
	<ul class="list-unstyled create-assignment">
		<div class="container">
			<div class="form-group">
				<h2 class="form-signin-heading"><div class="login">Unesite podatke</div></h2>
			</div>
			<div class="form-group">
				<li><label for="first_name" class="assField">Ime</label>
				<input type="text" name="first_name" required></li>
			</div>
			<div class="form-group">
				<li><label for="last_name" class="assField">Prezime</label>
				<input type="text" name="last_name" required></li>
			</div>
			<div class="form-group">
				<li><label for="file_id" class="assField">Broj kartona</label>
				<input type="text" name="file_id" required></li>
			</div>
			<div class="form-group">
				<li><label for="email" class="assField">Email</label>
				<input type="email" name="email" placeholder="email@email.com" required autocomplete="off"></li>
			</div>
			<div class="form-group">
				<li><label for="password" class="assField">Sifra</label>
				<input style="display:none" type="password" name="fakepasswordremembered"/>
				<input type="password" name="password" placeholder="password" required></li>
			</div>
			<div class="form-group">
				<button class="btn btn-md btn-primary save-change-pass-btn" id="saveChangedPassword" type="submit">Sacuvaj</button>
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