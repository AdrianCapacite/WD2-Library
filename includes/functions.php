<?php
/**
 * Library Website Database
 * Author: Adrian Thomas Capacite C21348423
 *
 * ======== FUNCTIONS ========
 *
 */

/**
 * Fetches top level property from config file
 *
 * @param string $property
 * @return array
 */
function getConfig($property):array {
	return (include('./conf/config.php'))[$property];
}


/**
 * Uses header("Location: ...") to redirect to a page
 *
 * @param string $uri
 * @param string $msg (optional) Message to display on redirected page
 * @return void
 */
function redirectTo($uri):void {
	header( "Location: {$uri}" );
	exit;
}

/**
 * Redirect to page with message, a page will display message however it wants
 *
 * type: 0 = info (default), 1 = success, 2 = warning, 3 = error
 *
 * @param string $uri
 * @param string $body
 * @param int $type
 * @return void
 */
function redirectMessage($uri, $body, $type):void {
	sessionMessage($body, $type);
	redirectTo($uri);
}

/**
 * Creates a JavaScript console log
 *
 * @param string $message
 * @return void
 */
function consoleLog($message):void {
	echo "<script>console.log('PHP: " . htmlentities($message) ."');</script>";
}

/**
 * Sets $_SESSION['msg'] to a message with a type, a page will display message however it wants
 *
 * type: 0 = info (default), 1 = success, 2 = warning, 3 = error
 *
 * @param string $body
 * @param integer $type = 0
 * @return void
 */
function sessionMessage($body, $type = 0):void {
	$types = array('info', 'success', 'warning', 'error');
	$_SESSION['msg'] = array(
		'body' => $body,
		'type' => $types[$type]
	);
	return;
}

/**
 * Fetches url parameters and creates hidden inputs
 * @param mixed $keys (optional) Array of keys to keep, if null then keep default keys
 * @return void
 */
function formGetKeep($keys = null):void {
	// Default keys to keep if none are specified
	if ($keys === null) {
		$keys = array('title', 'author', 'category', 'orderby', 'order', 'offset', 'page');
	}

	// Loop through keys and create hidden inputs
	foreach($keys as $name) {
	if(!isset($_GET[$name])) {
		continue;
	}
	$value = htmlspecialchars($_GET[$name]);
	$name = htmlspecialchars($name);
	echo '<input type="hidden" name="'. $name .'" value="'. $value .'">';
	}
}

/**
 * Creates a pagination form
 *
 * @param string $page
 * @param integer $total
 * @param integer $current
 * @return void
 */
function createPagination($page, $total, $current):void {
	// Create form with hidden inputs to keep url parameters
	echo '<form action="'. htmlentities($page) .'" method="get" class="pagination">';
	formGetKeep(array('search', 'category', 'orderby', 'order', 'offset'));

	// Previous button if not on first page
	if($current > 0) {
		echo "<button type='submit' name='page' value='". ($current - 1) ."'>Previous</button>";
	} else {
		echo "<button type='submit' name='page' value='". ($current - 1) ."' disabled>Previous</button>";
	}

	// Show current and total pages
	echo '<span>Page '. ($current + 1) .' of '. $total .'</span>';

	// Next button if not on last page
	if ($current < $total - 1) {
		echo "<button type='submit' name='page' value='". ($current + 1) ."'>Next</button>";
	} else {
		echo "<button type='submit' name='page' value='". ($current + 1) ."' disabled>Next</button>";
	}
	echo '</form>';
}

/**
 * Echos number of results shown on page and total number of results
 *
 * @param int $total
 * @param int $offset
 * @param int $limit
 * @return void
 */
function createQueryCount($total, $offset, $limit):void {
	$start = $offset + 1;
	$end = $offset + $limit;
	if ($end > $total) {
		$end = $total;
	}
	echo '<p>Showing '. $start .'-'. $end .' of '. $total .' results</p>';
}

/**
 * Fetches a message from $_SESSION['msg'] and displays it
 * @return void
 */
function showSessionMessage():void {
	// Check if message exists then unset it
	if (!isset($_SESSION['msg'])) {
		return;
	}
	$msg = $_SESSION['msg'];
	unset($_SESSION['msg']);

	// Display message
	?>
	<div class="msg-box <?php echo htmlentities($msg['type']); ?>">
		<p><?php echo htmlentities($msg['body']); ?></p>
	</div>
	<?php
}

// Book functions
/**
 * Reads an associative array describing a book and returns a string describing the status
 *
 * Returns: 0 = Available, 1 = Reserved, 2 = Reserved by user
 *
 * @param array $book
 * @return int
 */
function getBookStatus($book):int {
	if ($book['reserved'] == 'N') {
		return 0; // Available
	}

	// It is implied reserved == 'Y' from here
	if ($book['reservedby'] == $_SESSION['account']['username']) {
		return 2; // Reserved by user
	}

	return 1;
}

/**
 * Reads an associative array describing a book and returns a string of who reserved it
 * @param array $book
 * @return string|null
 */
function getReservedBy($book):string | null {
	if ($book['reserved'] == 'N') {
		return '';
	}

	// It is implied reserved == 'Y' from here
	if ($book['reservedby'] == $_SESSION['account']['username']) {
		return 'You';
	}

	return $book['reservedby'];
}

?>