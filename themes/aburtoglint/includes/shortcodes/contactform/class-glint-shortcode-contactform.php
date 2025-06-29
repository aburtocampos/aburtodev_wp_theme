<?php
// Exit if accessed directly
if (!defined('ABSPATH')) exit;

/**
 * Shortcode: [glint_contact_form]
 */
 
 /*
class Glint_Shortcode_ContactForm {

    public function register(): void {
        add_shortcode('glint_contact_form', [$this, 'render']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);
    }

    public function enqueue_assets(): void {
        wp_enqueue_style('glint-contactform-style', GLINT_DIR_URI . 'public/css/contactform.css', [], '1.0');
    }

    public function render($atts): string {
        $success = false;
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['glint_cf_nonce']) && wp_verify_nonce($_POST['glint_cf_nonce'], 'glint_contact_form')) {
            $name    = sanitize_text_field($_POST['glint_name'] ?? '');
            $email   = sanitize_email($_POST['glint_email'] ?? '');
            $phone   = sanitize_text_field($_POST['glint_phone'] ?? '');
            $website = esc_url_raw($_POST['glint_website'] ?? '');
            $message = sanitize_textarea_field($_POST['glint_message'] ?? '');

            if (empty($name))    $errors['name'] = 'Full name is required.';
            if (empty($email) || !is_email($email)) $errors['email'] = 'Valid email required.';
            if (empty($phone))   $errors['phone'] = 'Telephone is required.';
            if (empty($message)) $errors['message'] = 'Message is required.';

            if (empty($errors)) {
			$admin_email = get_option('admin_email');
			$additional_emails = array(
				'info@aburto.dev'
			);
                  $to = array_merge(array($admin_email), $additional_emails);
                $subject = 'New Contact Message';
                $headers = ['Content-Type: text/html; charset=UTF-8'];
                $body = "<strong>Name:</strong> $name<br><strong>Email:</strong> $email<br><strong>Phone:</strong> $phone<br><strong>Website:</strong> $website<br><strong>Message:</strong><br>$message";

                $success = wp_mail($to, $subject, $body, $headers);
            }
        }

        ob_start();

        if ($success) {
            echo '<div class="glint-contact-success">Thank you! Your message has been sent.</div>';
        }

        ?>
        <form class="glint-contact-form" method="post">
            <?php wp_nonce_field('glint_contact_form', 'glint_cf_nonce'); ?>

            <div class="form-row">
                <div class="form-group">
                    <label for="glint_name">Full Name *</label>
                    <input type="text" name="glint_name" id="glint_name" value="<?php echo esc_attr($_POST['glint_name'] ?? ''); ?>" required>
                    <?php if (!empty($errors['name'])) echo '<span class="error">' . esc_html($errors['name']) . '</span>'; ?>
                </div>

                <div class="form-group">
                    <label for="glint_email">Email Address *</label>
                    <input type="email" name="glint_email" id="glint_email" value="<?php echo esc_attr($_POST['glint_email'] ?? ''); ?>" required>
                    <?php if (!empty($errors['email'])) echo '<span class="error">' . esc_html($errors['email']) . '</span>'; ?>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="glint_phone">Telephone *</label>
                    <input type="text" name="glint_phone" id="glint_phone" value="<?php echo esc_attr($_POST['glint_phone'] ?? ''); ?>" required>
                    <?php if (!empty($errors['phone'])) echo '<span class="error">' . esc_html($errors['phone']) . '</span>'; ?>
                </div>

                <div class="form-group">
                    <label for="glint_website">Website</label>
                    <input type="url" name="glint_website" id="glint_website" value="<?php echo esc_attr($_POST['glint_website'] ?? ''); ?>">
                </div>
            </div>

            <div class="form-group full">
                <label for="glint_message">Message *</label>
                <textarea name="glint_message" id="glint_message" rows="5" required><?php echo esc_textarea($_POST['glint_message'] ?? ''); ?></textarea>
                <?php if (!empty($errors['message'])) echo '<span class="error">' . esc_html($errors['message']) . '</span>'; ?>
            </div>

            <div class="form-group full btn">
                <button type="submit" class="glint-submit-button">Send Message</button>
            </div>
        </form>
        <?php

        return ob_get_clean();
    }
}
*/


/**
 * Shortcode: [glint_contact_form]
 */
class Glint_Shortcode_ContactForm {

    public function register(): void {
        add_shortcode('glint_contact_form', [$this, 'render']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);
    }

    public function enqueue_assets(): void {
        wp_enqueue_style('glint-contactform-style', GLINT_DIR_URI . 'public/css/contactform.css', [], '1.0');
    }

    public function render($atts): string {
        $success = false;
        $errors = [];

        // Store render time for spam protection
        $form_render_time = time();

        // Process form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['glint_cf_nonce']) && wp_verify_nonce($_POST['glint_cf_nonce'], 'glint_contact_form')) {

            // Honeypot check
            if (!empty($_POST['glint_hp'])) {
                return '<div class="glint-contact-error">Spam detected. Submission blocked.</div>';
            }

            // Check for minimum time (5 seconds)
            if (!empty($_POST['glint_timer']) && (time() - intval($_POST['glint_timer']) < 5)) {
                return '<div class="glint-contact-error">Form submitted too quickly. Please try again.</div>';
            }

            // Sanitize and validate input
            $name    = sanitize_text_field($_POST['glint_name'] ?? '');
            $email   = sanitize_email($_POST['glint_email'] ?? '');
            $phone   = sanitize_text_field($_POST['glint_phone'] ?? '');
            $website = esc_url_raw($_POST['glint_website'] ?? '');
            $message = sanitize_textarea_field($_POST['glint_message'] ?? '');

            if (empty($name))    $errors['name'] = 'Full name is required.';
            if (empty($email) || !is_email($email)) $errors['email'] = 'Valid email required.';
            if (empty($phone))   $errors['phone'] = 'Telephone is required.';
            if (empty($message)) $errors['message'] = 'Message is required.';

            // Send email if no errors
            if (empty($errors)) {
                $to = get_option('admin_email');
                $subject = 'New Contact Message';
                $headers = ['Content-Type: text/html; charset=UTF-8'];
                $body = "<strong>Name:</strong> $name<br><strong>Email:</strong> $email<br><strong>Phone:</strong> $phone<br><strong>Website:</strong> $website<br><strong>Message:</strong><br>$message";

                $success = wp_mail($to, $subject, $body, $headers);
                
                 // Reset form after successful submission
                if ($success) {
                    $_POST = []; // Clear POST data
                }
            }
        }

        ob_start();

        if ($success) {
            echo '<div class="glint-contact-success">Thank you! Your message has been sent.</div>';
        }

        ?>
        <form class="glint-contact-form" method="post">
            <?php wp_nonce_field('glint_contact_form', 'glint_cf_nonce'); ?>

            <!-- Honeypot field (hidden to users) -->
            <div style="display:none;">
                <label for="glint_hp">Leave this field empty</label>
                <input type="text" name="glint_hp" id="glint_hp" autocomplete="off">
            </div>

            <!-- Timer field -->
            <input type="hidden" name="glint_timer" value="<?php echo esc_attr($form_render_time); ?>">

            <div class="form-row">
                <div class="form-group">
                    <label for="glint_name">Full Name *</label>
                    <input type="text" name="glint_name" id="glint_name" value="<?php echo esc_attr($_POST['glint_name'] ?? ''); ?>" required>
                    <?php if (!empty($errors['name'])) echo '<span class="error">' . esc_html($errors['name']) . '</span>'; ?>
                </div>

                <div class="form-group">
                    <label for="glint_email">Email Address *</label>
                    <input type="email" name="glint_email" id="glint_email" value="<?php echo esc_attr($_POST['glint_email'] ?? ''); ?>" required>
                    <?php if (!empty($errors['email'])) echo '<span class="error">' . esc_html($errors['email']) . '</span>'; ?>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="glint_phone">Telephone *</label>
                    <input type="text" name="glint_phone" id="glint_phone" value="<?php echo esc_attr($_POST['glint_phone'] ?? ''); ?>" required>
                    <?php if (!empty($errors['phone'])) echo '<span class="error">' . esc_html($errors['phone']) . '</span>'; ?>
                </div>

                <div class="form-group">
                    <label for="glint_website">Website</label>
                    <input type="url" name="glint_website" id="glint_website" value="<?php echo esc_attr($_POST['glint_website'] ?? ''); ?>">
                </div>
            </div>

            <div class="form-group full">
                <label for="glint_message">Message *</label>
                <textarea name="glint_message" id="glint_message" rows="5" required><?php echo esc_textarea($_POST['glint_message'] ?? ''); ?></textarea>
                <?php if (!empty($errors['message'])) echo '<span class="error">' . esc_html($errors['message']) . '</span>'; ?>
            </div>

            <div class="form-group full btn">
                <button type="submit" class="glint-submit-button">Send Message</button>
            </div>
        </form>
        <?php

        return ob_get_clean();
    }
}
