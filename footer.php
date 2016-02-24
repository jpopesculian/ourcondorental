	</div><!-- #content -->

	<footer id="site-footer" role="contentinfo">
        <div class="footer-contents">
            <div class="footer-section">
                <h3>Contact Information</h3>
                <div class="contact-info-container">
                    <ul>
                        <li class="contact-info-item">
                            Home: <?php create_phone_link(get_option('contact_phone_home')); ?>
                        </li>
                        <li class="contact-info-item">
                            Cell: <?php create_phone_link(get_option('contact_phone_cell')); ?>
                        </li>
                        <li class="contact-info-item">
                            Email: <?php create_email_link(get_option('contact_email')); ?>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="footer-section">
                <h3>Properties</h3>
                <div class="properties-menu-container">
                    <ul>
                        <?php for ($i=0; $i < 3; $i++): ?>
                        <li class="properties-menu-item">
                            <a href="<?php echo get_category_link(get_option('property_'.$i.'_page')); ?>">
                                <?php echo get_option('property_'.$i.'_name'); ?>
                            </a>
                        </li>
                        <?php endfor ?>
                    </ul>
                </div>
            </div>
            <div class="footer-section">
                <h3>Pages</h3>
                <?php wp_nav_menu( array(
                    'theme_location' => 'primary',
                    'menu' => 'Main Menu',
                    'depth' => 1
                ) ); ?>
            </div>
        </div>
	</footer><!-- #site-footer -->
</div><!-- #page -->

<!-- SCRIPTS -->
<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri();?>/js/Pickaday.js"></script>
<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri();?>/js/scripts.js"></script>
<!-- END SCRIPTS -->

</body>
</html>