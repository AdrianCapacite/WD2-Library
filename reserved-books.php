<?php
$pageTitle = "Book Search";
$navVisible = true;
require_once './includes/loader.php';
require_once './includes/partials/header.php';

if (!isLoggedIn()) {
  header("Location: ./login.php");
}

// get search parameters
// if doesn't exist, set to default
$search = $_GET['search'] ?? '';
$category = $_GET['category'] ?? '';
$orderby = $_GET['orderby'] ?? 'title';
$order = $_GET['order'] ?? 'ASC';
$limit = $_GET['limit'] ?? 5;
$page = $_GET['page'] ?? 0;

// display search term
function displaySearchTerm() {
  global $search, $category;
  $term = ($search === '') ? 'everything' : $search;
  $category = ($category === '') ? 'all' : $category;

  echo "search results for <em>" . htmlentities($term) . "</em>";
  echo " in <em>" . htmlentities($category) . "</em> categories";
}

// reserve book
if (isset($_POST['reserve'])) {
  $isbn = dbEscapeString($_POST['reserve']);
  $username = $_SESSION['account']['username'];

  $result = reserveBook($isbn, $username);
  if ($result) {
    redirectMessage("./books.php", "Book reserved.", 1);
  } else {
    redirectMessage("./books.php", "Book could not be reserved.", 3);
  }
}

// unreserve book
if (isset($_POST['unreserve'])) {
  echo "unreserve book";
  $isbn = dbEscapeString($_POST['unreserve']);
  $username = $_SESSION['account']['username'];

  $result = unreserveBook($isbn, $username);
  if ($result) {
    redirectMessage("./books.php", "Book unreserved", 1);
  } else {
    redirectMessage("./books.php", "Book could not be unreserved", 3);
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
    dbEscapeString($page * $limit),
    dbEscapeString($_SESSION['account']['username'])
  ),
  'totalCount' => countBooks(
    dbEscapeString($search),
    dbEscapeString($category),
    null,
    null,
    dbEscapeString($_SESSION['account']['username'])
  ),
  'shownCount' => countBooks(
    dbEscapeString($search),
    dbEscapeString($category),
    dbEscapeString($limit),
    dbEscapeString($page * $limit),
    dbEscapeString($_SESSION['account']['username'])
  )
  );


require_once './includes/partials/header.php';
?>

<main>
  <h1>Merrion Square Library</h1>

  <!-- Book Query -->
  <section>
    <h2>
      Your reserved books
    </h2>
    <div class="book-query__search">
      <!-- Keyword and category search -->
      <div>
        <!-- <form action="books.php" method="get">
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
        </form> -->
      </div>

      <!-- pagnation -->
      <?php createPagination(
        "./reserved-books.php",
        ceil($resultBooks['totalCount'] / $limit),
        $page
      ) ?>
      <!-- Results -->
      <p class="book-query__count">
        <?php createQueryCount($resultBooks['totalCount'], $page*5, $limit) ?>
      </p>
      <div class="book-query__results">
        <?php
        while($book = mysqli_fetch_assoc($resultBooks['books'])) {
          include './includes/partials/book-card.php';
        }
        ?>

        <!-- pagnation -->
        <?php createPagination(
          "./reserved-books.php",
          ceil($resultBooks['totalCount'] / $limit),
          $page
        ) ?>
      </div>
      <!-- END of Results -->


    </div>
  </section>

</main>

<?php
require_once './includes/partials/footer.php';
?>