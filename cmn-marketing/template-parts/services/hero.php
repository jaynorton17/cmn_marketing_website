<?php
if (!defined('ABSPATH')) {
	exit;
}

$default_primary_cta_label = 'Book a Demo';
$default_primary_cta_url = home_url('/contact/');
$default_secondary_cta_label = 'Explore the Platform';
$default_secondary_cta_url = '#cmn-services-modules';

$primary_cta_label = function_exists('cmn_marketing_get_setting') ? cmn_marketing_get_setting('primary_cta_label', $default_primary_cta_label) : $default_primary_cta_label;
$primary_cta_url = function_exists('cmn_marketing_get_setting') ? cmn_marketing_get_setting('primary_cta_url', $default_primary_cta_url) : $default_primary_cta_url;
$secondary_cta_label = function_exists('cmn_marketing_get_setting') ? cmn_marketing_get_setting('secondary_cta_label', $default_secondary_cta_label) : $default_secondary_cta_label;
$secondary_cta_url = function_exists('cmn_marketing_get_setting') ? cmn_marketing_get_setting('secondary_cta_url', $default_secondary_cta_url) : $default_secondary_cta_url;

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
?>
<section class="cmn-section cmn-services-hero" aria-labelledby="cmn-services-hero-title">
	<div class="cmn-container cmn-services-hero__grid">
		<div class="cmn-stack cmn-services-heading">
			<p class="cmn-eyebrow">Platform Infrastructure</p>
			<h1 id="cmn-services-hero-title" class="cmn-h1">Recruitment. Rebuilt for Education.</h1>
			<p class="cmn-lede">[Placeholder copy: replace with platform-level positioning focused on operational infrastructure, visibility, and transparent decision support.]</p>
			<div class="cmn-inline cmn-services-hero__actions">
				<a class="cmn-btn" href="<?php echo esc_url($primary_cta_url); ?>"><?php echo esc_html($primary_cta_label); ?></a>
				<a class="cmn-btn cmn-btn--ghost" href="<?php echo esc_url($secondary_cta_url); ?>"><?php echo esc_html($secondary_cta_label); ?></a>
			</div>
		</div>

		<div class="cmn-panel cmn-panel--strong cmn-services-hero__visual" aria-label="<?php esc_attr_e('Services hero visual placeholder', 'cmn-marketing'); ?>">
			<p class="cmn-badge cmn-badge--muted">Placeholder Visual</p>
			<p class="cmn-h3">Platform Dashboard View</p>
			<p class="cmn-muted">[Replace with future CMN ONE interface screenshot.]</p>
		</div>
	</div>
</section>
