<!DOCTYPE html><html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=10">
  <link type="image/gif" href="<?php echo esc_url(get_theme_file_uri()) ?>/favicon.png" rel="icon" sizes="16x16">
  <?php wp_head(); ?>
</head><body <?php body_class() ?>>
<div class="mobile">
  <div class="topbar"><i class="fa fa-bars"></i><span>Menu</span></div>
  <div class="block">
    <?php if (get_field('search', 'options') == 'show') : ?>
    <?php get_search_form(); ?>
    <?php endif; ?>
    <?php mobile_menu(); ?>
  </div>
</div>
<div class="masthead">
  <div class="container"><a href="tel:>">111-222-3333</a></div>
</div>
<header>
  <div class="container">
    <div class="logo"><a href="<?php echo esc_url(home_url('/')) ?>"><img src="<?php echo esc_url(get_theme_file_uri()) ?>/images/logo.png" alt="<?php bloginfo('name') ?> Logo"></a></div>
    <div class="menu">
      <nav>
        <?php header_menu(); ?>
      </nav>
    </div>
  </div>
</header>
<?php if (! (is_front_page() || is_404())) : ?>
<?php include('includes/featured.php'); ?>
<?php include('includes/breadcrumbs.php'); ?>
<?php endif; ?>
