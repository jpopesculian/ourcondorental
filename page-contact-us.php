<?php get_header(); ?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">
            <h1 class="page-title"><?php theme_page_title(); ?></h1>
            <div class="wrap">
                <div class="contact-info">
                    <h3>Contact Information</h3>
                    <ul>
                        <li>Home: <?php create_phone_link(get_option('contact_phone_home')); ?></li>
                        <li>Cell: <?php create_phone_link(get_option('contact_phone_cell')); ?></li>
                        <li>Email: <?php create_email_link(get_option('contact_email')); ?></li>
                        <li class="list-placeholder">&nbsp</li>
                    </ul>
                </div>
                <div class="contact-info">
                    <h3>For Pricing, Discounts & Availability</h3>
                    <ul>
                    <?php for($i = 0; $i < 4; $i++): ?>
                        <li><a href="<?php echo get_option('property_'.$i.'_listing'); ?>">
                                <?php echo get_option('property_'.$i.'_name'); ?>
                            </a></li>
                    <?php endfor ?>
                    </ul>
                </div>
            </div>
            <div class="wrap">
                <form id="contact-form">
                    <div class="form-section">
                        <div class="form-group inline">
                            <label for="">Full Name<span class="req">*</span>:</label>
                            <input type="text" name="name" required="required" placeholder="John Doe"/>
                        </div>
                        <div class="form-group inline">
                            <label for="email">Email<span class="req">*</span>:</label>
                            <input type="text" name="email" required="required" placeholder="john.doe@email.com"/>
                        </div>
                        <div class="form-group inline">
                            <label for="phone">Phone #:</label>
                            <input type="text" name="phone" placeholder="+1 (123) 555-6789"/>
                        </div>
                        <div class="form-group inline">
                            <label for="reason">Inquiry Reason:</label>
                            <select name="reason" id="datepicker-select">
                                <option>General Information</option>
                                <option>Booking Possibility</option>
                            </select>
                        </div>
                        <div class="form-group inline" id="datepicker-container">
                            <label for="dates">Dates:</label>
                            <div class="dates-input" id="datepicker">
                                <input type="text" name="date-from">
                                <span class="input-helper">to</span>
                                <input type="text" name="date-to">
                            </div>
                        </div>
                    </div>
                    <div class="form-section">
                        <div class="form-group for-textarea">
                            <label for="">Message<span class="req">*</span>:</label>
                            <textarea name="message" placeholder=""></textarea>
                        </div>
                        <div class="form-group for-captcha">
                            <label for="captcha">Captcha</label>
                            <input type="text" placeholder="Captcha" name="captcha"/>
                        </div>
                        <div class="form-group">
                            <p class="flash">

                            </p>
                            <a class="small pizazzed button"
                                    onclick="sendForm('contact-form', '<?php echo get_stylesheet_directory_uri();?>/contact_form.php')">
                                Send!
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </main><!-- #main -->
    </div><!-- #primary -->

<?php get_footer(); ?>
