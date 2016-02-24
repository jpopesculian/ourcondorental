<div class="property-cards">
	<div class="row">
		<?php for ($i=0; $i < 4; $i++): ?>
		<a href="<?php echo get_category_link(get_option('property_'.$i.'_page')); ?>" class="property-card">
			<div class="title">
				<h3><?php echo get_option('property_'.$i.'_name'); ?></h3>
				<h4><?php echo get_option('property_'.$i.'_loc'); ?></h4>
			</div>
			<div class="thumbnail"></div>
			<p class="description"><?php echo get_option('property_'.$i.'_descr'); ?></p>
			<div class="pizazzed button">View Property</div>
		</a>
		<?php if ($i < 3) { ?><div class="spacer"></div><?php } ?>
		<?php endfor ?>
</div>
