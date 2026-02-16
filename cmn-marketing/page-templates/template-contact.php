<?php
/**
 * Template Name: CMN Contact
 * Template Post Type: page
 */

if (!defined('ABSPATH')) {
	exit;
}

$contact_status = '';
if (isset($_GET['cmn_contact_status'])) {
	$contact_status = sanitize_key(wp_unslash($_GET['cmn_contact_status']));
}

$status_messages = array(
	'success'       => array(
		'type' => 'success',
		'text' => __('Thank you. Your message has been received and our team will respond shortly.', 'cmn-marketing'),
	),
	'required'      => array(
		'type' => 'error',
		'text' => __('Please complete all required fields before submitting.', 'cmn-marketing'),
	),
	'invalid_email' => array(
		'type' => 'error',
		'text' => __('Please provide a valid email address.', 'cmn-marketing'),
	),
	'invalid_nonce' => array(
		'type' => 'error',
		'text' => __('Your session could not be verified. Please refresh and try again.', 'cmn-marketing'),
	),
	'spam'          => array(
		'type' => 'error',
		'text' => __('Submission blocked. Please try again.', 'cmn-marketing'),
	),
	'db_error'      => array(
		'type' => 'error',
		'text' => __('We could not process your message right now. Please try again shortly.', 'cmn-marketing'),
	),
	'mail_error'    => array(
		'type' => 'error',
		'text' => __('Your message was saved, but email delivery failed. Our team will still review your submission.', 'cmn-marketing'),
	),
	'post_error'    => array(
		'type' => 'error',
		'text' => __('Invalid request method. Please resubmit the form.', 'cmn-marketing'),
	),
);

$has_status = isset($status_messages[$contact_status]);
$default_support_email = 'support@covermenow.co.uk';
$default_support_phone = '+44 0000 000000';
$default_office_hours = 'Mon-Fri, 08:00-18:00';

$support_email = function_exists('cmn_marketing_get_setting') ? cmn_marketing_get_setting('support_email', $default_support_email) : $default_support_email;
$support_phone = function_exists('cmn_marketing_get_setting') ? cmn_marketing_get_setting('support_phone', $default_support_phone) : $default_support_phone;
$office_hours = function_exists('cmn_marketing_get_setting') ? cmn_marketing_get_setting('office_hours', $default_office_hours) : $default_office_hours;
$address = function_exists('cmn_marketing_get_setting') ? cmn_marketing_get_setting('address', '') : '';

if (!is_email($support_email)) {
	$support_email = $default_support_email;
}

if ($support_phone === '') {
	$support_phone = $default_support_phone;
}

if ($office_hours === '') {
	$office_hours = $default_office_hours;
}

$phone_href = preg_replace('/[^0-9+]/', '', $support_phone);
if (!is_string($phone_href) || $phone_href === '') {
	$phone_href = $support_phone;
}

get_header();
?>
<main id="cmn-main" class="cmn-contact" aria-label="<?php esc_attr_e('Contact page content', 'cmn-marketing'); ?>">
	<section class="cmn-section cmn-contact-hero" aria-labelledby="cmn-contact-hero-title">
		<div class="cmn-container">
			<div class="cmn-panel cmn-panel--strong cmn-contact-hero__panel">
				<p class="cmn-eyebrow">Contact CoverMeNow ONE</p>
				<h1 id="cmn-contact-hero-title" class="cmn-h1">Get in Touch.</h1>
				<p class="cmn-lede">[Placeholder copy: replace with a concise contact-positioning statement for schools and candidates seeking structured support.]</p>
			</div>
		</div>
	</section>

	<section class="cmn-section cmn-contact-main" aria-labelledby="cmn-contact-form-title">
		<div class="cmn-container cmn-contact-main__grid">
			<div class="cmn-contact-form-wrap">
				<?php if ($has_status) : ?>
					<?php $notice = $status_messages[$contact_status]; ?>
					<div class="cmn-panel cmn-contact-notice cmn-contact-notice--<?php echo esc_attr($notice['type']); ?>" role="status" aria-live="polite">
						<p><?php echo esc_html($notice['text']); ?></p>
					</div>
				<?php endif; ?>

				<div class="cmn-panel cmn-contact-form-panel">
					<h2 id="cmn-contact-form-title" class="cmn-h2">Send a Message</h2>
					<form id="cmn-contact-form" class="cmn-stack" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" novalidate>
						<input type="hidden" name="action" value="cmn_contact_submit">
						<input type="hidden" name="redirect_to" value="<?php echo esc_url(get_permalink()); ?>">
						<?php wp_nonce_field('cmn_contact_submit', 'cmn_contact_nonce'); ?>

						<div class="cmn-field">
							<label for="cmn-name"><?php esc_html_e('Name', 'cmn-marketing'); ?> *</label>
							<input id="cmn-name" name="cmn_name" type="text" autocomplete="name" required>
						</div>

						<div class="cmn-field">
							<label for="cmn-email"><?php esc_html_e('Email', 'cmn-marketing'); ?> *</label>
							<input id="cmn-email" name="cmn_email" type="email" autocomplete="email" required>
						</div>

						<div class="cmn-field">
							<label for="cmn-role"><?php esc_html_e('Role', 'cmn-marketing'); ?></label>
							<select id="cmn-role" name="cmn_role">
								<option value="School"><?php esc_html_e('School', 'cmn-marketing'); ?></option>
								<option value="Candidate"><?php esc_html_e('Candidate', 'cmn-marketing'); ?></option>
								<option value="Other"><?php esc_html_e('Other', 'cmn-marketing'); ?></option>
							</select>
						</div>

						<div class="cmn-field">
							<label for="cmn-subject"><?php esc_html_e('Subject', 'cmn-marketing'); ?></label>
							<input id="cmn-subject" name="cmn_subject" type="text" autocomplete="off">
						</div>

						<div class="cmn-field">
							<label for="cmn-message"><?php esc_html_e('Message', 'cmn-marketing'); ?> *</label>
							<textarea id="cmn-message" name="cmn_message" required></textarea>
						</div>

						<div class="cmn-contact-hp" aria-hidden="true">
							<label for="cmn-website"><?php esc_html_e('Website', 'cmn-marketing'); ?></label>
							<input id="cmn-website" name="cmn_website" type="text" tabindex="-1" autocomplete="off">
						</div>

						<div>
							<button class="cmn-btn" type="submit"><?php esc_html_e('Send Message', 'cmn-marketing'); ?></button>
						</div>
					</form>
				</div>
			</div>

			<aside class="cmn-contact-info" aria-labelledby="cmn-contact-info-title">
				<div class="cmn-panel cmn-panel--strong cmn-contact-info__panel">
					<h2 id="cmn-contact-info-title" class="cmn-h2">Contact Details</h2>
					<p class="cmn-muted">[Placeholder copy: replace with contact channel guidance and response expectations.]</p>
					<ul class="cmn-contact-info__list">
						<li>
							<strong><?php esc_html_e('Email:', 'cmn-marketing'); ?></strong>
							<a href="mailto:<?php echo esc_attr(antispambot($support_email)); ?>"><?php echo esc_html(antispambot($support_email)); ?></a>
						</li>
						<li>
							<strong><?php esc_html_e('Phone:', 'cmn-marketing'); ?></strong>
							<a href="tel:<?php echo esc_attr($phone_href); ?>"><?php echo esc_html($support_phone); ?></a>
						</li>
						<li>
							<strong><?php esc_html_e('Hours:', 'cmn-marketing'); ?></strong>
							<span><?php echo esc_html($office_hours); ?></span>
						</li>
						<?php if ($address !== '') : ?>
							<li>
								<strong><?php esc_html_e('Address:', 'cmn-marketing'); ?></strong>
								<span><?php echo nl2br(esc_html($address)); ?></span>
							</li>
						<?php endif; ?>
					</ul>
				</div>
			</aside>
		</div>
	</section>

	<?php get_template_part('template-parts/contact/faq'); ?>
</main>
<?php get_footer(); ?>
