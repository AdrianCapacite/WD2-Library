<article class="book">
  <div class="book__img">
    <img src="https://picsum.photos/seed/<?php echo htmlentities($book['isbn']) ?>/333/500.jpg" alt="Book cover">
  </div>
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
        <?php echo htmlentities($book['details']) ?>
      </p>
    </div>
  </div>
  <form method="post" action="./books.php" class="book__reserve">
    <?php formGetKeep(); ?>
    <button <?php if ($book['reserved'] === 'Y') echo 'disabled' ?>
        type="submit" name="reserve"
        value="<?php echo htmlentities($book['isbn']); ?>">
      Reserve Book
    </button>
  </form>
</article>