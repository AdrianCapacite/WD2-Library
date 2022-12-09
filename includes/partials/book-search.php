<!-- Book Search -->
<form action="books.php" method="get" class="search">

	<input type="text" name="title" id="title" placeholder="Title" class="search__input">
	<input type="text" name="author" id="author" placeholder="Author" class="search__input">
	<select name="category" id="category" class="search__input">
		<option value="">All</option>
		<?php
		foreach (getCategories() as $category) {
			echo "<option value='$category'>$category</option>";
		}
		?>

	</select>
	<button type="submit" class="search__input">Search</button>
</form>