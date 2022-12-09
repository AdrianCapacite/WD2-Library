<?php
$pageTitle = "Login";
$navVisible = false;
$bodyClass = "accent";
require_once './includes/loader.php';

// If user is already logged in then redirect to index.php
if (isLoggedIn()) {
  header("Location: ./");
}

// If user has submitted login form and username and password are not empty
// then attempt to login user
if (isset($_POST['login'])) {
  $username = dbEscapeString($_POST['username'] ?? "");
  $password = dbEscapeString($_POST['password'] ?? "");

  // Check if username and password are not empty
  if (empty($username) || empty($password)) {
    redirectMessage("login.php", "Please enter a username and password.", 3);
  }
  login($username, $password);
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
          <input type="text" name="username" id="username" placeholder="Username">
        </div>
        <div class="form__group">
          <label for="password">Password</label>
          <input type="password" name="password" id="password" placeholder="Password">
        </div>
        <div class="form__group">
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
