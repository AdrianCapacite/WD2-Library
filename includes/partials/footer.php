<footer>
	<div>
		<span>Adrian Capacite 2022</span>
	</div>
	<?php if (isset($_SESSION['account'])) { ?>
	<div>
		<section>
			<nav>
				<h1>Navigation</h1>
				<ul>
					<li><a href="./">Home</a></li>
					<li><a href="./books.php">Search Books</a></li>
					<li><a href="./reserved-books.php">View Reserved books</a></li>
					<li><a href="./membership.php">Manage membership</a></li>
					<li><a href="./logout.php">Log out</a></li>
				</ul>
			</nav>
		</section>

		<section>
			<h1>Contact Us</h1>
			<p><a href="mailto:info@merrionlibrary">info@merrionlibrary</a></p>
			<p><a href="tel:+353000000000">+353 00 000 0000</a></p>
		</section>
		<section>
			<h1>Location</h1>
			<p>
				Merrion Square Library<br>
				0 Merrion Square<br>
				Dublin 2<br>
				Ireland<br>
				D02 A000
			</p>
		</section>
	</div>
	<?php } ?>
</footer>
</body>
</html>