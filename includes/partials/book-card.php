<!-- Book-card -->
<article class="book">
	<div class="book__img">
		<img src="https://picsum.photos/seed/<?php echo htmlentities($book['isbn']) ?>/333/500.jpg" alt="Book cover">
	</div><!--.book__img-->
	<div class="book__details">
		<div class="book__details__row">
			<h1 class="book__title">
				<?php echo htmlentities($book['title']) ?>
			</h1>
			<p class="book__edition">
				Edition
				<?php echo htmlentities($book['edition']) ?>
			</p>
			<p class="book__year">
				Published
				<?php echo htmlentities($book['year']) ?>
			</p>
		</div>
		<div class="book__details__row">
			<p class="book__isbn">
				ISBN:
				<?php echo htmlentities($book['isbn']) ?>
			</p>
			<p class="book__author">
				By:
				<?php echo htmlentities($book['author']) ?>
			</p>
		</div>
		<div class="book__details__row">
			<p class="book__category">
				Category:
				<?php echo htmlentities($book['category']) ?>
			</p>
		</div>
		<div class="book__reserve">
			<p class="book__reserve__details">
				<?php
				if ($book['reserved'] === 'Y') {
				echo "Reserved by " . getReservedBy($book) . "<br>on ". $book['reserveddate'];
				}
				?>
			</p>
			<form action="./books.php" method="post">
				<?php
				formGetKeep();
				switch (getBookStatus($book)) {
					case 0:
						echo '<button type="submit" name="reserve" value="'.htmlentities($book['isbn']).'">Reserve Book</button>';
						break;
					case 1:
						echo '<button disabled type="submit" name="reserve" value="'.htmlentities($book['isbn']).'">Unavailable</button>';
						break;
					case 2:
						echo '<button type="submit" name="unreserve" value="'.htmlentities($book['isbn']).'">Unreserve Book</button>';
						break;
				}
				?>
			</form>
		</div><!--.book__reserve-->
	</div><!--.book__details-->
</article>