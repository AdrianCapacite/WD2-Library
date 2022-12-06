<?php
$pageTitle = "Book Search";
$navVisible = true;
require_once './includes/loader.php';
require_once './includes/partials/header.php';

if (!isLoggedIn()) {
  header("Location: ./login.php");
}

// Check if field is empty or not set and replace with default value
$search = $_GET['search'] ?? '';
$category = $_GET['category'] ?? '';
$orderby = $_GET['orderby'] ?? 'title';
$order = $_GET['order'] ?? 'ASC';
$limit = $_GET['limit'] ?? 5;
$page = $_GET['page'] ?? 0;

// Reserve book
if (isset($_POST['reserve'])) {
  echo "Reserve book";
  $isbn = dbEscapeString($_POST['reserve']);
  $username = $_SESSION['account']['username'];

  $result = reserveBook($isbn, $username);
  if ($result) {
    redirectMessage("./books.php", "Book reserved", 1);
  } else {
    redirectMessage("./books.php", "Book could not be reserved", 3);
  }
}

// ==== DATABASE QUERIES ====
$resultBooks = array(
  'books' => queryBooks(
    dbEscapeString($search),
    dbEscapeString($category),
    dbEscapeString($orderby),
    dbEscapeString($order),
    dbEscapeString($limit),
    dbEscapeString($page * $limit)
  ),
  'totalCount' => countBooks(
    dbEscapeString($search),
    dbEscapeString($category),
    null,
  ),
  'shownCount' => countBooks(
    dbEscapeString($search),
    dbEscapeString($category),
    dbEscapeString($limit),
    dbEscapeString($page * $limit)
  )
  );

require_once './includes/partials/header.php';
?>

<main>
  <h1>Merrion Square Library</h1>

  <!-- Book Query -->
  <section>
    <h2>
      Search Results for <em><?php echo htmlentities(($search === '') ? 'Everything' : $search) ?></em>
      in <em><?php echo htmlentities(($category === '') ? 'All' : $category) ?></em> categories
    </h2>
    <div class="book-query__search">
      <!-- Keyword and category search -->
      <div>
        <form action="books.php" method="get">
          <input type="text" name="search" id="search"
              placeholder="Search title or author" value="<?php echo htmlentities($search) ?>">
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
      </div>

      <!-- Pagnation -->
      <?php createPagenation(
        ceil($resultBooks['totalCount'] / $limit),$page
      ) ?>
      <!-- Results -->
      <p class="book-query__count">
        Showing <?php echo $resultBooks['shownCount'] + $page * 5 ?> of <?php echo $resultBooks['totalCount'] ?> results
      </p>
      <div class="book-query__results">
        <?php while($book = mysqli_fetch_assoc($resultBooks['books'])) {?>
        <article class="book">
          <div class="book__image">
            <img src="https://picsum.photos/seed/<?php echo htmlentities($book['isbn']) ?>/333/500.jpg" alt="Book cover">
          </div>
          <div class="book__details">
            <div class="book__details__row">
              <h1 class="book__title">
                <?php echo htmlentities($book['title']) ?>
              </h1>
              <p class="book__edition">
                Edition
                <?php echo htmlentities($book['edition']) ?>
              </p>
              <p class="book__year">
                Published
                <?php echo htmlentities($book['year']) ?>
              </p>
            </div>
            <div class="book__details__row">
              <p class="book__isbn">
                ISBN:
                <?php echo htmlentities($book['isbn']) ?>
              </p>
              <p class="book__author">
                By:
                <?php echo htmlentities($book['author']) ?>
              </p>
            </div>
            <div class="book__details__row">
              <p class="book__category">
                Category:
                <?php echo htmlentities($book['details']) ?>
              </p>
            </div>
          </div>
          <form method="post" action="./books.php">
            <?php formGetKeep(); ?>
            <button <?php if ($book['reserved'] === 'Y') echo 'disabled' ?>
                type="submit" name="reserve"
                value="<?php echo htmlentities($book['isbn']); ?>">
              Reserve Book
            </button>
          </form>
        </article>
        <?php } ?>

        <!-- Pagnation -->
        <?php createPagenation(
          ceil($resultBooks['totalCount'] / $limit),$page
        ) ?>
      </div>
      <!-- END of Results -->


    </div>
  </section>

</main>

<?php
require_once './includes/partials/footer.php';
?>