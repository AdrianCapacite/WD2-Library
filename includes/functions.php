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
  $_SESSION['msg'] = array(
    'body' => $body,
    'type' => $type
  );
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

function formGetKeep() {
  // Keeps keys that are used
  $keys = array('search', 'category', 'orderby', 'order', 'offset');

  foreach($keys as $name) {
  if(!isset($_GET[$name])) {
    continue;
  }
  $value = htmlspecialchars($_GET[$name]);
  $name = htmlspecialchars($name);
  echo '<input type="hidden" name="'. $name .'" value="'. $value .'">';
}
}

?>