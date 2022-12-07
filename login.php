<?php
$pageTitle = "Login";
$navVisible = false;
// $pageScroll = false;
require_once './includes/loader.php';

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

<?php require_once './includes/partials/header.php'; // <body> ?>

<main>
  <!-- Login prompt -->
  <section class="auth">
    <img src="./assets/images/Merrion-Square-EGHN-30-1-1200x800.jpg" alt="" class="auth__img">
    <div>
      <h1>Merrion Square Library</h1>
      <h2>Login</h2>
      <?php showSessionMessage(); ?>
      <form action="login.php" method="post" class="auth__form">
        <div class="form__group">
          <label for="username">Username</label>
          <input type="text" name="username" id="username" required>
        </div>
        <div class="form__group">
          <label for="password">Password</label>
          <input type="password" name="password" id="password" required>
        </div>
        <div class="form_group form__group">
          <p>Not registered? <a href="register.php">Register here.</a></p>
          <button type="submit" name="login">Login</button>
        </div>
      </form>
    </div>
  </section>
</main>

<?php
  require_once './includes/partials/footer.php'; // </body>
?>
