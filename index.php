
<?php
$pageTitle = "Home";
$navVisible = true;
require_once './includes/loader.php';
require_once './includes/partials/header.php';

// Check if user credentials are valid
// if not, restart session and redirect to login page
if (!isLoggedIn()) {
	session_destroy();
	session_start();
	header("Location: ./login.php");
}

require_once './includes/partials/header.php';
?>

<main>
	<p class="large">Welcome back! <br> <?php echo htmlentities($_SESSION['account']['username']) ?></p>
</main>

<?php
require_once './includes/partials/footer.php';
?>