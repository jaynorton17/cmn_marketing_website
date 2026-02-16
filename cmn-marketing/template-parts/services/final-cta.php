<?php
if (!defined('ABSPATH')) {
	exit;
}

$default_primary_cta_label = 'Book a Demo';
$default_primary_cta_url = home_url('/contact/');
$primary_cta_label = function_exists('cmn_marketing_get_setting') ? cmn_marketing_get_setting('primary_cta_label', $default_primary_cta_label) : $default_primary_cta_label;
$primary_cta_url = function_exists('cmn_marketing_get_setting') ? cmn_marketing_get_setting('primary_cta_url', $default_primary_cta_url) : $default_primary_cta_url;

if ($primary_cta_label === '') {
	$primary_cta_label = $default_primary_cta_label;
}

if ($primary_cta_url === '') {
	$primary_cta_url = $default_primary_cta_url;
}
?>
<section class="cmn-section cmn-services-cta" aria-labelledby="cmn-services-cta-title">
	<div class="cmn-container">
		<div class="cmn-panel cmn-panel--strong cmn-services-cta__panel">
			<div class="cmn-stack cmn-services-cta__content">
				<p class="cmn-eyebrow">See the Platform</p>
				<h2 id="cmn-services-cta-title" class="cmn-h2">[Placeholder headline: replace with final conversion message focused on infrastructure outcomes.]</h2>
				<div>
					<a class="cmn-btn" href="<?php echo esc_url($primary_cta_url); ?>"><?php echo esc_html($primary_cta_label); ?></a>
				</div>
			</div>
		</div>
	</div>
</section>
