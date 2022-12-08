<nav>
    <a href="./">Home</a>

    <?php include './includes/partials/book-search.php' ?>

    <div class="dropdown">
        <input hidden type="checkbox" id="user-dropdown-toggle" class="dropdown__toggle">
        <label for="user-dropdown-toggle" class="dropdown__label">User</label>
        <div class="dropdown__content">
            <p>Hi <br><?php echo htmlentities($_SESSION['account']['username']) ?></p>
            <ul>
                <li><a href="./reserved-books.php">Reserved Books</a></li>
                <li><a href="./membership.php">Membership</a></li>
                <li><a href="./logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>