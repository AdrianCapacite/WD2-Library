<!DOCTYPE html>
<html lang="en">
<head>
    <?php
        $pageTitle = "Register";
        require_once "./includes/head.php";
    ?>
</head>
<body>
    <main class="creds">
        <img src="./assets/images/Merrion-Square-EGHN-30-1-1200x800.jpg" alt="Image of Merrion Square" class="creds__img">
        <div class="creds__formContainer">
            <span class="siteTitle large">Merrion Square Library</span>
            <h1 class="creds__title">Register</h1>
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
                    <span>Already registered? <a href="./login.php">Login here</a></span>
                    <input type="submit" name="register" value="Register" class="form__submit">
                </div>
            </form>
        </div>
    </main>
</body>
</html>