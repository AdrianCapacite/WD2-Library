<?php
if (!isset($navVisible)) {
	$navVisible = true;
}
if (!isset($bodyClass)) {
	$bodyClass = "";
}
if (!isset($mainContainerClass)) {
	$mainContainerClass = "";
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
	<title><?php echo getFullTitle(); ?></title>
	<!-- Meta -->
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Styles -->
	<!-- Normalize: Make elements consitent between different browsers -->
	<!-- https://github.com/necolas/normalize.css -->
	<link rel="stylesheet" href="https://necolas.github.io/normalize.css/8.0.1/normalize.css">

	<link rel="stylesheet" href="./assets/css/style.css">


	<!-- Scripts -->
	<script src="./assets/js/main.js"></script>

</head>
<body class="<?php echo htmlentities($bodyClass);?>">
<div class="main-container <?php echo htmlentities($mainContainerClass); ?>">
	<?php if ($navVisible === TRUE) { ?>
	<header>
			<?php
			include_once './includes/partials/nav.php';
			showSessionMessage();
			?>
	</header>
	<section class="title">
		<h1>Merrion Square Library</h1>
	</section>
	<?php } ?>
