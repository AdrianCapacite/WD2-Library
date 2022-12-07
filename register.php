<?php
$pageTitle = "Login";
$navVisible = FALSE;
require_once './includes/loader.php';
require_once './includes/partials/header.php';
?>

<?php
// Attempt to login user
if (isLoggedIn()) {
  header("Location: ./");
} else {
  if (isset($_POST['register'])) {
    $username = $_POST['username'] ?? null;
    $password = $_POST['password'] ?? null;

    register($username, $password);
  }
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
          <input type="text" name="username" id="username" required>
        </div>
        <div class="form__group">
          <label for="password">Password</label>
          <input type="password" name="password" id="password" required>
        </div>
        <div class="form_group form__group">
          <p>Already registered? <a href="register.php">Login here.</a></p>
          <button type="submit" name="register">Register</button>
        </div>
      </form>
    </div>
  </section>
</main>

<?php
  require_once './includes/partials/footer.php';
?>
