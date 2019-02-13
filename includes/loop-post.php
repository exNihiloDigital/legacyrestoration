
<?php // Check if post has thumbnail, else grab default post image; ?>
<?php if (has_post_thumbnail()) : ?>
<?php $thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full')[0]; ?>
<?php else : ?>
<?php $thumbnail = esc_url(get_theme_file_uri()) . "/images/post.jpg"; ?>
<?php endif; ?>
<section class="post"><a href="<?php echo get_permalink() ?>" style="background-image: url(<?php echo $thumbnail ?>)" class="post-image"></a>
  <div class="post-content">
    <h2><a href="<?php echo get_permalink() ?>">
        <?php the_title(); ?></a></h2>
    <?php the_excerpt(); ?><a href="<?php echo get_permalink() ?>" class="button">Continue</a>
  </div>
</section>