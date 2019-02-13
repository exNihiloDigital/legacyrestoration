
<?php // featured('title'), featured('image'), featured('alt'); ?>
<div style="background-image: url(<?php featured('image') ?>)" class="featured <?php featured('alt') ?>">
  <div class="container">
    <h1>
      <?php featured('title'); ?>
    </h1>
  </div>
</div>