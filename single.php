
<?php get_header(); ?>
<div id="single">
  <main>
    <article>
      <?php if (have_posts()) : ?>
      <?php while (have_posts()) : the_post(); ?>
      <?php the_content(); ?>
      <?php endwhile; ?>
      <?php wp_reset_postdata(); ?>
      <?php else : ?>
      <?php include('includes/loop_missing.php'); ?>
      <?php endif; ?>
    </article>
    <aside>
      <?php get_sidebar(); ?>
    </aside>
  </main>
</div>
<?php get_footer(); ?>