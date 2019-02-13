
<?php // Yoast breadcrumbs must be enabled; ?>
<?php if (function_exists('yoast_breadcrumb')) : ?>
<div class="breadcrumbs">
  <div class="container">
    <?php yoast_breadcrumb(); ?>
  </div>
</div>
<?php endif; ?>