<?php
// ======== GLOBALS ========

// ======== UTILITIES ========

/**
 * Fetches top level property from config file
 *
 * @param string $property
 * @return string
 */
function getConfig($property) {
  return (include('./conf/config.php'))[$property];
}

/**
 * Returns current page uri
 *
 * @return void
 */
function currentPage() {
  return $_SERVER["PHP_SELF"];
}

/**
 * Uses header("Location: ...") to redirect to a page
 *
 * @param string $uri
 * @param msg $msg (optional) Message to display on redirected page
 * @return void
 */
function redirectTo($uri){
  header( "Location: {$uri}" );
  exit;
}

/**
 * Redirect to error page with error message
 *
 * @param int $errid
 * @return void
 */
function redirectError($errid){
  $_SESSION['error'] = array('date' => date("d/m/y H:i:s"), 'message' => $errid);
  redirectTo('./error.php');
}

/**
 * Redirect to page with message, a page will display message however it wants
 *
 * type: 0 = info, 1 = warning, 2 = error
 *
 * @param string $uri
 * @param string $body
 * @param int $type
 * @return void
 */
function redirectMessage($uri, $body, $type) {
  sessionMessage($body, $type);
  redirectTo($uri);
}

/**
 * Creates a JavaScript console log
 *
 * @param string $message
 */
function consoleLog($message){
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
function sessionMessage($body, $type = 0) {
  $types = array('info', 'success', 'warning', 'error');
  $_SESSION['msg'] = array(
    'body' => $body,
    'type' => $types[$type]
  );
  return;
}

function formGetKeep($keys = null) {
  // Keeps keys that are used
  if ($keys === null) {
    $keys = array('search', 'category', 'orderby', 'order', 'offset', 'page');
  }

  foreach($keys as $name) {
  if(!isset($_GET[$name])) {
    continue;
  }
  $value = htmlspecialchars($_GET[$name]);
  $name = htmlspecialchars($name);
  echo '<input type="hidden" name="'. $name .'" value="'. $value .'">';
}
}

function createPagination($page, $total, $current) {
  ?>
  <form action="<?php echo htmlentities($page) ?>" method="get" class="pagination">
    <?php
    formGetKeep(array('search', 'category', 'orderby', 'order', 'offset'));

    // Previous button if not on first page
    if($current > 0) {
      echo "<button type='submit' name='page' value='". ($current - 1) ."'>Previous</button>";
    }

    // Show current and total pages
    echo '<span>Page '. ($current + 1) .' of '. $total .'</span>';
    // Next button if not on last page
    if ($current < $total - 1) {
      echo "<button type='submit' name='page' value='". ($current + 1) ."'>Next</button>";
    }
    ?>
  </form>
  <?php
}

function createQueryCount($total, $offset, $limit) {
  $start = $offset + 1;
  $end = $offset + $limit;
  if ($end > $total) {
    $end = $total;
  }
  echo '<p>Showing '. $start .'-'. $end .' of '. $total .' results</p>';
}

function showSessionMessage() {
  if (!isset($_SESSION['msg'])) {
    return;
  }
  $msg = $_SESSION['msg'];
  unset($_SESSION['msg']);
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
 * @param [type] $book
 * @return integer
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