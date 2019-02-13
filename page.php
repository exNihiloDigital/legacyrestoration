
<?php get_header(); ?>
<div id="page">
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
      <h1>Heading 1</h1>
      <h2>Heading 2</h2>
      <h3>Heading 3</h3>
      <h4>Heading 4</h4>
      <h5>Heading 5</h5>
      <h6>Heading 6</h6>
      <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ullam reiciendis asperiores quam obcaecati laborum officiis sit cum recusandae, labore corrupti necessitatibus voluptate nemo? Illo eaque animi ipsam error illum a incidunt aliquid vero accusantium impedit, excepturi sapiente voluptatum unde perferendis laudantium quaerat distinctio pariatur laborum ullam rem temporibus? Aliquid, amet.</p>
      <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ullam reiciendis asperiores quam obcaecati laborum officiis sit cum recusandae, labore corrupti necessitatibus voluptate nemo? Illo eaque animi ipsam error illum a incidunt aliquid vero accusantium impedit, excepturi sapiente voluptatum unde perferendis laudantium quaerat distinctio pariatur laborum ullam rem temporibus? Aliquid, amet.</p><a href="">Link Here</a><br/><a href="" class="button">Button Link</a>
      <ul>
        <li>List 1</li>
        <li>List 2</li>
        <li>List 3</li>
        <li>List 4</li>
      </ul>
      <ol>
        <li>Order List 1</li>
        <li>Ordered List 2</li>
        <li>Ordered List 3</li>
        <li>Ordered List 4</li>
      </ol><img src="<?php echo esc_url(get_theme_file_uri()) ?>/images/logo.png" alt="<?php bloginfo('name') ?> Logo"/>
      <blockquote>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Blanditiis assumenda ut vero fugit saepe, quasi quas illum quisquam, modi velit, facilis accusantium vel doloremque consequatur.</blockquote>
    </article>
    <aside>
      <?php get_sidebar(); ?>
    </aside>
  </main>
</div>
<?php get_footer(); ?>