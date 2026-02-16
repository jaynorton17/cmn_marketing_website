<?php
if (!defined('ABSPATH')) {
	exit;
}

$default_secondary_cta_label = 'Book a Demo';
$default_secondary_cta_url = home_url('/contact/');
$secondary_cta_label = function_exists('cmn_marketing_get_setting') ? cmn_marketing_get_setting('secondary_cta_label', $default_secondary_cta_label) : $default_secondary_cta_label;
$secondary_cta_url = function_exists('cmn_marketing_get_setting') ? cmn_marketing_get_setting('secondary_cta_url', $default_secondary_cta_url) : $default_secondary_cta_url;

if ($secondary_cta_label === '') {
	$secondary_cta_label = $default_secondary_cta_label;
}

if ($secondary_cta_url === '') {
	$secondary_cta_url = $default_secondary_cta_url;
}
?>
<section class="cmn-section cmn-schools-hero" aria-labelledby="cmn-schools-hero-title">
	<div class="cmn-container cmn-schools-hero__grid">
		<div class="cmn-stack cmn-schools-heading">
			<p class="cmn-eyebrow">Partner Infrastructure</p>
			<h1 id="cmn-schools-hero-title" class="cmn-h1">Your Partner in Reliable Cover.</h1>
			<p class="cmn-lede">[Placeholder copy: replace with structured schools-focused positioning statement highlighting service reliability, safeguarding confidence, and operational continuity.]</p>
			<div class="cmn-inline cmn-schools-hero__actions">
				<a class="cmn-btn" href="<?php echo esc_url(home_url('/contact/')); ?>">Become a Partner School</a>
				<a class="cmn-btn cmn-btn--ghost" href="<?php echo esc_url($secondary_cta_url); ?>"><?php echo esc_html($secondary_cta_label); ?></a>
			</div>
		</div>

		<div class="cmn-panel cmn-panel--strong cmn-schools-hero__visual" aria-label="<?php esc_attr_e('Schools hero visual placeholder', 'cmn-marketing'); ?>">
			<p class="cmn-badge cmn-badge--muted">Placeholder Visual</p>
			<p class="cmn-h3">Future Hero Image Slot</p>
			<p class="cmn-muted">[Replace with schools hero visual asset or infrastructure diagram.]</p>
		</div>
	</div>
</section>
