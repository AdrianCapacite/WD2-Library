
<?php
$pageTitle = "Home";
$navVisible = true;
require_once './includes/loader.php';
require_once './includes/partials/header.php';

if (!isLoggedIn()) {
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