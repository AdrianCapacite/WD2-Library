<?php
$pageTitle = "Membership Details";
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

// Check if user has submitted update-details form
// and check if
if (isset($_POST['update-details'])) {
	// Fetch user details
	$firstname = dbEscapeString($_POST['firstname'] ?? "");
	$surname = dbEscapeString($_POST['surname'] ?? "");
	$addressline1 = dbEscapeString($_POST['addressline1'] ?? "");
	$addressline2 = dbEscapeString($_POST['addressline2'] ?? "");
	$city = dbEscapeString($_POST['city'] ?? "");
	$telephone = dbEscapeString($_POST['telephone'] ?? "");
	$mobile = dbEscapeString($_POST['mobile'] ?? "");

	$required = array($firstname, $surname, $addressline1, $city, $mobile);

	// Check if required fields are empty
	foreach ($required as $field) {
		if (empty($field)) {
			redirectMessage("./membership.php", "Please fill in all required fields marked with *.", 3);
		}
	}

	// Check if mobile or telephone is 10 digits
	if (strlen($mobile) !== 10) {
		redirectMessage("./membership.php", "Mobile number must be 10 digits.", 3);
	}
	if (strlen($telephone) !== 10 && !empty($telephone)) {
		redirectMessage("./membership.php", "Telephone number must be 10 digits.", 3);
	}

	// Update user details
	$result = updateUserDetails($_SESSION['account']['username'], $firstname, $surname, $addressline1, $addressline2, $city, $telephone, $mobile);

	if ($result) {
		redirectMessage("./membership.php", "Details updated.", 1);
	} else {
		redirectMessage("./membership.php", "Details could not be updated.", 3);
	}
}

// If user submits password update form
if (isset($_POST['update-password'])) {
	// Fetch user details
	$currentPassword = dbEscapeString($_POST['current-password']);
	$newPassword = dbEscapeString($_POST['new-password']);

	// Check if required fields are empty
	if (empty($currentPassword) || empty($newPassword)) {
		redirectMessage("./membership.php", "Please enter both old password and new password", 3);
	}

	// Cech if new password is the same as old password
	if ($currentPassword === $newPassword) {
		redirectMessage("./membership.php", "New password cannot be the same as old password.", 3);
	}

	// Update user password
	$result = updatePassword($_SESSION['account']['username'], $currentPassword, $newPassword);

	switch ($result) {
		case '0':
		redirectMessage("./membership.php", "Old password is incorrect.", 3);
		break;

		case '1':
		redirectMessage("./membership.php", "Password updated.", 1);
		break;

		case '2':
		redirectMessage("./membership.php", "Password could not be updated.", 3);
			break;
	}
}

$userDetails = getUserDetails($_SESSION['account']['username']);

require_once './includes/partials/header.php';
?>

<main>
	<!-- Member details -->
	<section class="details">
		<h2>Member Details</h2>
		<form method="post" action="membership.php" class="details__form" id="user-details">
			<div class="form__group--h">
				<p>Username: <?php echo htmlentities($_SESSION['account']['username']) ?></p>
			</div>
			<div class="form__group--h">
				<label for="firstname" class="form__required">First Name: </label>
				<input type="text" name="firstname" id="firstname" placeholder="First Name" value="<?php echo htmlentities($userDetails['firstname']) ?>" disabled>
				<label for="surname" class=form__required"">Surname: </label>
				<input type="text" name="surname" id="surname" placeholder="Surname" value="<?php echo htmlentities($userDetails['surname']) ?>" disabled>
			</div>
			<!-- Address -->
			<table>
				<tr>
					<td><label for="addressline1" class="form__required">Address Line 1:</label></td>
					<td>
						<input type="text" name="addressline1" id="addressline1" placeholder="Street" value="<?php echo htmlentities($userDetails['addressline1']) ?>" disabled>
					</td>
				</tr>
				<tr>
					<td><label for="addressline2">Address Line 2:</label></td>
					<td>
						<input type="text" name="addressline2" id="addressline2" placeholder="Street" value="<?php echo htmlentities($userDetails['addressline2']) ?>" disabled>
					</td>
				</tr>
				<tr>
					<td><label for="city" class="form__required">City: </label></td>
					<td>
						<input type="text" name="city" id="city" placeholder="City" value="<?php echo htmlentities($userDetails['city']) ?>" disabled>
					</td>
				</tr>
			</table>
			<!-- END Address -->

			<div class="form__group--h">
				<label for="mobile" class="form__required">Mobile: </label>
				<input type="text" name="mobile" id="mobile" placeholder="Mobile" value="<?php echo htmlentities($userDetails['mobile']) ?>" disabled>
				<label for="telephone">Telephone: </label>
				<input type="text" name="telephone" id="telephone" placeholder="Telephone" value="<?php echo htmlentities($userDetails['telephone']) ?>" disabled>
			</div>

			<div class="form__group--h">
				<button type="submit" name="update-details" class="showOnEdit" hidden>Update Details</button>
				<a href="./membership.php">
					<button class="showOnEdit danger" hidden>Cancel</button>
				</a>
				<button type="button" class="hideOnEdit" onclick="enableEdit('user-details')">Edit Details</button>
			</div>

		</form>

		<!-- Change password -->
		<h2>Update Password</h2>
		<form action="membership.php" method="post">
			<table>
				<tr class="form__group--h">
					<label for="current-password">Current Password: </label>
					<input type="password" name="current-password" id="current-password" placeholder="Current Password">
				</tr>
				<tr>
					<td><label for="new-password">New Password: </label></td>
					<td>
						<input type="password" name="new-password" id="new-password" placeholder="New Password">
					</td>
				</tr>
			</table>
			<div class="form__group--h">
				<button type="submit" name="update-password" class="showOnEdit">Update Password</button>
				<a href="./membership.php">
					<button class="showOnEdit danger" hidden>Cancel</button>
				</a>
			</div>
		</form>
	</section>

</main>

<?php
require_once './includes/partials/footer.php';
?>
