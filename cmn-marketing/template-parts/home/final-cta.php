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
<section class="cmn-section cmn-home-cta" aria-labelledby="cmn-home-cta-title">
	<div class="cmn-container">
		<div class="cmn-panel cmn-panel--strong cmn-home-cta__panel">
			<div class="cmn-stack cmn-home-cta__content">
				<p class="cmn-eyebrow">Next Step</p>
				<h2 id="cmn-home-cta-title" class="cmn-h2">See how CMN ONE can stabilise emergency staffing in your school network.</h2>
				<div>
					<a class="cmn-btn" href="<?php echo esc_url($primary_cta_url); ?>"><?php echo esc_html($primary_cta_label); ?></a>
				</div>
			</div>
		</div>
	</div>
</section>
