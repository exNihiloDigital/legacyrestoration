
<?php // featured('title'), featured('image'), featured('alt'); ?>
<div style="background-image: url(<?php featured('image') ?>)" class="featured overlay <?php featured('alt') ?>">
  <main>
    <div>
      <h1>
        <?php featured('title') ; ?>
      </h1>
    </div>
  </main>
</div>