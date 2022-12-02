<?php
$pageTitle = "Login";
$navVisible = FALSE;
require_once './includes/partials/header.php';
require_once './includes/loader.php'
?>

<?php
// Attempt to login user
if (isLoggedIn()) {
  header("Location: ./");
} else {
  if (isset($_POST['login'])) {
    $username = $_POST['username'] ?? null;
    $password = $_POST['password'] ?? null;

    consoleLog("Logging in user: $username");
    login($username, $password);
  }
}

?>

<main class="creds">
  <img src="./assets/images/Merrion-Square-EGHN-30-1-1200x800.jpg" alt="Image of Merrion Square" class="creds__img">
  <div class="creds__formContainer">
    <span class="siteTitle large">Merrion Square Library</span>
    <h1 class="creds__title">Login</h1>
    <?php
    if (isset($_SESSION['authError'])) {
      echo "<p class='error'>" . htmlentities($_SESSION['authError']) . "</p>";
      unset($_SESSION['authError']);
    }
    ?>
    <form action="./login.php" method="post" class="creds__form form">

      <div class="form__group-vertical">
        <label for="username" class="form__label">Username</label>
        <input type="text" name="username" id="username" placeholder="Username" required class="form__input">
      </div>
      <div class="form__group-vertical">
        <label for="password" class="form__label">Password</label>
        <input type="password" name="password" id="password" placeholder="Password" required class="form__input">
      </div>
      <div class="form__group-horizontal">
        <span>Not a member? <a href="./register.php">Register here</a></span>
        <input type="submit" name="login" value="Login" class="form__submit">
      </div>
    </form>
  </div>
</main>

<?php
  require_once './includes/partials/footer.php';
?>
