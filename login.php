<!DOCTYPE html>
<html lang="en">
<head>
    <?php
        $pageTitle = "Login";
        require_once "./includes/head.php";
    ?>
</head>
<body>
    <?php
        require_once './includes/index.php';
        if ($GLOBALS['loggedIn']) {
            $_SESSION['info'] = "Logged in as " . $_SESSION['username'];
            header("Location: ./home.php");
        }
    ?>

    <main class="creds">
        <img src="./assets/images/Merrion-Square-EGHN-30-1-1200x800.jpg" alt="Image of Merrion Square" class="creds__img">
        <div class="creds__formContainer">
            <span class="siteTitle large">Merrion Square Library</span>
            <h1 class="creds__title">Login</h1>
            <form action="./register.php" method="post" class="creds__form form">
                <div class="form__group-vertical">
                    <label for="username" class="form__label">Username</label>
                    <input type="text" name="username" id="username" placeholder="Username" required class="form__input">
                </div>
                <div class="form__group-vertical">
                    <label for="password" class="form__label">Password</label>
                    <input type="password" name="password" id="password" placeholder="Password" required class="form__input">
                </div>
                <div class="form__group-horizontal">
                    <span>Already registered? <a href="./register.php">Register here</a></span>
                    <input type="submit" name="register" value="Login" class="form__submit">
                </div>
            </form>
        </div>
    </main>



</body>
</html>