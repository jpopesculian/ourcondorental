<div class="wrap">
	<h2>Theme Options</h2>
	<form method="post" action="options.php" enctype="multipart/form-data">
		<?php settings_fields( 'theme_options_group' ); ?>
		<?php do_settings_sections( 'theme_options_group' ); ?>
		<div class="form-group">
			<h3>Home Page</h3>
			<div class="form-group">
				<label for="home_hook">Hook</label>
				<input 
					name="home_hook"
					type="text"
					value="<?php echo get_option('home_hook'); ?>"
				/>
			</div>
			<div class="form-group">
				<label for="home_subhook">Sub-Hook</label>
				<input 
					name="home_subhook"
					type="text"
					value="<?php echo get_option('home_subhook'); ?>"
				/>
			</div>
		</div>
        <div class="form-group">
            <h3>Contact Information</h3>
            <div class="form-group">
                <label for="contact_phone_home">Home Phone</label>
                <input
                    name="contact_phone_home"
                    type="text"
                    value="<?php echo get_option('contact_phone_home'); ?>"
                    />
            </div>
            <div class="form-group">
                <label for="contact_phone_cell">Cell Phone</label>
                <input
                    name="contact_phone_cell"
                    type="text"
                    value="<?php echo get_option('contact_phone_cell'); ?>"
                    />
            </div>
            <div class="form-group">
                <label for="contact_email">Email</label>
                <input
                    name="contact_email"
                    type="text"
                    value="<?php echo get_option('contact_email'); ?>"
                    />
            </div>
        </div>
		<div class="form-group">
			<h3>Property Cards</h3>
			<?php for ($i=0; $i < 4; $i++): ?>
			<h4>Property <?php echo $i + 1; ?></h4>
			<div class="form-group">
				<label for="property_<?php echo $i; ?>_name">Name</label>
				<input 
					type="text"
					name="property_<?php echo $i; ?>_name"
					value="<?php echo get_option('property_'.$i.'_name'); ?>"
				/>
			</div>
			<div class="form-group">
				<label for="property_<?php echo $i; ?>_loc">Location</label>
				<input 
					type="text"
					name="property_<?php echo $i; ?>_loc"
					value="<?php echo get_option('property_'.$i.'_loc'); ?>"
				/>
			</div>
			<div class="form-group">
				<label for="property_<?php echo $i; ?>_descr">Description</label>
				<textarea name="property_<?php echo $i; ?>_descr"><?php echo get_option('property_'.$i.'_descr'); ?></textarea>
			</div>
			<div class="form-group">
				<label for="property_<?php echo $i; ?>_page">Category ID#</label>
				<input 
					type="number"
					name="property_<?php echo $i; ?>_page"
					value="<?php echo get_option('property_'.$i.'_page'); ?>"
				/>
			</div>
            <div class="form-group">
                <label for="property_<?php echo $i; ?>_listing">Listing Site</label>
                <input
                    type="text"
                    name="property_<?php echo $i; ?>_listing"
                    value="<?php echo get_option('property_'.$i.'_listing'); ?>"
                    />
            </div>
			<?php endfor; ?>
		</div>
		<?php submit_button(); ?>
	</form>
</div>
