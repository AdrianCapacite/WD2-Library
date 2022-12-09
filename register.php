<?php
$pageTitle = "Login";
$navVisible = FALSE;
$bodyClass = "accent";
require_once './includes/loader.php';
require_once './includes/partials/header.php';
?>

<?php
// If user is already logged in then redirect to index.php
if (isLoggedIn()) {
	header("Location: ./");
}

// Check if user has submitted register form
// and check if username and password are not empty
// then attempt to register user
if (isset($_POST['register'])) {
	$username = dbEscapeString($_POST['username'] ?? "");
	$password = dbEscapeString($_POST['password'] ?? "");

	if (empty($username) || empty($password)) {
		redirectMessage("register.php", "Please enter a username and password.", 3);
	}

	register($username, $password);
}

?>

<main>
	<!-- Register prompt -->
	<section class="auth">
		<img src="./assets/images/Merrion-Square-EGHN-30-1-1200x800.jpg" alt="" class="auth__img">
		<div>
			<h1>Merrion Square Library</h1>
			<h2>Register</h2>
			<?php showSessionMessage(); ?>
			<form action="register.php" method="post" class="auth__form">
				<div class="form__group">
					<label for="username">Username</label>
					<input type="text" name="username" id="username" placeholder="Username">
				</div>
				<div class="form__group">
					<label for="password">Password</label>
					<input type="password" name="password" id="password" placeholder="Password">
				</div>
				<div class="form_group form__group">
					<p>Already registered? <a href="login.php">Login here.</a></p>
					<button type="submit" name="register">Register</button>
				</div>
			</form>
		</div>
	</section>
</main>

<?php
	require_once './includes/partials/footer.php';
?>
