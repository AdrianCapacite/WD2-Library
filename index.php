
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

<?php
require_once './includes/partials/footer.php';
?>