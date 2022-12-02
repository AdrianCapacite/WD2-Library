<?php
  if (!isset($navVisible)) {
    $navVisible = TRUE;
  }
  /**
   * Sets the page title
   *
   * @param $pageTitle
   */
  function setPageTitle($title) {
    global $pageTitle;
    $pageTitle = $title;
  }

  /**
   * Gets full page title: "Page Title | Site Title"
   *
   * @param string $pageTitle The title of the pag
   * @return string page title and site title
   */
  function getFullTitle() {

    global $pageTitle;
    $config = include('conf/config.php');
    $siteName = $config['site']['name'];

    if (isset($pageTitle)) {
      $title = $pageTitle . " | " . $siteName;
    } else {
      $title = $siteName;
    }

    return htmlentities($title);
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title><?php echo getFullTitle($pageTitle); ?></title>
  <!-- Meta -->
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Styles -->
  <link rel="stylesheet" href="./assets/css/normalize.css">
  <link rel="stylesheet" href="./assets/css/style.css">
  <script src="https://kit.fontawesome.com/87e2e714ed.js" crossorigin="anonymous"></script>

</head>
<body>
  <header><?php if ($navVisible === TRUE) include_once './includes/partials/nav.php' ?></header>


