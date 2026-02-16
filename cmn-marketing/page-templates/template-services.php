<?php
/**
 * Template Name: CMN Services
 * Template Post Type: page
 */

if (!defined('ABSPATH')) {
	exit;
}

get_header();
?>
<main id="cmn-main" class="cmn-services" aria-label="<?php esc_attr_e('Services page content', 'cmn-marketing'); ?>">
	<?php get_template_part('template-parts/services/hero'); ?>
	<?php get_template_part('template-parts/services/modules'); ?>
	<?php get_template_part('template-parts/services/system-overview'); ?>
	<?php get_template_part('template-parts/services/final-cta'); ?>
</main>
<?php get_footer(); ?>
