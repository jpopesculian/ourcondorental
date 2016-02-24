<div class="post-block">
    <?php if (category_description()): ?>
        <div class="post-section"><?php echo category_description(); ?></div>
    <?php endif; ?>
    <?php
        $query = new WP_Query('cat='.$cat_ID);
        if ($query->have_posts()): while ($query->have_posts()): $query->the_post();
    ?>
        <div class="post-section" id="<?php category_section_id(); ?>">
            <h2><?php echo $post->post_title ?></h2>
            <div class="post-content readable-text">
                <?php echo custom_shortcode($post->post_content); ?>
            </div>
        </div>
    <?php endwhile; endif; ?>
</div>