<?php
$pageTitle = "Book Search";
$navVisible = true;
require_once './includes/loader.php';
require_once './includes/partials/header.php';

// Check if user credentials are valid
// if not, restart session and redirect to login page
if (!isLoggedIn()) {
	session_destroy();
	session_start();
	header("Location: ./login.php");
}

// get search parameters
// if doesn't exist, set to default
$title = $_GET['title'] ?? '';
$author = $_GET['author'] ?? '';
$category = $_GET['category'] ?? '';
$orderby = $_GET['orderby'] ?? 'title';
$order = $_GET['order'] ?? 'ASC';
$limit = $_GET['limit'] ?? 5;
$page = $_GET['page'] ?? 0;

// display search term
function displaySearchTerm() {
	global $title, $author, $category;
	$title = ($title === '') ? 'Everything' : $title;
	$author = ($author === '') ? 'All Authors' : $author;
	$category = ($category === '') ? 'All' : $category;

	echo "search results for <em>" . htmlentities($title) . "</em>";
	echo " by <em>" . htmlentities($author) . "</em>";
	echo " in <em>" . htmlentities($category) . "</em>";
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
		dbEscapeString($title),
		dbEscapeString($author),
		dbEscapeString($category),
		dbEscapeString($orderby),
		dbEscapeString($order),
		dbEscapeString($limit),
		dbEscapeString($page * $limit)
	),
	'totalCount' => countBooks(
		dbEscapeString($title),
		dbEscapeString($author),
		dbEscapeString($category),
		null
	),
	'shownCount' => countBooks(
		dbEscapeString($title),
		dbEscapeString($author),
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
			<?php displaySearchTerm() ?>
		</h2>
		<div class="book-query__search">
			<!-- Keyword and category search -->
			<?php include './includes/partials/book-search.php' ?>

			<!-- pagnation -->
			<?php createPagination(
				"./books.php",
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
					"./books.php",
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