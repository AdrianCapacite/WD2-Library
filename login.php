<?php
$pageTitle = "Login";
$navVisible = FALSE;
require_once './includes/loader.php';
require_once './includes/partials/header.php';
?>

<?php
// If user is already logged in then redirect to index.php
if (isLoggedIn()) {
  header("Location: ./");
}

// When user submits login form, attempt to login
if (isset($_POST['login'])) {
  login(dbEscapeString($_POST['username'] ?? null),
        dbEscapeString($_POST['password'] ?? null));
}
?>

<main class="creds">
  <img src="./assets/images/Merrion-Square-EGHN-30-1-1200x800.jpg" alt="Image of Merrion Square" class="creds__img">
  <div class="creds__formContainer">
    <span class="siteTitle large">Merrion Square Library</span>
    <h1 class="creds__title">Login</h1>
    <?php
    // If there is a redirect message, display it
    if (isset($_SESSION['msg'])) {
      $body = htmlentities($_SESSION['msg']['body']);
      $type = htmlentities($_SESSION['msg']['type']);
      unset($_SESSION['msg']);
    ?>
      <!-- Redirect message -->
      <div>
        <p class="creds__msg <?php $type ?>"> <?php echo $body ?> </p>
      </div>
    <?php } ?>
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
