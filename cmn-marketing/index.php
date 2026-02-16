<?php
if (!defined('ABSPATH')) {
	exit;
}

get_header();
$theme_version = wp_get_theme()->get('Version');
$theme_version = is_string($theme_version) && $theme_version !== '' ? $theme_version : '1.0.0';
?>
<main id="cmn-main" class="cmn-container cmn-main">
	<section class="cmn-panel cmn-install-panel">
		<h1><?php echo esc_html(sprintf('CMN Marketing Theme Installed (v%s)', $theme_version)); ?></h1>
		<p>The cmn-marketing base theme is active and ready for buildout.</p>
	</section>
</main>
<?php get_footer(); ?>
