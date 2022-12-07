<nav>
    <a href="./">Home</a>
    <!-- Book Search -->
    <form action="books.php" method="get">
        <input type="text" name="search" id="search" placeholder="Search title or author">
        <select name="category" id="category">
            <option value="">All</option>
            <?php
            foreach (getCategories() as $category) {
                echo "<option value='$category'>$category</option>";
            }
            ?>

        </select>
        <input type="submit" value="Search">
    </form>

    <!-- Dropdown -->
    <!-- <button id="user-dropdown" class="drop-down" onclick="toggleActive(this);">
        <span>User</span>
        <div class="drop-down__content">
            <ul>
                <li><a href="./reserved.php">Reserved Books</a></li>
                <li><a href="./membership.php">Membership</a></li>
                <li><a href="./logout.php">Logout</a></li>
            </ul>
        </div>
    </button> -->
    <div class="dropdown">
        <input hidden type="checkbox" id="user-dropdown-toggle" class="dropdown__toggle">
        <label for="user-dropdown-toggle" class="dropdown__label">User</label>
        <div class="dropdown__content">
            <ul>
                <li><a href="./reserved.php">Reserved Books</a></li>
                <li><a href="./membership.php">Membership</a></li>
                <li><a href="./logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>