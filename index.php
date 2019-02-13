
<?php get_header(); ?>
<div id="index">
  <main>
    <article>
      <?php if (have_posts()) : ?>
      <?php while (have_posts()) : the_post(); ?>
      <?php include('includes/loop-post.php'); ?>
      <?php endwhile; ?>
      <?php pagination(); ?>
      <?php wp_reset_postdata(); ?>
      <?php endif; ?>
    </article>
    <aside>
      <?php get_sidebar(); ?>
    </aside>
  </main>
</div>
<?php get_footer(); ?>