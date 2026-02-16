<?php
if (!defined('ABSPATH')) {
	exit;
}

$default_support_email = 'support@covermenow.co.uk';
$default_support_phone = '+44 0000 000000';
$default_office_hours = 'Mon-Fri, 08:00-18:00';
$default_primary_cta_label = 'Book a Demo';
$default_primary_cta_url = home_url('/contact/');
$default_secondary_cta_label = 'Learn More';
$default_secondary_cta_url = home_url('/services/');
$default_brand_tagline = 'Premium safeguarding infrastructure for schools and candidates.';

$support_email = function_exists('cmn_marketing_get_setting') ? cmn_marketing_get_setting('support_email', $default_support_email) : $default_support_email;
$support_phone = function_exists('cmn_marketing_get_setting') ? cmn_marketing_get_setting('support_phone', $default_support_phone) : $default_support_phone;
$office_hours = function_exists('cmn_marketing_get_setting') ? cmn_marketing_get_setting('office_hours', $default_office_hours) : $default_office_hours;
$address = function_exists('cmn_marketing_get_setting') ? cmn_marketing_get_setting('address', '') : '';
$primary_cta_label = function_exists('cmn_marketing_get_setting') ? cmn_marketing_get_setting('primary_cta_label', $default_primary_cta_label) : $default_primary_cta_label;
$primary_cta_url = function_exists('cmn_marketing_get_setting') ? cmn_marketing_get_setting('primary_cta_url', $default_primary_cta_url) : $default_primary_cta_url;
$secondary_cta_label = function_exists('cmn_marketing_get_setting') ? cmn_marketing_get_setting('secondary_cta_label', $default_secondary_cta_label) : $default_secondary_cta_label;
$secondary_cta_url = function_exists('cmn_marketing_get_setting') ? cmn_marketing_get_setting('secondary_cta_url', $default_secondary_cta_url) : $default_secondary_cta_url;
$brand_tagline = function_exists('cmn_marketing_get_setting') ? cmn_marketing_get_setting('brand_tagline', $default_brand_tagline) : $default_brand_tagline;

if (!is_email($support_email)) {
	$support_email = $default_support_email;
}

if ($support_phone === '') {
	$support_phone = $default_support_phone;
}

if ($office_hours === '') {
	$office_hours = $default_office_hours;
}

if ($primary_cta_label === '') {
	$primary_cta_label = $default_primary_cta_label;
}

if ($primary_cta_url === '') {
	$primary_cta_url = $default_primary_cta_url;
}

if ($secondary_cta_label === '') {
	$secondary_cta_label = $default_secondary_cta_label;
}

if ($secondary_cta_url === '') {
	$secondary_cta_url = $default_secondary_cta_url;
}

if ($brand_tagline === '') {
	$brand_tagline = $default_brand_tagline;
}

$social_links = array(
	'LinkedIn'  => function_exists('cmn_marketing_get_setting') ? cmn_marketing_get_setting('social_linkedin', '') : '',
	'X'         => function_exists('cmn_marketing_get_setting') ? cmn_marketing_get_setting('social_x', '') : '',
	'Facebook'  => function_exists('cmn_marketing_get_setting') ? cmn_marketing_get_setting('social_facebook', '') : '',
	'Instagram' => function_exists('cmn_marketing_get_setting') ? cmn_marketing_get_setting('social_instagram', '') : '',
);

$phone_href = preg_replace('/[^0-9+]/', '', $support_phone);
if (!is_string($phone_href) || $phone_href === '') {
	$phone_href = $support_phone;
}
?>
<footer class="cmn-site-footer cmn-section" aria-labelledby="cmn-footer-title">
	<div class="cmn-container">
		<div class="cmn-panel cmn-panel--strong cmn-site-footer__panel">
			<h2 id="cmn-footer-title" class="screen-reader-text"><?php esc_html_e('Site footer', 'cmn-marketing'); ?></h2>
			<div class="cmn-site-footer__grid">
				<section aria-labelledby="cmn-footer-brand-title">
					<h3 id="cmn-footer-brand-title" class="cmn-site-footer__title">CoverMeNow ONE</h3>
					<p class="cmn-site-footer__text"><?php echo esc_html($brand_tagline); ?></p>
				</section>

				<nav aria-labelledby="cmn-footer-links-title">
					<h3 id="cmn-footer-links-title" class="cmn-site-footer__title">Quick Links</h3>
					<ul class="cmn-site-footer__list">
						<li><a href="<?php echo esc_url($primary_cta_url); ?>"><?php echo esc_html($primary_cta_label); ?></a></li>
						<li><a href="<?php echo esc_url($secondary_cta_url); ?>"><?php echo esc_html($secondary_cta_label); ?></a></li>
						<li><a href="<?php echo esc_url(home_url('/contact/')); ?>"><?php esc_html_e('Contact', 'cmn-marketing'); ?></a></li>
					</ul>
				</nav>

				<nav aria-labelledby="cmn-footer-social-title">
					<h3 id="cmn-footer-social-title" class="cmn-site-footer__title">Connect</h3>
					<?php $has_social_links = false; ?>
					<ul class="cmn-site-footer__list">
						<?php foreach ($social_links as $social_label => $social_url) : ?>
							<?php if ($social_url !== '') : ?>
								<?php $has_social_links = true; ?>
								<li><a href="<?php echo esc_url($social_url); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html($social_label); ?></a></li>
							<?php endif; ?>
						<?php endforeach; ?>
					</ul>
					<?php if (!$has_social_links) : ?>
						<p class="cmn-site-footer__text"><?php esc_html_e('Set social links in CMN Marketing Settings.', 'cmn-marketing'); ?></p>
					<?php endif; ?>
				</nav>

				<section aria-labelledby="cmn-footer-contact-title">
					<h3 id="cmn-footer-contact-title" class="cmn-site-footer__title">Contact</h3>
					<address class="cmn-site-footer__contact">
						<p><a href="mailto:<?php echo esc_attr(antispambot($support_email)); ?>"><?php echo esc_html(antispambot($support_email)); ?></a></p>
						<p><a href="tel:<?php echo esc_attr($phone_href); ?>"><?php echo esc_html($support_phone); ?></a></p>
						<p><?php echo esc_html($office_hours); ?></p>
						<?php if ($address !== '') : ?>
							<p><?php echo nl2br(esc_html($address)); ?></p>
						<?php endif; ?>
					</address>
				</section>
			</div>

			<div class="cmn-site-footer__bottom">
				<p>&copy; <?php echo esc_html(wp_date('Y')); ?> CoverMeNow ONE</p>
			</div>
		</div>
	</div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
