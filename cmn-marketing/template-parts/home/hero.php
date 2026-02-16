<?php
if (!defined('ABSPATH')) {
	exit;
}

$hero_image_relative = 'img/hero-laptop.png';
$hero_image_file = trailingslashit(get_stylesheet_directory()) . 'assets/' . $hero_image_relative;
$hero_image_url = cmn_marketing_asset_url($hero_image_relative);
$has_hero_image = is_readable($hero_image_file);
$hero_image_data = $has_hero_image && function_exists('cmn_marketing_get_responsive_image_data') ? cmn_marketing_get_responsive_image_data($hero_image_relative) : array();
$hero_image_src = isset($hero_image_data['src']) ? (string) $hero_image_data['src'] : $hero_image_url;
$hero_image_srcset = isset($hero_image_data['srcset']) ? (string) $hero_image_data['srcset'] : '';
$hero_image_webp_srcset = isset($hero_image_data['webp_srcset']) ? (string) $hero_image_data['webp_srcset'] : '';
$hero_image_width = isset($hero_image_data['width']) ? (int) $hero_image_data['width'] : 0;
$hero_image_height = isset($hero_image_data['height']) ? (int) $hero_image_data['height'] : 0;
$brand_tagline = function_exists('cmn_marketing_get_setting') ? cmn_marketing_get_setting('brand_tagline', '') : '';
?>
<section class="cmn-section cmn-home-hero" aria-labelledby="cmn-home-hero-title">
	<div class="cmn-container cmn-home-hero__grid">
		<div class="cmn-stack cmn-home-hero__content">
			<p class="cmn-eyebrow">Premium Calm Infrastructure</p>
			<h1 id="cmn-home-hero-title" class="cmn-h1">Reliable emergency cover for schools, powered by CoverMeNow ONE.</h1>
			<p class="cmn-lede">Book trusted professionals fast, keep safeguarding records clear, and maintain service continuity with a single calm workflow.</p>
			<?php if ($brand_tagline !== '') : ?>
				<p class="cmn-muted"><?php echo esc_html($brand_tagline); ?></p>
			<?php endif; ?>
			<div class="cmn-inline cmn-home-hero__actions">
				<a class="cmn-btn" href="<?php echo esc_url(home_url('/contact/')); ?>">Book Emergency Cover</a>
				<a class="cmn-btn cmn-btn--ghost" href="<?php echo esc_url(home_url('/candidates/')); ?>">Join as a Candidate</a>
			</div>
		</div>

		<div class="cmn-home-hero__visual" aria-label="<?php esc_attr_e('Platform preview', 'cmn-marketing'); ?>">
			<?php if ($has_hero_image) : ?>
				<div class="cmn-panel cmn-home-hero__media-wrap">
					<picture>
						<?php if ($hero_image_webp_srcset !== '') : ?>
							<source srcset="<?php echo esc_attr($hero_image_webp_srcset); ?>" sizes="(max-width: 900px) 100vw, 50vw" type="image/webp">
						<?php endif; ?>
						<img
							class="cmn-home-hero__image"
							src="<?php echo esc_url($hero_image_src); ?>"
							<?php if ($hero_image_srcset !== '') : ?>
								srcset="<?php echo esc_attr($hero_image_srcset); ?>"
							<?php endif; ?>
							sizes="(max-width: 900px) 100vw, 50vw"
							alt="<?php esc_attr_e('CoverMeNow ONE dashboard preview', 'cmn-marketing'); ?>"
							loading="lazy"
							decoding="async"
							<?php if ($hero_image_width > 0 && $hero_image_height > 0) : ?>
								width="<?php echo esc_attr((string) $hero_image_width); ?>"
								height="<?php echo esc_attr((string) $hero_image_height); ?>"
							<?php endif; ?>
						>
					</picture>
				</div>
			<?php else : ?>
				<div class="cmn-panel cmn-panel--strong cmn-home-hero__placeholder">
					<p class="cmn-badge cmn-badge--muted">Preview</p>
					<p class="cmn-h3">Dashboard Preview</p>
					<p class="cmn-muted">Add <code>assets/img/hero-laptop.png</code> to display the live hero visual.</p>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
