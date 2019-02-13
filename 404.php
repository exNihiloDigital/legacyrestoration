
<?php get_header(); ?>
<div id="error">
  <main>
    <article><img src="<?php echo esc_url(get_theme_file_uri()) ?>/images/404.png"/>
      <p>Looks like this page no longer exists or has been moved.</p><a href="<?php echo home_url() ?>" class="button">Back to Home</a>
    </article>
  </main>
</div>
<?php get_footer(); ?>